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
            if(!($type || $number || $description || $data)){
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
            if($have_price < $total_price){
                return json([
                    'code'  =>  -1,
                    'msg'   =>  '余额不足',
                    'data'  =>  [],
                ]);
            }
            Db::startTrans();
            try{
                $response['type'] = $type;
                $response['status'] = 0;
                $response['add_time'] = time();
                $response['description'] = $description;
                $response['thumb_img'] = $file_path;
                $response['num'] = $number;
                $response['uid'] = $uid;
                $response['identity'] = 2;
                D('task')->add($response);
                $price = $have_price - $total_price;
                D('users')->where(['user_id' => $uid])->update(['happy_beans' => $price]);

                $order['order_sn'] = date('YmdHis',time()) . rand(1000,9999);
                $order['user_id']  = $uid;
                $order['total_amount'] = $total_price * 1.1;
                $order['add_time'] = time();
                D('order')->add($order);

                $log['user_id'] = $uid;
                $log['user_money'] = $total_price;
                $log['add_time'] = time();
                $log['desc']    = "消耗悦玩豆";
                $log['type']    = 1;
                D('adv_log')->add($log);

                Db::commit();
                return json([
                    'code'  =>  1,
                    'msg'   =>  '购买成功',
                    'data'  =>  [],
                ]);
            }catch (Exception $exception){
                Db::rollback();
                return json([
                    'code'  =>  -1,
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
            return $this->fetch();
        }
    }

    //转让
    public function mine1()
    {
        if(request()->isGet()){
            $session_user = session('user');
            $uid = $session_user['user_id'];
            $user_info = D('users')->where(['user_id' => $uid])->field('nickname,happy_beans,user_id')->find();
            $data = D('turn_out')->where(['uid' => $uid])->select();
            $this->assign('data',$data);
            $this->assign('user_info',$user_info);
            return $this->fetch();
        }
    }
}
