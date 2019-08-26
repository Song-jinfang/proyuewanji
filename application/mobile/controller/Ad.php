<?php
namespace app\mobile\controller;
use app\common\logic\GoodsLogic;
use app\common\model\FlashSale;
use app\common\model\GroupBuy;
use app\common\model\PreSell;
use think\Db;
use think\Page;
use app\common\logic\ActivityLogic;

class Ad extends MobileBase
{
    public function put()
    {
        if(request()->isGet()){
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
            $adv_price = M('config')->where(['name' => 'adv_price'])->value('value');
            $beans_price = M('config')->where(['name' => 'beans_price'])->value('value');
            $total_price = $adv_price * $number;
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
}
