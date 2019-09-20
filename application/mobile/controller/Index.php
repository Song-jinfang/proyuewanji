<?php
/**
 * tpshop
 * ============================================================================
 * * 版权所有 2015-2027 深圳搜豹网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.tp-shop.cn
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用 .
 * 不允许对程序代码以任何形式任何目的的再发布。
 * 采用最新Thinkphp5助手函数特性实现单字母函数M D U等简写方式
 * ============================================================================
 * $Author: 当燃 2016-01-09
 */
namespace app\mobile\controller;

use Think\Db;
use app\common\logic\wechat\WechatUtil;
use think\Request;

class Index extends MobileBase {
    public  $user = array();
    
    /*
     * 初始化方法
     */
    public function _initialize()
    {
        $session_user = session('user');
        if(!$session_user['user_id']){
            header("location:" . U('Mobile/User/login'));
        }
        $this->user = M('users')->where('user_id', $session_user['user_id'])->find();
    }
    
    public function index(){
        $diy_index = M('mobile_template')->where('is_index=1')->field('template_html,block_info')->find();
        if($diy_index){
            $html = htmlspecialchars_decode($diy_index['template_html']);
            $logo=tpCache('shop_info.wap_home_logo');
            $this->assign('wap_logo',$logo);
            $this->assign('html',$html);
            $this->assign('is_index',"1");
            $this->assign('info',$diy_index['block_info']);
            return $this->fetch('index2');
            exit();
        }
        /*
            //获取微信配置
            $wechat_list = M('wx_user')->select();
            $wechat_config = $wechat_list[0];
            $this->weixin_config = $wechat_config;        
            // 微信Jssdk 操作类 用分享朋友圈 JS            
            $jssdk = new \Mobile\Logic\Jssdk($this->weixin_config['appid'], $this->weixin_config['appsecret']);
            $signPackage = $jssdk->GetSignPackage();              
            print_r($signPackage);
        */
        /*热门商品*/
       // $hot_goods = M('goods')->field('goods_id,shop_price,goods_name,original_img')->where("is_hot=1 and is_on_sale=1")->order('goods_id DESC')->limit(8)->select();//首页热卖商品
        $thems = M('goods_category')->where('level=1')->order('sort_order')->limit(9)->cache(true,TPSHOP_CACHE_TIME)->select();
        $this->assign('thems',$thems);
      //  $this->assign('hot_goods',$hot_goods);
        /**商品精选**/
        $new_goods = M('goods')->field('goods_id,original_img,shop_price,market_price,goods_name,sales_sum')->where("is_new=1 and is_on_sale=1")->order('sort DESC')->limit(40)->cache(true,TPSHOP_CACHE_TIME)->select();//
        
        $this->assign('new_goods',$new_goods);
        $goodsCategory = M('goods_category')->field('id,adv_id')->where('is_hot=1')->select();
        if(!empty($goodsCategory)){
            foreach ($goodsCategory as $k=>$v){
                if($v['adv_id']){
                    $adv_link = M('ad')->field('ad_link,ad_code')->where('ad_id ='.$v['adv_id'])->find();
                }
                $goodsInfo = M('goods')->field('goods_id,goods_name,original_img,shop_price')->where('cat_id='.$v['id'].' and is_hot=1')->select();
                $goodsCategory[$k]['ad_link'] = $adv_link['ad_link'];
                $goodsCategory[$k]['ad_code'] = $adv_link['ad_code'];
                $goodsCategory[$k]['goods_info'] = $goodsInfo;
            }
        }
        $this->assign('hot_goods',$goodsCategory);
      
        /**推荐商品**/
        $favourite_goods = M('goods')->field('goods_id,original_img,shop_price,market_price,goods_name,sales_sum')->where("is_recommend=1 and is_on_sale=1")->order('sort DESC')->limit(10)->cache(true,TPSHOP_CACHE_TIME)->select();//首页推荐商品
     /*    $is_recommend = M('goods')->where('') */
        //秒杀商品
        $now_time = time();  //当前时间
        if(is_int($now_time/7200)){      //双整点时间，如：10:00, 12:00
            $start_time = $now_time;
        }else{
            $start_time = floor($now_time/7200)*7200; //取得前一个双整点时间
        }
        $end_time = $start_time+7200;   //结束时间
        $flash_sale_list = Db::name('goods')->alias('g')
            ->field('g.goods_id,f.price,s.item_id')
            ->join('flash_sale f','g.goods_id = f.goods_id','LEFT')
            ->join('__SPEC_GOODS_PRICE__ s','s.prom_id = f.id AND g.goods_id = s.goods_id','LEFT')
            ->where("start_time >= $start_time and end_time <= $end_time and f.is_end=0")
            ->limit(3)->select();

        //判断是否已经领取注册优惠券
        $userInfo = session('user');
        $user_id = $userInfo['user_id'];
        $coupon = Db::name('first_order_coupon')->where(['user_id' => $user_id])->value('id');
        $is_coupon = 1;
        if($coupon){
            $is_coupon =2;
        }
        $status = 1;
        $order_id = Db::name('order')->where(['user_id' => $user_id,'pay_status' => 1])->value('order_id');
        if($order_id){
            $status = 2;
        }
        $action = request()->action();
        $controller = request()->controller();
        $data = Db::name('home_class')->select();
        $this->assign('status',$status);
        $this->assign('is_coupon',$is_coupon);
        $this->assign('action',$action);
        $this->assign('data',$data);
        $this->assign('controller',$controller);
        $this->assign('flash_sale_list',$flash_sale_list);
        $this->assign('start_time',$start_time);
        $this->assign('end_time',$end_time);
        $this->assign('favourite_goods',$favourite_goods);
        return $this->fetch();
    }

