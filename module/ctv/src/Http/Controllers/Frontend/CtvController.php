<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 7/27/2018
 * Time: 2:13 PM
 */

namespace Ctv\Http\Controllers\Frontend;

use Barryvdh\Debugbar\Controllers\BaseController;
use Auth;
use Users\Models\UsersMeta;
use Coupon\Models\Coupon;
use Cart\Models\OrderDetail;

class CtvController extends BaseController
{

    public function getRegister()
    {
        return view('nqadmin-ctv::frontend.register');
    }

    public function postRegister(){
        $userId = Auth::id();
        try{
            Auth::user()->position = ctv;
            Auth::user()->save();

            //check code
            $check = UsersMeta::where('users_id',$userId)->where('meta_key','code')->get();
            $couponCode = '';
            if($check->count()>0){
                $couponCode = 'CTV_'.$userId;
                UsersMeta::where('users_id',$userId)->where('meta_key','code')->update(array("meta_value" =>$couponCode));
            }else{
                $meta = new UsersMeta();
                $meta->users_id = $userId;
                $meta->meta_key = 'code';
                $couponCode = 'CTV_'.$userId;
                $meta->meta_value = $couponCode;
                $meta->save();
            }
            //tao coupon
            if($couponCode!=''){
                $check = Coupon::where('author',$userId)->where('type',1)->get();
                if($check->count()>0){
                    Coupon::where('author',$userId)->where('type',1)->update(array("code" =>$couponCode));
                }else{
                    $coupon = new Coupon();
                    $coupon->code = $couponCode;
                    $coupon->type = 1;
                    $coupon->status = 'active';
                    $coupon->author = $userId;
                    $coupon->save();
                }
            }
        }catch (\Exception $e){
            echo $e->getMessage();
        }
        return redirect()->route('nqadmin::get.thongkectv')->with('success','Bạn đã trở thành cộng tác viên!');
    }

    public function thongke(){
        $userId = Auth::id();
        $meta = UsersMeta::where('users_id',$userId)->where('meta_key','code')->first();
        $code = $meta->meta_value;
        //lay coupon id
        $coupon = Coupon::where('author',$userId)->where('type',1)->where("code",$code)->first();
        //lay danh sách Khóa đào tạođã mua
        $orderDetail = OrderDetail::where('coupon_id',$coupon->id)->paginate(50);
        //lấy tổng số tiền
        $total = $orderDetail->sum('price');
        return view('nqadmin-ctv::frontend.thongke',['orderDetail'=>$orderDetail,'total'=>$total]);
    }

}