<?php
namespace app\mobile\controller;
use app\common\logic\GoodsLogic;
use app\common\model\FlashSale;
use app\common\model\GroupBuy;
use app\common\model\PreSell;
use think\Db;
use think\Exception;
use think\Page;
use app\common\logic\ActivityLogic;

class Ad extends MobileBase
{
    public $user = array();

    public function _initialize()
    {
        $session_user = session('user');
        if(!$session_user['user_id']){
            header("location:" . U('Mobile/User/login'));
        }
        $this->user = M('users')->where('user_id', $session_user['user_id'])->find();
    }

    public function put()
    {
        if(request()->isGet()){
            $adv_price = M('config')->where(['name' => 'adv_pic_price'])->value('value');
            $adv_price1 = M('config')->where(['name' => 'adv_video_price'])->value('value');
            $this->assign('pic_price',$adv_price);
            $this->assign('video_price',$adv_price1);
            return $this->fetch();
        }else{
            $data = request()->file('images') ?: [];
            $type = request()->post('type') ?: "";
            $number = request()->post('number') ?: "";
            $description = request()->post('description') ?: "";
            $desc = request()->post('desc') ?: "";
            if(!($type || $number || $description || $data || $desc)){
                return json([
                    'code'  =>  -1,
                    'msg'   =>  '缺少必要参数',
                    'data'  =>  [],
                ]);
            }
            $res = [];
            foreach ($data as $file){
                $info = $file->move(ROOT_PATH . 'public' . DS . 'ad');
                $res[] = '/public/ad/' . $info->getSaveName();
            }
            $file_path = implode(',',$res);
            if(!$file_path){
                return json([
                    'code'  =>  -1,
                    'msg'   =>  '缺少必要参数',
                    'data'  =>  [],
                ]);
            }
            $session_user = session('user');
            $uid = $session_user['user_id'];
            $adv_price = M('config')->where(['name' => 'adv_pic_price'])->value('value');
            $adv_price1 = M('config')->where(['name' => 'adv_video_price'])->value('value');
            $beans_price = M('config')->where(['name' => 'beans_price'])->value('value');
            if($type == 1){
                $total_price = $adv_price * $number;
            }else{
                $total_price = $adv_price1 * $number;
            }
            $have_price  = M('users')->where(['user_id' => $uid])->value('happy_beans');
            $ywd_num  = ceil($total_price * 0.1);
            $total_price += $ywd_num;
            $total_amount = $total_price;
//            if($have_price < $total_price){
//                return json([
//                    'code'  =>  -1,
//                    'msg'   =>  '余额不足',
//                    'data'  =>  [],
//                ]);
//            }
            Db::startTrans();
            try{
                if($have_price < $ywd_num){
                    $ywd_number = $ywd_num - $have_price;
                    $total_price = $total_price - $ywd_number;
                    $price = 0;
                }else{
                    $ywd_number = $ywd_num;
                    $total_price -= $ywd_num;
                    $price = $have_price - $ywd_num;
                }
                D('users')->where(['user_id' => $uid])->update(['happy_beans' => $price]);

                $order['order_sn'] = date('YmdHis',time()) . rand(1000,9999);
                $order['user_id']  = $uid;
                $order['total_amount'] = $total_amount;
                $order['ywd_price'] = $ywd_number;
                $order['order_amount'] = $total_price;
                $order['add_time'] = time();
                $order['type'] = 3;
                $order_id = D('order')->add($order);

                $response['type'] = 2;
                $response['status'] = 0;
                $response['add_time'] = time();
                $response['description'] = $description;
                $response['desc'] = $desc;
                $response['thumb_img'] = $file_path;
                $response['total_num'] = $number;
                $response['uid'] = $uid;
                $response['order_id'] = $order_id;
                $response['identity'] = 2;
                $response['adv_type'] = $type;
                D('task')->add($response);

                $log['user_id'] = $uid;
                $log['user_money'] = '-' . $ywd_number;
                $log['add_time'] = time();
                $log['desc']    = "消耗悦玩豆";
                $log['type']    = 1;
                D('adv_log')->add($log);

                Db::commit();
                return json([
                    'code'  =>  1,
                    'msg'   =>  '购买成功',
                    'data'  =>  [
                        'order_id'  =>  $order_id,
                        'http'      =>  $_SERVER['SERVER_NAME']
                    ],
                ]);
            }catch (Exception $exception){
                Db::rollback();
                return json([
                    'code'  =>  -1,
//                    'msg'   =>  $exception->getMessage(),
                    'msg'   =>  '网络异常，请重新购买',
                    'data'  =>  [],
                ]);
            }
        }
    }