    //领取注册优惠券
    public function first_order_coupon()
    {
        $userInfo = $this->user;
        $user_id = $userInfo['user_id'];
        $id = Db::name('first_order_coupon')->where(['user_id' => $user_id,'type' => 1])->value('id');
        if($id){
            return json([
                'code'  =>  -1,
                'msg'   =>  '您已领取过次优惠券',
                'data'  =>  [],
            ]);
        }else{
            Db::name('first_order_coupon')->insert([
                'user_id'  =>  $user_id,
                'add_time' =>   time(),
                'type'     =>   1,
            ]);
            $register_integral = Db::name('config')->where(['name' => 'register_integral'])->value('value');
            accountLog($user_id,0,$register_integral,'领取注册首页积分');
            return json([
                'code'  =>  1,
                'msg'   =>  '恭喜您，领取成功',
                'data'  =>  [],
            ]);
        }
    }
    
    
    
    /*
     * 测试定订单支付
     */
    
    public function test_order(){
        update_pay_status('201909191553474602');
    }
    
    public function test(){
        dump(time());
        dump(strtotime('+7 day'));
        
    }
    
    public function connect(){
        
        return $this->fetch();
    }
    
    
    
    /*
     * APP下载
     */
    public function download(){
        return $this->fetch();
    }
    
    /*
     * 广告列表 
     * 
     */
    public function adv_list(){
        $order_id = !empty(I('get.order_id'))?I('get.order_id'):'';
        if($order_id){
            $this->assign('order_id',$order_id);
        }
        $task_list = M('task')->alias('a')->field("a.id,a.desc,a.price,FROM_UNIXTIME(a.add_time,'%Y-%m-%d') add_time,a.total_num,a.num,b.head_pic")
                    ->join('users b','a.uid = b.user_id','left')->where('a.status = 1')->select();
        if(!empty($task_list)){
            foreach($task_list as $k=>$v){
                $task_list[$k]['num'] = $v['total_num'] - $v['num'];
            }
        }
        $this->assign('task_list',$task_list);
        return $this->fetch();
    }
    /*
     * 广告详情页面
     */
    public function adv_details(){
        $param = I('get.');
        $id = $param['id'];
        $order_id = $param['order_id'];
        if($id){
            $taskInfo = M('task')->field("id,desc,content,thumb_img,price,time_len,description")->where('id='.$id)->find();
            if($taskInfo['thumb_img']){
                $taskInfo['thumb_img'] = explode(',',$taskInfo['thumb_img']);
            }
            $this->assign('task_info',$taskInfo);
        }
        $this->assign('order_id',$order_id);
        return $this->fetch();
    }
    /*
     * 查询该广告是否已经浏览
     */
    
