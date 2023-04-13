<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\UserOrder;
use Illuminate\Support\Facades\Auth;



class OrderController extends Controller
{
    public function add(Request $request)
{
    $request->validate([
        'orders' => 'required|array',
        'restaurant_id' => 'required|exists:restaurants,id',
        'order_charges' => 'numeric|required',
        'delivery_charges' => 'numeric|required'
    ]);

    $userOrder = new UserOrder();
    $userOrder->order_id = rand(000000,999999);
    $userOrder->user_id = 1;
    $userOrder->restaurant_id = $request->restaurant_id;
    $userOrder->status = 1;
    $userOrder->total_items = count($request->orders);
    $userOrder->order_charges = $request->order_charges;
    $userOrder->delivery_charges = $request->delivery_charges;
    $userOrder->total_amount = $request->order_charges + $request->delivery_charges;
    $userOrder->save();

    foreach ($request->orders as $odr) {
        $order = new Order();
        $order->menu_id = $odr['menu_id'];
        $order->qty = $odr['qty'];
        $order->price_per_item = $odr['price_per_item'];
        $order->total_price = $odr['qty'] * $odr['price_per_item'];
        $order->user_orders_id =  $userOrder->id;
        $order->save();
    }
     return response()->json(['message' => 'success']);
}

    public function updateStatus(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:user_orders,id',
            'status' => 'numeric|required',
        ]);

        $UserOrder   = UserOrder::find($request->id);
        if ($UserOrder)
        {
            $UserOrder->status = $request->status;
            $UserOrder->save();
            return response()->json('Status updated successfully');
        }
        return response()->json('User Order not found');
        }


}