    public function home()
    {
        if(request()->isGet()){
            $session_user = session('user');
            $uid = $session_user['user_id'];
            $have_price  = M('users')->where(['user_id' => $uid])->value('happy_beans');
            $this->assign('have_price',$have_price);
            return $this->fetch();
        }else{
            $data = request()->post();
            //加密  encrypt
            if(!($data['id'] || $data['pwd'] || $data['number'])){
                return json([
                    'code'  =>  -1,
                    'msg'   =>  '缺少必要参数',
                    'data'  =>  []
                ]);
            }
            $session_user = session('user');
            $uid = $session_user['user_id'];
            $password = D('users')->where(['user_id' => $uid])->value('password');
            $have_price = D('users')->where(['user_id' => $uid])->value('happy_beans');
            $password1 = encrypt($data['pwd']);
            if($password != $password1){
                return json([
                    'code'  =>  -1,
                    'msg'   =>  '密码错误，请重新输入',
                    'data'  =>  [],
                ]);
            }
            if($have_price < $data['number']){
                return json([
                    'code'  =>  -1,
                    'msg'   =>  '您的余额不足，请重新输入数值或充值',
                    'data'  =>  [],
                ]);
            }
            Db::startTrans();
            try{
                $pay_id = D('users')->where(['mobile' => $data['id']])->value('user_id');
                D('users')->where(['mobile' => $data['id']])->setInc('happy_beans',$data['number']);
                D('users')->where(['user_id' => $uid])->setDec('happy_beans',$data['number']);
                D('turn_out')->add([
                    'uid'      =>  $uid,
                    'pay_id'   => $pay_id,
                    'add_time' => time(),
                    'mobile'   => $data['id'],
                    'number'   => $data['number'],
                ]);
                Db::commit();
                return json([
                    'code'  =>  1,
                    'msg'   =>  '转让成功',
                    'data'  =>  [],
                ]);
            }catch (Exception $exception){
                Db::rollback();
                return json([
                    'code'  =>  -1,
                    'msg'   =>  '转让失败',
                    'data'  =>  [],
                ]);
            }
        }
    }

    //订单
    public function mine()
    {
        if(request()->isGet()){
            $session_user = session('user');
            $uid = $session_user['user_id'];
            $user_info = D('users')->where(['user_id' => $uid])->field('nickname,happy_beans,user_id,head_pic')->find();
            $data = D('order')->where(['user_id' => $uid,'pay_status' => 1,'type' => 2])->field('add_time,ywd_price')->select();
            $this->assign('user_info',$user_info);
            $this->assign('data',$data);
            return $this->fetch();
        }
    }

    //转让
    public function mine1()
    {
        if(request()->isGet()){
            $session_user = session('user');
            $uid = $session_user['user_id'];
            $user_info = D('users')->where(['user_id' => $uid])->field('nickname,happy_beans,user_id,head_pic')->find();
            $data = D('turn_out')->where(['uid' => $uid])->select();
            $this->assign('data',$data);
            $this->assign('user_info',$user_info);
            return $this->fetch();
        }
    }

    //个人广告列表
    public function ad_list()
    {
        $userInfo = session('user');
        $uid = $userInfo['user_id'];
        $data = D('task')->alias('a')
                ->join('order b','a.order_id = b.order_id','left')
                ->where(['a.uid' => $uid])
                ->field('a.*,b.total_amount')
                ->select();
        foreach ($data as &$vo){
            $vo['thumb_img'] = explode(',',$vo['thumb_img']);
        }
        $this->assign('data',$data);
        return $this->fetch();
    }

    //广告详情页
    public function details()
    {
        $id = request()->get('id');
        $data = D('task')->where(['id' => $id])->find();
        $data['thumb_img'] = explode(',',$data['thumb_img']);
        $this->assign('data',$data);
        return $this->fetch();
    }

    //更新广告
    public function update_adv()
    {
        $data = request()->post();
        $id = $data['id'];
        unset($data['id']);
        $files = request()->file('images') ?: [];
        $res = [];
        if($files){
            foreach ($files as $file){
                $info = $file->move(ROOT_PATH . 'public' . DS . 'ad');
                $res[] = '/public/ad/' . $info->getSaveName();
            }
        }
        if($res){
            $file_path = implode(',',$res);
            $data['thumb_img'] = $file_path;
        }
        $response = D('task')->where(['id' => $id])->update($data);
        if($response === false){
            return json([
                'code'  =>  -1,
                'msg'   =>  '更新失败',
                'data'  =>  $data
            ]);
        }else{
            return json([
                'code'  =>  1,
                'msg'   =>  '更新成功',
                'data'  =>  $data
            ]);
        }
    }

