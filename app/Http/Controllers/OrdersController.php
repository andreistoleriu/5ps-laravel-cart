<?php

namespace App\Http\Controllers;

use App\Order;
use App\OrderProduct;
use App\Product;

class OrdersController extends Controller
{
    /**
     * View orders page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function orders()
    {
        if (session('auth') === true) {
            $orders = Order::all();
            return view('orders', compact('orders'));
        } else {
            return redirect('/login?unauthorized');
        }
    }

    /**
     * View the individual order
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function order()
    {
        $request = request('id');
        $order = Order::findOrFail($request);

       return view('order', compact('request', 'order'));
    }
}