    public function is_show(){
        $task_id = I('post.task_id');
        $time = strtotime(date('Y-m-d'));
        $task_count = M('user_task')->where('add_time > '.$time.' and user_id='.$this->user['user_id'].' and  task_id= '.$task_id)->count();
        if($task_count > 0){
            $this->ajaxReturn(['status' => -1, 'msg' => '已经浏览过了']);
        }else{
            $this->ajaxReturn(['status' => 1, 'msg' => '可以浏览']);
        }
    }
    
    /*
     * 浏览广告获得积分
     */
    public function get_integral(){
         //0撸的加入到积分去
          $param = I('post.');
          $order_id = !empty($param['order_id'])?$param['order_id']:'';
          $task_id = $param['task_id'];
          $data['type'] = 2;
          if($order_id){
              $orderConf = M('config')->where("name='adv_order'")->value('value'); 
              //说明是订单广告，直接按订单百分一
              $orderInfo = M('order')->field('order_amount,order_id')->where('order_id='.$order_id)->find();
             //订单广告收益
              $orderAdvProfit = $orderInfo['order_amount'] * ($orderConf/100);
              adv_order($this->user['user_id'],$orderAdvProfit,'完成浏览广告获得经验值',$order_id,2);
              $price = $orderAdvProfit;
                M('task')->where('id = '.$task_id)->setInc('num');
              $data['user_id'] = $this->user['user_id'];
              $data['task_id'] = $task_id;
              $data['status'] = 1;
              $data['add_time'] = time();
              $data['task_money'] = $price;
              $data['order_id'] = $order_id;
              M('user_task') ->add($data);
              $this->ajaxReturn(['status'=>0,'msg'=>'获得'.$price.'个积分']);
          }else{
              $time = strtotime(date('Y-m-d'));
              $task_count = M('user_task')->where('add_time > '.$time.' and user_id='.$this->user['user_id'])->count();
              $taskinfo = M('task')->where('id='.$task_id)->find();
              //0撸和或者会员浏览广告
              $orderCount = M('order')->where('user_id='.$this->user['user_id'].' and pay_status = 1')->count();
              M('task')->where('id = '.$task_id)->setInc('num');
              if(!$orderCount){
                  accountLog($this->user['user_id'],0,$taskinfo['price'],'浏览广告获得积分');
                  $price = $taskinfo['price'];
                  $data['user_id'] = $this->user['user_id'];
                  $data['task_id'] = $task_id;
                  $data['status'] = 1;
                  $data['add_time'] = time();
                  $data['task_money'] = $price;
                  $data['order_id'] = $order_id;
                  M('user_task') ->add($data);
                  $this->ajaxReturn(['status'=>0,'msg'=>'获得'.$price.'个积分']);
                  
              }
              //$this->ajaxReturn(['status'=>0,'msg'=>'获得0个积分']);
          }
    }
    /*
     * 分享
     */
    public function share(){
        //调用查看结果
        $info = M('users')->where('user_id',$this->user['user_id'])->find();
        $this->assign('info',$info);
        return $this->fetch();
    } 
    
    public function fileupload(){
        
        return $this->fetch();
    }

