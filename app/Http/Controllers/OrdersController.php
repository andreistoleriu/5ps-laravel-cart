<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    /**
     * View orders page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function orders(Request $request)
    {
        $orders = Order::all();

        if ($request->ajax()) {
            return $orders;
        }
        
        return view('orders', compact('orders'));
    }

    /**
     * View the individual order
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function order(Request $request)
    {
        $order = Order::findOrFail($request->input('id'));
        $products = $order->products;


        $result = [
            'products' => $products,
            'totalPrice' => $order->products()->sum('price'),
            'order' => $order,
        ];

        if ($request->ajax()) {
            return $result;
        }

        return view('order', $result);

       return view('order', compact('request', 'price', 'order'));
    }
}