    //购买悦玩豆
    public function buy_ywd()
    {
        $number = request()->post('number');
        if(!$number){
            return json([
                'code'  =>  -1,
                'msg'   =>  '缺少必要参数',
                'data'  =>  [],
            ]);
        }
        Db::startTrans();
        try{
            $beans_price = M('config')->where(['name' => 'beans_price'])->value('value');
            $userInfo = session('user');
            $user_id = $userInfo['user_id'];
            $order['order_sn'] = date('YmdHis',time()) . rand(1000,9999);
            $order['user_id']  = $user_id;
            $order['total_amount'] = $number * $beans_price;
            $order['order_amount'] = $number * $beans_price;
            $order['ywd_price'] = $number;
            $order['type'] = 2;
            $order['add_time'] = time();
            $order_id = D('order')->add($order);

            $log['user_id'] = $userInfo['user_id'];
            $log['user_money'] = $number;
            $log['add_time'] = time();
            $log['desc']    = "购买悦玩豆";
            $log['type']    = 1;
            D('adv_log')->add($log);
            Db::commit();
            return json([
                'code'  =>  1,
                'msg'   =>  '购买成功',
                'data'  =>  [
                    'order_id'  =>  $order_id,
                    'http'      =>  $_SERVER['SERVER_NAME']
                ],
            ]);
        }catch (Exception $exception){
            Db::rollback();
            return json([
                'code'  =>  -1,
//                    'msg'   =>  $exception->getMessage(),
                'msg'   =>  '网络异常，请重新购买',
                'data'  =>  [],
            ]);
        }
    }

    //添加话题
    public function add_forum()
    {
        if(request()->isGet()){
            $userInfo = session('user');
            $user_id = $userInfo['user_id'];
            $this->assign('user_id',$user_id);
            return $this->fetch();
        }else{
            $data = request()->file('images') ?: [];
            $post_data = request()->post();
            $res = [];
            foreach ($data as $file){
                $info = $file->move(ROOT_PATH . 'public' . DS . 'ad');
                $res[] = '/public/ad/' . $info->getSaveName();
            }
            $userInfo = session('user');
            $user_id = $userInfo['user_id'];
            if($user_id != 1){
                $type = 2;
            }else{
                $type = 1;
            }
            Db::startTrans();
            try{
                $forum_id = D('forum')->add([
                                'title'    =>  $post_data['title'],
                                'add_time' =>  time(),
                                'user_id'  =>  $user_id,
                                'type'     =>  $type,
                                'goods_id' =>   $data['goods_id']
                            ]);
                $photo_data = [];
                $num = 0;
                foreach ($res as $vo){
                    $photo_data[$num]['forum_id'] = $forum_id;
                    $photo_data[$num]['photo_address'] = $vo;
                    $num++;
                }
                Db::name('forum_photo')->insertAll($photo_data);
                Db::commit();
                return json([
                    'code'  =>  1,
                    'msg'   =>  '发布成功',
                    'data'  =>  [],
                ]);
            }catch (Exception $exception){
                Db::rollback();
                return json([
                    'code'  =>  -1,
//                    'msg'   =>  $exception->getMessage(),
                    'msg'   =>  '发布失败',
                    'data'  =>  []
                ]);
            }
        }
    }

    //话题列表
    public function forum_list()
    {
        $data = Db::name('forum')->alias('a')
                ->join('ywj_users b','a.user_id = b.user_id')
                ->join('ywj_goods c','a.goods_id = c.goods_id','left')
                ->field('a.*,b.nickname,b.head_pic,c.goods_name,c.original_img')
                ->order('a.add_time','desc')
                ->select();
        foreach ($data as &$vo){
            $vo['photo_list'] = Db::name('forum_photo')->where(['forum_id' => $vo['forum_id']])->column('photo_address');
            $vo['comment_list'] = Db::name('forum_comment')->alias('a')
                                    ->join('ywj_users b','a.user_id = b.user_id')
                                    ->where(['a.forum_id' => $vo['forum_id']])
                                    ->field('a.*,b.nickname')
                                    ->order('a.add_time','desc')
                                    ->limit(3)
                                    ->select();
            $vo['comment_count'] = Db::name('forum_comment')->where(['forum_id' => $vo['forum_id']])->count();
            $vo['like_count']    = Db::name('forum_like')->where(['forum_id' => $vo['forum_id']])->count();
        }
//        dump($data);die;
        $this->assign('data',$data);
        return $this->fetch();
    }

