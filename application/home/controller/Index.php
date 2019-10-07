<?php
/**
 * tpshop
 * ============================================================================
 * * 版权所有 2015-2027 深圳搜豹网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.tpshop.cn
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用 .
 * 不允许对程序代码以任何形式任何目的的再发布。
 * 个人学习免费, 如果商业用途务必到TPshop官网购买授权.
 * 采用最新Thinkphp5助手函数特性实现单字母函数M D U等简写方式
 * ============================================================================
 * $Author: IT宇宙人 2015-08-10 $
 *
 */
namespace app\home\controller;
use think\Exception;
use think\Page;
use think\Verify;
use think\Image;
use think\Db;
class Index extends Base {
    /*
     * 修改订单15-28天收益状态 ,筛选符合条件的
     */
    public function is_withdraw(){
        $time = time();
        $fiften_prafit_rateConf = M('config')->where("name='fiften_prafit_rate'")->value('value');//返现订单数量百分比
        $fifteen_profitConf =  M('config')->where("name='fifteen_profit'")->value('value');//15-28天收益百分比
        $orderCount = M('order')->where('fifteen_days <'.$time.' and fifteen_status = 0  and  pay_status =1 and type=1') ->order('pay_time','asc')->limit($canCount)->count();
        if($orderCount){
            $canCount = ceil(($fiften_prafit_rateConf/100) * $orderCount);
            $canWithdraw = M('order')->field('user_id,order_amount,user_money,order_id')->where('fifteen_days <'.$time.' and fifteen_status = 0  and  pay_status =1 and type=1')
            ->order('pay_time','asc')->limit($canCount)->select();
            $can_receive =  time();//可领取时间向后延长一天
            if(!empty($canWithdraw)){
                foreach($canWithdraw as $k=>$v){
                    $data['user_id'] = $v['user_id'];
                    $data['money'] = ($v['user_money'] + $v['order_amount']) * ($fifteen_profitConf/100);
                    $data['order_id'] = $v['order_id'];
                    $data['add_time'] = time();
                    $data['time_date'] = date('Y-m-d H:i');
                    if(M('fiften_profit')->insert($data)){
                        M('order')->where('order_id',$v['order_id'])->update(['fifteen_status'=>2,'can_receive'=>$can_receive]);
                    }
                }
            }
        }
    }
    
    
    
    
    public function team(){
        $user_id =  input('get.user_id');
        $rs = $this->team_num1($user_id);
        dump($rs);
    }
    
    /***获取团队总人数***/
    function team_num1 ($user_id){
        $user_arr = Db::name('users')->where("find_in_set($user_id,pid_list)")->column('pid_list');
        foreach ($user_arr as &$vo){
            $vo = explode(',',$vo);
        }
        $user_id_arr = [];
        foreach ($user_arr as $v){
            $index_id = array_search($user_id,$v);
            $user_id_arr[] = array_slice($v,$index_id + 1);
        }
        $user_id_where = [];
        foreach ($user_id_arr as $i){
            foreach ($i as $item){
                $user_id_where[] = $item;
            }
        }
        $user_id_where = array_unique($user_id_where);
        //得到所有的下级，查询是否是有效用户
        $s = array();
        if(!empty($user_id_where)){
            foreach($user_id_where as $k=>$v){
                $p = M('order')->where('user_id = '.$v.' and pay_status = 1 and type = 1')->count();
                if($p>0){
                    $s[] = $v;
                    $user = M('order')->field('order_id')->where('user_id='.$v)->select();
                    foreach($user as $k1 => $v1){
                        $rs[] = $this->auto($v1['order_id'],$user_id);
                        $total_money += $this->auto($v1['order_id'],$user_id);
                        
                    }
                }
            }
            dump($rs);
            dump($total_money);
        }
        return $s;
    }
    
    
    