    public function explain()
    {
        return $this->fetch();
    }
    public function strategy()
    {
        return $this->fetch();
    }
    public function ajaxFileUpload(){
       // $file = request()->file();
      $dir_base ='fileupload/';//配置你的上传目录
      $index = 0;
        foreach($_FILES as $file){
            $upload_file_name = 'upload_file' . $index;
            $filename = $_FILES[$upload_file_name]['name'];
            $fileExt=strtolower(trim(array_pop(explode('.',$filename))));
            $filename=time().'.'.$fileExt;
            if(!file_exists($dir_base.$filename)) {
                $isMoved = false;
                $rEFileTypes = '/^\.(jpg|jpeg|gif|png|mp4|qlv){1}$/i';
                if(preg_match($rEFileTypes, strrchr($filename, '.'))) {
                    $isMoved =move_uploaded_file ( $_FILES[$upload_file_name]['tmp_name'], $dir_base.$filename);
                }
            }else{
                $isMoved = true;
            }
            if($isMoved){
                $output = $dir_base.$filename;
            }else {
                $output= "";
            }
            $index++;
        }
        if($output){
            $this->ajaxReturn(['status' => 1, 'msg' => '成功', 'img' =>$output]);
        }
}
    
    
    public function index2(){
        $id=I('get.id');  
        $role=I('get.role'); 

        if($role){
            $arr=M('industry_template')->where('id='.$id)->field('template_html,block_info')->find();
        }else{
            if($id){
                $arr=M('mobile_template')->where('id='.$id)->field('template_name ,template_html,block_info,is_index')->find();
            }else{
                $arr=M('mobile_template')->order('id DESC')->limit(1)->field('template_name ,template_html,block_info,is_index')->find();
            } 
        }

        $html=htmlspecialchars_decode($arr['template_html']);
        $logo=tpCache('shop_info.wap_home_logo');
        $this->assign('wap_logo',$logo);
        $this->assign('html',$html);
        $this->assign('is_index',$arr['is_index']); //是否为首页, 如果不是首页, 则显示"返回"按钮
        $this->assign('info',$arr['block_info']);
        $this->assign('template_name',$arr['template_name']);
        return $this->fetch();
    }

    //商品列表板块参数设置
    public function goods_list_block(){
        $data=I('post.');
        $sql_where = input('sql_where');
        // 13时，轮播传的是sql_where
        if($sql_where){
            if(!empty($sql_where['label']) && !isset($data['label'])){
                $data['label'] = $sql_where['label'];
            }
            if(!empty($sql_where['ids']) && !isset($data['ids'])){
                $data['ids'] = $sql_where['ids'];
            }
            if(!empty($sql_where['min_price']) && !empty($sql_where['max_price']) && $sql_where['min_price'] < $sql_where['max_price']){
                $data['min_price'] = $sql_where['min_price'];
                $data['max_price'] = $sql_where['max_price'];
            }
        }


        $block = new \app\common\logic\Block();
        $goodsList = $block->goods_list_block($data);

        $html='';
        if($data['block_type']==13){
            foreach ($goodsList as $k => $v) {
                $html.='<div class="containers-slider-item">';
                $html.='<div class="seckill-item-img">';
                $html.='<a href="/Mobile/Goods/goodsInfo/id/'.$v["goods_id"].'"><img src="'.$v["original_img"].'" /></a>';
                $html.='</div>';
                $html.='<div class="seckill-item-name"><p>'.$v["goods_name"].'</p></div>';
                $html.='<div class="seckill-item-price" class="p"><span class="fl">￥<em>'.$v['shop_price'].'</em></span>';
                $html.='</div></div>';
            }
        }else{
            foreach ($goodsList as $k => $v) {
                $html.='<li>';
                $html.='<a class="tpdm-goods-pic" href="/Mobile/Goods/goodsInfo/id/'.$v["goods_id"].'"><img src="'.$v["original_img"].'" alt="" /></a>';
                $html.='<a href="/Mobile/Goods/goodsInfo/id/'.$v["goods_id"].'" class="tpdm-goods-name">'.$v["goods_name"].'</a>';
                $html.='<div class="tpdm-goods-des">';
                $html.='<div class="tpdm-goods-price">￥'.$v['shop_price'].'</div>';
                $html.='<a class="tpdm-goods-like">'.$v["comment_count"].'条评论</a>'; 
                $html.='</div>';
                $html.='</li>';
            } 
        }
        $this->ajaxReturn(['status' => 1, 'msg' => '成功', 'result' =>$html]);
    }


