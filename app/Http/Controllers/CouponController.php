<?php

namespace App\Http\Controllers;

use App\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function addCoupon(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            $coupon = new Coupon();
            $coupon->coupon_code = $data['coupon_code'];
            $coupon->amount = $data['amount'];
            $coupon->amount_type = $data['amount_type'];
            $coupon->expiry_date = $data['expiry_date'];
            if (empty($data['status'])) {
                $status = 0;
            } else {
                $status = 1;
            }
            $coupon->status = $status;
            $coupon->save();
            return redirect()->action('CouponController@viewCoupons')->with('flash_message_success', 'Coupon has been added successfully');
        }

        return view('admin.coupons.add_coupon');
    }

    public function viewCoupons()
    {
        $coupons = Coupon::get();

        return view('admin.coupons.view_coupons')->with(compact('coupons'));
    }

    public function editCoupon(Request $request, $id = null)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            $coupon = Coupon::find($id);
            $coupon->coupon_code = $data['coupon_code'];
            $coupon->amount = $data['amount'];
            $coupon->amount_type = $data['amount_type'];
            $coupon->expiry_date = $data['expiry_date'];
            if (empty($data['status'])) {
                $status = 0;
            } else {
                $status = 1;
            }
            $coupon->status = $status;
            $coupon->save();
            return redirect()->action('CouponController@viewCoupons')->with('flash_message_success', 'Coupon has been updated successfully');
        }

        $couponDetails = Coupon::where('id', $id)->first();

        return view('admin.coupons.edit_coupon')->with(compact('couponDetails'));
    }

    public function deleteCoupon($id = null)
    {
        Coupon::where('id', $id)->delete();
        return redirect()->back()->with('flash_message_success', 'Coupon has been deleted successfully');
    }
}