    //根据订单查询用户所有的上级应该得到的分享收益
    public function auto($order_id,$user_id){
        // $order_id =  input('get.order_id');
        $order = M('order')->field('user_id,order_amount,pay_time,user_money')->where('order_id ='.$order_id)->find();
        
        if(($order['order_amount']+$order['user_money']) > 0){
            $userlist = M('users')->field('pid_list')->where('user_id = '.$order['user_id'])->find();
            if($userlist){
                $pidArr = array_reverse(explode(',',$userlist['pid_list']));
                unset($pidArr[0]);
                $conf = M('config')->where('id >=172 and id <=177')->column('value','name');
                $vip_level_conf = M('config')->where('id >=192 and id <=197')->column('value','name');
                $arr = array('171');
                foreach($pidArr as $k=>$v){
                    if($v!=$user_id){
                        unset($pidArr[$k]);
                    }
                }
                foreach($pidArr as $k=>$v){
                    if($v){
                        $s = array();
                        $pidCount = M('users')->where("first_leader ='$v'")->column('user_id');
                        if(!empty($pidCount)){
                            /****计算团队总的有效会员个数****/
                            foreach($pidCount as $k1=>$v1){
                                $order_id = $order['order_id'];
                                $p = M('order')->where("user_id = ".$v1." and pay_status = 1 and type = 1 and pay_time <=".$order['pay_time'])->find();
                                if($p>0){
                                    $s[] = $v1;//计算有多少个下级
                                }
                            }
                            /****计算团队总的有效会员个数****/
                            $userBurn = M('users')->where("user_id = $v")->value('burn');
                            $team_num = team_num($v);//团队总人数
                            // $order_amount = $order['order_amount']+intval($order['user_money']);
                            $order_amount = $order['order_amount']+intval($order['user_money']);
                            if($userBurn == 1){
                                //查询上级最后一个订单的金额，进行烧伤处理
                                // $order_amount = getUserBurn($v,$order['order_amount']+intval($order['user_money']));
                                $order_amount = getUserBurn($v,$order['order_amount']+intval($order['user_money']));
                            }
                            $rela = 0;
                            if($k == 1 || $k == 2){
                                if((count($s) >=20 && $team_num >=300) || in_array($v,$arr)){
                                    $rela = ($vip_level_conf['vip_level_'.$k]/100) * $order_amount;
                                }else if(count($s) >= 1){
                                    $rela = ($conf['level_'.$k]/100) * $order_amount;
                                }
                            }
                            if($k == 3 || $k == 4){
                                if((count($s) >=20 && $team_num >=300) || in_array($v,$arr)){
                                    $rela = ($vip_level_conf['vip_level_'.$k]/100) * $order_amount; //返额10 8 5 3 1 0.5
                                }else if(count($s) >= 6){
                                    $rela = ($conf['level_'.$k]/100) * $order_amount;//返额10 5 3 1
                                }
                            }
                            if($k == 5 || $k == 6){//直推用户大于等于20，团队人数小于等于300
                                if((count($s) >=20 && $team_num >=300) || in_array($v,$arr)){
                                    $rela = ($vip_level_conf['vip_level_'.$k]/100) * $order_amount;
                                }
                            }
                            return $rela;
                        }
                    }
                }
            }
        }else{
            return 0;
        }
    }
    
    
    
    
    
    
    
    //////////////////  /*原版*/
    
    
    public function team2(){
        $user_id =  input('get.user_id');
        $rs = $this->team_num2($user_id);
        dump($rs);
    }
    
