<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coupon;

class CouponController extends Controller
{
    public function apply(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required|string',
            'total_price' => 'required|numeric',
        ]);

        $coupon = Coupon::where('code', strtoupper($request->coupon_code))
            ->whereDate('expires_at', '>=', now())
            ->first();

        if (!$coupon) {
            return response()->json(['error' => 'Kupon tidak valid atau sudah kadaluarsa'], 400);
        }

        $userCoupon = auth()->user()->coupons()
    ->where('coupon_id', $coupon->id)
    ->first();

if (!$userCoupon) {
    return response()->json(['error' => 'Kupon tidak tersedia untuk user ini'], 400);
}

if ($userCoupon->pivot->used) {
    return response()->json(['error' => 'Kupon sudah digunakan'], 400);
}

        $discount = $coupon->discount;
        $total = max(0, $request->total_price - $discount);

        return response()->json([
            'discount' => $discount,
            'total' => $total,
            'message' => "Kupon berhasil diterapkan! Diskon \${$discount}"
        ]);
    }
}