    //全部评论
    public function all_comment()
    {
        $forum_id = request()->post('forum_id');
        $data = Db::name('forum_comment')->alias('a')
                ->join('ywj_users b','a.user_id = b.user_id')
                ->where(['a.forum_id' => $forum_id])
                ->field('a.*,b.nickname')
                ->order('a.add_time','desc')
                ->select();
        $html = "";
        foreach ($data as $vo){
            $html .= "<li>";
            $html .= "<span>";
            $html .= $vo['nickname'];
            $html .= "：</span>";
            $html .= "<font>";
            $html .= $vo['content'];
            $html .= "</font>";
            $html .= "</li>";
        }
        return json([
            'code'  =>  1,
            'msg'   =>  '操作成功',
            'data'  =>  $html,
        ]);
    }

    public function all_comment_limit()
    {
        $forum_id = request()->post('forum_id');
        $data = Db::name('forum_comment')->alias('a')
            ->join('ywj_users b','a.user_id = b.user_id')
            ->where(['a.forum_id' => $forum_id])
            ->field('a.*,b.nickname')
            ->order('a.add_time','desc')
            ->limit(3)
            ->select();
        $html = "";
        foreach ($data as $vo){
            $html .= "<li>";
            $html .= "<span>";
            $html .= $vo['nickname'];
            $html .= "：</span>";
            $html .= "<font>";
            $html .= $vo['content'];
            $html .= "</font>";
            $html .= "</li>";
        }
        return json([
            'code'  =>  1,
            'msg'   =>  '操作成功',
            'data'  =>  $html,
        ]);
    }

    //添加评论
    public function add_comment()
    {
//        $data = request()->post();
//        return json($data);
        $forum = request()->post('forum_id');
        $content  = request()->post('content');
        $forum = explode('-',$forum);
        $forum_id = $forum[1];
        if(!($forum_id || $forum_id)){
            return json([
                'code'  =>  1,
                'msg'   =>  '评论失败，请重新再试',
                'data'  =>  [],
            ]);
        }
        $userInfo = session('user');
        $user_id = $userInfo['user_id'];
        Db::name('forum_comment')->insert([
            'forum_id' => $forum_id,
            'user_id'  => $user_id,
            'content'  => $content,
            'add_time' => time(),
        ]);
        $data = Db::name('forum_comment')->alias('a')
            ->join('ywj_users b','a.user_id = b.user_id')
            ->where(['a.forum_id' => $forum_id])
            ->field('a.*,b.nickname')
            ->order('a.add_time','desc')
            ->limit(3)
            ->select();
        $count = Db::name('forum_comment')->where(['forum_id' => $forum_id])->count();
        $html = "";
        foreach ($data as $vo){
            $html .= "<li>";
            $html .= "<span>";
            $html .= $vo['nickname'];
            $html .= "：</span>";
            $html .= "<font>";
            $html .= $vo['content'];
            $html .= "</font>";
            $html .= "</li>";
        }
        return json([
            'code'  =>  1,
            'msg'   =>  '操作成功',
            'data'  =>  ['html_str' => $html,'forum_id' => $forum_id,'count' => $count],
        ]);
    }

    //点赞
    public function add_like()
    {
        $forum_id = request()->post('forum_id');
        $userInfo = session('user');
        $user_id = $userInfo['user_id'];
        if(!($forum_id || $user_id)){
            return json([
                'code'  =>  -1,
                'msg'   =>  '取消成功',
                'data'  =>  [],
            ]);
        }
        $like_id = Db::name('forum_like')->where(['forum_id' => $forum_id,'user_id' => $user_id])->value('like_id');
        if($like_id){
            Db::name('forum_like')->where(['like_id' => $like_id])->delete();
            $count = Db::name('forum_like')->where(['forum_id' => $forum_id])->count();
            return json([
                'code'  =>  2,
                'msg'   =>  '取消成功',
                'data'  =>  ['count' => $count,'forum_id' => $forum_id],
            ]);
        }else{
            Db::name('forum_like')->insert([
                'forum_id'  => $forum_id,
                'user_id'   => $user_id,
                'add_time'  => time(),
            ]);
            $count = Db::name('forum_like')->where(['forum_id' => $forum_id])->count();
            return json([
                'code'  =>  1,
                'msg'   =>  '点赞成功',
                'data'  =>  ['count' => $count,'forum_id' => $forum_id],
            ]);
        }
    }
}