    /***获取团队总人数***/
    function team_num2 ($user_id){
        $user_arr = Db::name('users')->where("find_in_set($user_id,pid_list)")->column('pid_list');
        foreach ($user_arr as &$vo){
            $vo = explode(',',$vo);
        }
        $user_id_arr = [];
        foreach ($user_arr as $v){
            $index_id = array_search($user_id,$v);
            $user_id_arr[] = array_slice($v,$index_id + 1);
        }
        $user_id_where = [];
        foreach ($user_id_arr as $i){
            foreach ($i as $item){
                $user_id_where[] = $item;
            }
        }
        $user_id_where = array_unique($user_id_where);
        dump($user_id_where);
        //得到所有的下级，查询是否是有效用户
        $s = array();
        if(!empty($user_id_where)){
            foreach($user_id_where as $k=>$v){
                $p = M('order')->where('user_id = '.$v.' and pay_status = 1 and type = 1')->count();
                if($p>0){
                    $s[] = $v;
                }
            }
        }
        return $s;
    }
    //根据订单查询用户所有的上级应该得到的分享收益
    public function auto2(){
        $order_id =  input('get.order_id');
        $order = M('order')->field('user_id,order_amount,pay_time,user_money')->where('order_id ='.$order_id)->find();
        if($order['order_amount'] > 0){
            //$parentArr = explode(',',$order[''])
            $userlist = M('users')->field('pid_list')->where('user_id = '.$order['user_id'])->find();
            if($userlist){
                $pidArr = array_reverse(explode(',',$userlist['pid_list']));
                unset($pidArr[0]);
                dump($pidArr);
                $conf = M('config')->where('id >=172 and id <=177')->column('value','name');
                $vip_level_conf = M('config')->where('id >=192 and id <=197')->column('value','name');
                $arr = array('171');
                foreach($pidArr as $k=>$v){
                    if($v){
                        $s = array();
                        $pidCount = M('users')->where("first_leader ='$v'")->column('user_id');
                        if(!empty($pidCount)){
                            /****计算团队总的有效会员个数****/
                            foreach($pidCount as $k1=>$v1){
                                $order_id = $order['order_id'];
                                $p = M('order')->where("user_id = ".$v1." and pay_status = 1 and type = 1 and pay_time <=".$order['pay_time'])->find();
                                if($p>0){
                                    $s[] = $v1;//计算有多少个下级
                                }
                            }
                            /****计算团队总的有效会员个数****/
                            $userBurn = M('users')->where("user_id = $v")->value('burn');
                            $team_num = team_num($v);//团队总人数
                            // $order_amount = $order['order_amount']+intval($order['user_money']);
                            $order_amount = $order['order_amount']+intval($order['user_money']);
                            if($userBurn == 1){
                                //查询上级最后一个订单的金额，进行烧伤处理
                                // $order_amount = getUserBurn($v,$order['order_amount']+intval($order['user_money']));
                                $order_amount = getUserBurn($v,$order['order_amount']+intval($order['user_money']));
                            }
                            $rela = 0;
                            if($k == 1 || $k == 2){
                                if((count($s) >=20 && $team_num >=300) || in_array($v,$arr)){
                                    $rela = ($vip_level_conf['vip_level_'.$k]/100) * $order_amount;
                                }else if(count($s) >= 1){
                                    $rela = ($conf['level_'.$k]/100) * $order_amount;
                                }
                            }
                            if($k == 3 || $k == 4){
                                if((count($s) >=20 && $team_num >=300) || in_array($v,$arr)){
                                    $rela = ($vip_level_conf['vip_level_'.$k]/100) * $order_amount; //返额10 8 5 3 1 0.5
                                }else if(count($s) >= 6){
                                    $rela = ($conf['level_'.$k]/100) * $order_amount;//返额10 5 3 1
                                }
                            }
                            if($k == 5 || $k == 6){//直推用户大于等于20，团队人数小于等于300
                                if((count($s) >=20 && $team_num >=300) || in_array($v,$arr)){
                                    $rela = ($vip_level_conf['vip_level_'.$k]/100) * $order_amount;
                                }
                            }
                            dump($v);
                            dump($rela);
                        }
                    }
                }
            }
        }
    }
    
    
    /*原版*/
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    public function index(){
        
        // 如果是手机跳转到 手机模块
        if(isMobile()){
            header("Location:".U('Mobile/Index/index'));
        }
        $hot_goods = $hot_cate = $cateList = $recommend_goods = array();
        $sql = "select a.goods_name,a.goods_id,a.shop_price,a.market_price,a.cat_id,b.parent_id_path,b.name from ".C('database.prefix')."goods as a left join ";
        $sql .= C('database.prefix')."goods_category as b on a.cat_id=b.id where a.is_hot=1 and a.is_on_sale=1 order by a.sort";//二级分类下热卖商品
        $index_hot_goods = S('index_hot_goods');
        if(empty($index_hot_goods))
        {
            $index_hot_goods = Db::query($sql);//首页热卖商品
            S('index_hot_goods',$index_hot_goods,TPSHOP_CACHE_TIME);
        }
        
        if($index_hot_goods){
            foreach($index_hot_goods as $val){
                $cat_path = explode('_', $val['parent_id_path']);
                $hot_goods[$cat_path[1]][] = $val;
            }
        }
        
        $sql2 = "select a.goods_name,a.goods_id,a.shop_price,a.market_price,a.cat_id,b.parent_id_path,b.name from ".C('database.prefix')."goods as a left join ";
        $sql2 .= C('database.prefix')."goods_category as b on a.cat_id=b.id where a.is_recommend=1 and a.is_on_sale=1 order by a.sort";//二级分类下热卖商品
        $index_recommend_goods = S('index_recommend_goods');
        if(empty($index_recommend_goods))
        {
            $index_recommend_goods = Db::query($sql2);//首页推荐商品
            S('index_recommend_goods',$index_recommend_goods,TPSHOP_CACHE_TIME);
        }
        
        if($index_recommend_goods){
            foreach($index_recommend_goods as $va){
                $cat_path2 = explode('_', $va['parent_id_path']);
                $recommend_goods[$cat_path2[1]][] = $va;
            }
        }
        
        $hot_category = M('goods_category')->where("is_hot=1 and level=3 and is_show=1")->cache(true,TPSHOP_CACHE_TIME)->select();//热门三级分类
        foreach ($hot_category as $v){
            $cat_path = explode('_', $v['parent_id_path']);
            $hot_cate[$cat_path[1]][] = $v;
        }
        foreach ($this->cateTrre as $k=>$v){
            if($v['is_hot']==1){
                $v['hot_goods'] = empty($hot_goods[$k]) ? '' : $hot_goods[$k];
                $v['recommend_goods'] = empty($recommend_goods[$k]) ? '' : $recommend_goods[$k];
                $v['hot_cate'] = empty($hot_cate[$k]) ? array() : $hot_cate[$k];
                $cateList[]=$goods_category_tree[] = $v;
            }else{
                $goods_category_tree[] = $v;
            }
        }
        $this->assign('cateList',$cateList);
        $this->assign('goods_category_tree',$goods_category_tree);
        return $this->fetch();
    }
    
