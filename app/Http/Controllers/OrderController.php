<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * View orders page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $orders = Order::all();

        if ($request->expectsJson()) {
            return response()->json($orders);
        }
        return view('orders', compact('orders'));
    }

    /**
     * View the individual order
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Order $order, Request $request)
    {
        $result = [
            'totalPrice' => $order->price,
            'order' => $order,
        ];

        if ($request->expectsJson()) {
            return response()->json($result);
        }

        return view('order', $result);
    }
}