    //自定义页面获取秒杀商品数据
    public function get_flash(){
        $now_time = time();  //当前时间
        if(is_int($now_time/7200)){      //双整点时间，如：10:00, 12:00
            $start_time = $now_time;
        }else{
            $start_time = floor($now_time/7200)*7200; //取得前一个双整点时间
        }
        $end_time = $start_time+7200;   //结束时间
        $flash_sale_list = M('goods')->alias('g')
            ->field('g.goods_id,g.original_img,g.shop_price,f.price,s.item_id')
            ->join('flash_sale f','g.goods_id = f.goods_id','LEFT')
            ->join('__SPEC_GOODS_PRICE__ s','s.prom_id = f.id AND g.goods_id = s.goods_id','LEFT')
            ->where("start_time = $start_time and end_time = $end_time and is_end = 0")
            ->limit(4)->select();
        $str='';
        if($flash_sale_list){
            foreach ($flash_sale_list as $k => $v) {
                $str.='<a href="'.U('Mobile/Activity/flash_sale_list').'">';
                $str.='<img src="'.$v['original_img'].'" alt="" />';
                $str.='<span>￥'.$v['price'].'</span>';
                $str.='<i>￥'.$v['shop_price'].'</i></a>';
            }
        }
        $time=date('H',$start_time);
        $this->ajaxReturn(['status' => 1, 'msg' => '成功','html' => $str, 'start_time'=>$time, 'end_time'=>$end_time]);
    }


    /**
     * 分类列表显示
     */
    public function categoryList(){
        return $this->fetch();
    }

    /**
     * 模板列表
     */
    public function mobanlist(){
        $arr = glob("D:/wamp/www/svn_tpshop/mobile--html/*.html");
        foreach($arr as $key => $val)
        {
            $html = end(explode('/', $val));
            echo "<a href='http://www.php.com/svn_tpshop/mobile--html/{$html}' target='_blank'>{$html}</a> <br/>";            
        }        
    }

    /**
     * 门店列表
     * province,如果有省名，传省名字
     * lng,lat,search_radius，经伟度，查找半径范围内的门店
     */
    public function shopList(){
        $data = input('param.');
        if(isset($data['province'])){
            $province_id = Db::name('region')->where('name',$data['province'])->value('id');
            if($province_id){
                $where['province_id'] = $province_id;
            }
        }
        $where['deleted'] = 0;
        $where['shop_status'] = 1;
        $shop_list = Db::name('shop')->field('shop_id,shop_name,province_id,city_id,district_id,shop_address,longitude,latitude,deleted,shop_desc')->where($where)->select();
        $shop_logic = new \app\common\logic\Shop();
        $shop_list = $shop_logic->filterDistance($shop_list,$data['lng'], $data['lat'],$data['search_radius']);
        $this->ajaxReturn(['status' => 1, 'result' => $shop_list]);
    }
    public function newsList(){
        $ids = input('ids');
        if($ids){
            $ids_arr = explode(',',$ids);
            $where['article_id'] = ['in', $ids_arr];
        }
        $num = input('new_num/d', 2);
        $num = $num > 10 ? $num : $num;
        $where['publish_time'] = ['elt',time()];
        $where['is_open'] = 1;
        $list= Db::view('news')
            ->view('newsCat','cat_name','newsCat.cat_id=news.cat_id','left')
            ->where($where)
            ->order('publish_time DESC')
            ->limit($num)
            ->select();
        foreach($list as $k=>$v){
            $list[$k]['content'] = htmlspecialchars_decode($list[$k]['content']);
        }
        $this->ajaxReturn(['status' => 1, 'result' => $list]);
    }
    public function news_list(){
        return $this->fetch();
    }
    public function ajax_news_list(){
        $page = input('page/d', 1);
        $where['publish_time'] = ['elt',time()];
        $where['is_open'] = 1;
        $list= Db::view('news')
            ->view('newsCat','cat_name','newsCat.cat_id=news.cat_id','left')
            ->where($where)
            ->order('publish_time DESC')
            ->page($page, 10)
            ->select();
        foreach($list as $k=>$v){
            $list[$k]['content'] = htmlspecialchars_decode($list[$k]['content']);
        }
        $this->ajaxReturn(['status' => 1, 'result' => $list]);
    }