    /**
     *  公告详情页
     */
    public function notice(){
        return $this->fetch();
    }
    
    // 二维码
    public function qr_code_raw(){
        ob_end_clean();
        // 导入Vendor类库包 Library/Vendor/Zend/Server.class.php
        //http://www.tp-shop.cn/Home/Index/erweima/data/www.99soubao.com
        //require_once 'vendor/phpqrcode/phpqrcode.php';
        vendor('phpqrcode.phpqrcode');
        //import('Vendor.phpqrcode.phpqrcode');
        error_reporting(E_ERROR);
        $url = urldecode($_GET["data"]);
        \QRcode::png($url);
        exit;
    }
    
    // 二维码
    public function qr_code()
    {
        ob_end_clean();
        vendor('topthink.think-image.src.Image');
        vendor('phpqrcode.phpqrcode');
        
        error_reporting(E_ERROR);
        $url = isset($_GET['data']) ? $_GET['data'] : '';
        $url = urldecode($url);
        $head_pic = input('get.head_pic', '');
        $back_img = input('get.back_img', '');
        $valid_date = input('get.valid_date', 0);
        
        $qr_code_path = UPLOAD_PATH.'qr_code/';
        if (!file_exists($qr_code_path)) {
            mkdir($qr_code_path);
        }
        
        /* 生成二维码 */
        $qr_code_file = $qr_code_path.time().rand(1, 10000).'.png';
        \QRcode::png($url, $qr_code_file, QR_ECLEVEL_M);
        
        /* 二维码叠加水印 */
        $QR = Image::open($qr_code_file);
        $QR_width = $QR->width();
        $QR_height = $QR->height();
        
        /* 添加背景图 */
        if ($back_img && file_exists($back_img)) {
            $back =Image::open($back_img);
            $back->thumb($QR_width, $QR_height, \think\Image::THUMB_CENTER)
            ->water($qr_code_file, \think\Image::WATER_NORTHWEST, 60);//->save($qr_code_file);
            $QR = $back;
        }
        
        /* 添加头像 */
        if ($head_pic) {
            //如果是网络头像
            if (strpos($head_pic, 'http') === 0) {
                //下载头像
                $ch = curl_init();
                curl_setopt($ch,CURLOPT_URL, $head_pic);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                $file_content = curl_exec($ch);
                curl_close($ch);
                //保存头像
                if ($file_content) {
                    $head_pic_path = $qr_code_path.time().rand(1, 10000).'.png';
                    file_put_contents($head_pic_path, $file_content);
                    $head_pic = $head_pic_path;
                }
            }
            //如果是本地头像
            if (file_exists($head_pic)) {
                $logo = Image::open($head_pic);
                $logo_width = $logo->height();
                $logo_height = $logo->width();
                $logo_qr_width = $QR_width / 5;
                $scale = $logo_width / $logo_qr_width;
                $logo_qr_height = $logo_height / $scale;
                $logo_file = $qr_code_path.time().rand(1, 10000);
                $logo->thumb($logo_qr_width, $logo_qr_height)->save($logo_file, null, 100);
                $QR = $QR->thumb($QR_width, $QR_height)->water($logo_file, \think\Image::WATER_CENTER);
                unlink($logo_file);
            }
            if ($head_pic_path) {
                unlink($head_pic_path);
            }
        }
        
        if ($valid_date && strpos($url, 'weixin.qq.com') !== false) {
            $QR = $QR->text('有效时间 '.$valid_date, "./vendor/topthink/think-captcha/assets/zhttfs/1.ttf", 7, '#00000000', Image::WATER_SOUTH);
        }
        $QR->save($qr_code_file, null, 100);
        
        $qrHandle = imagecreatefromstring(file_get_contents($qr_code_file));
        unlink($qr_code_file); //删除二维码文件
        header("Content-type: image/png");
        imagepng($qrHandle);
        imagedestroy($qrHandle);
        exit;
    }
    
    // 验证码
    public function verify()
    {
        //验证码类型
        $type = I('get.type') ? I('get.type') : '';
        $fontSize = I('get.fontSize') ? I('get.fontSize') : '40';
        $length = I('get.length') ? I('get.length') : '4';
        
        $config = array(
            'fontSize' => $fontSize,
            'length' => $length,
            'useCurve' => true,
            'useNoise' => false,
        );
        $Verify = new Verify($config);
        $Verify->entry($type);
        exit();
    }
    
    function truncate_tables (){
        $tables = DB::query("show tables");
        $table = array('tp_admin','tp_config','tp_region','tp_admin_role','tp_system_menu','tp_article_cat','tp_wx_user');
        foreach($tables as $key => $val)
        {
            if(!in_array($val['Tables_in_tpshop2.0'], $table))
                echo "truncate table ".$val['Tables_in_tpshop2.0'].' ; ';
                echo "<br/>";
        }
    }
    
    /**
     * 猜你喜欢
     * @author lxl
     * @time 17-2-15
     */
    public function ajax_favorite(){
        $p = I('p/d',1);
        $i = I('i',5); //显示条数
        $time = time();
        $where = ['is_on_sale'=>1 , 'is_virtual' => ['exp' ,"=0 or virtual_indate > $time"]];
        $favourite_goods = Db::name('goods')->where($where)->order('goods_id DESC')->page($p,$i)->cache(true,TPSHOP_CACHE_TIME)->select();//首页推荐商品
        $this->assign('favourite_goods',$favourite_goods);
        return $this->fetch();
    }
    
    //定时任务
    public function timing_asks()
    {
        $data = Db::name('buy')->alias('a')
        ->join('ywj_order b','a.order_id = b.order_id')
        ->where(['b.pay_status' => 0])
        ->field('a.buy_id,a.add_time')
        ->select();
        $buy_id_arr = [];
        foreach ($data as $vo){
            if((time() - $vo['add_time']) > 600){
                $buy_id_arr[] = $vo['buy_id'];
            }
        }
        Db::startTrans();
        try{
            $order_id_arr = Db::name('buy')->where('buy_id','in',$buy_id_arr)->column('order_id');
            $sell_data = Db::name('buy')->where('buy_id','in',$buy_id_arr)->select();
            foreach ($sell_data as $v){
                Db::name('sell')->where(['sell_id' => $v['sell_id']])->setInc('surplus_num',$v['number']);
            }
            Db::name('order')->where('order_id','in',$order_id_arr)->delete();
            Db::name('buy')->where('buy_id','in',$buy_id_arr)->delete();
            Db::commit();
            return json([
                'code'  =>  1,
                'msg'   =>  '操作成功',
                'data'  =>  []
            ]);
        }catch (Exception $exception){
            Db::rollback();
            return json([
                'code'  =>  -1,
                'msg'   =>  '网络异常',
                'data'  =>  [],
            ]);
        }
    }
    
}