    /**
     * 商品列表页
     */
    public function goodsList(){
        $id = I('get.id/d',0); // 当前分类id
        $lists = getCatGrandson($id);
        $this->assign('lists',$lists);
        return $this->fetch();
    }
    
/*     public function ajaxGetMore(){
    	$p = I('p/d',1);
        $where = [
            'is_recommend' => 1,
            'exchange_integral'=>0,  //积分商品不显示
            'is_on_sale' => 1,
            'virtual_indate' => ['exp', ' = 0 OR virtual_indate > ' . time()]
        ];
    	$favourite_goods = Db::name('goods')->where($where)->order('sort DESC')->page($p,C('PAGESIZE'))->cache(true,TPSHOP_CACHE_TIME)->select();//首页推荐商品
    	$this->assign('favourite_goods',$favourite_goods);
    	return $this->fetch();
    } */
    public function ajaxGetMore(){
        $p = I('p/d',1);
        $pageNum = 10;
        $where = [
            'is_new' => 1,
            'is_on_sale' => 1,
        ];
        $count = M('goods')->where($where)->count();
        $Page  = new \think\Page($count,4);
        $off = $p * $pageNum;
        $favourite_goods = M('goods')->where($where)->order('sort desc')->limit($off.','.$pageNum)->select();
        $this->assign('favourite_goods',$favourite_goods);
        return $this->fetch();
    }
    
    
    
    //微信Jssdk 操作类 用分享朋友圈 JS
    public function ajaxGetWxConfig()
    {
        $askUrl = input('askUrl');//分享URL
        $askUrl = urldecode($askUrl);

        $wechat = new WechatUtil;
        $signPackage = $wechat->getSignPackage($askUrl);
        if (!$signPackage) {
            exit($wechat->getError());
        }

        $this->ajaxReturn($signPackage);
    }
    /**
     * APP下载地址, 如果APP不存在则显示WAP端地址
     * @return \think\mixed
     */
    public function app_down(){

        $server_host = 'http://'.$_SERVER['HTTP_HOST'];
        $showTip = false;
        if(tpCache('ios.app_path') && strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone')||strpos($_SERVER['HTTP_USER_AGENT'], 'iPad')){
            //苹果:直接指向AppStore下载
            $down_url = tpCache('ios.app_path');
        }else if(tpCache('android.app_path') && strpos($_SERVER['HTTP_USER_AGENT'], 'Android')){
            // 安卓:需要拼接下载地址
            $down_url = $server_host.'/'.tpCache('android.app_path');
            //如果是安卓手机微信打开, 则显示"其他浏览器打开"提示
            (strstr($_SERVER['HTTP_USER_AGENT'],'MicroMessenger') && strpos($_SERVER['HTTP_USER_AGENT'], 'Android')) && $showTip = true;
        }

        $wap_url = $server_host.'/Mobile';
        /*  echo "down_url : ".$down_url;
         echo "wap_url : ".wap_url;
         echo "<br/>showTip : ".$showTip; */
        $this->assign('showTip' , $showTip);
        $this->assign('down_url' , $down_url);
        $this->assign('wap_url' , $wap_url);
        return $this->fetch();
    }
}