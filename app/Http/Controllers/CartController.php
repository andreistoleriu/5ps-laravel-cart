<?php

namespace App\Http\Controllers;

use App\Mail\Checkout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Product;
use App\Order;

class CartController extends Controller
{
    /**
     * View index page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $cart = $request->session()->get('cart', []);
        $products = Product::query()->whereNotIn('id', $cart)->get();

        if ($request->expectsJson()) {
            return response()->json($products);
        }

        return view('index', compact('products'));
    }

    public function addItemsToCart(Request $request)
    {
        Product::findOrFail($request->input('id'));
        $request->session()->push('cart', $request->input('id'));

        if ($request->expectsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('index');
    }

    /**
     * View cart page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function cart(Request $request)
    {
        $cart = $request->session()->get('cart', []);
        $products = Product::query()->whereIn('id', $cart)->get();
        
        $result = [
            'products' => $products,
            'price' => $products->sum('price'),
            'cart' => $cart ? true : false
        ];

        if ($request->expectsJson()) {
            return response()->json($result);
        }

        return view('cart', $result);
    }

    public function removeItemsFromCart(Request $request)
    {
        $cart = $request->session()->pull('cart', []);

        if (($key = array_search($request->input('id'), $cart)) !== false) {
            unset($cart[$key]);
        }

        session()->put('cart', $cart);

        return redirect()->route('cart.remove');
    }

    public function mail(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|min:3|max:255',
            'contactDetails' => 'required|min:3|max:255',
            'comments' => 'min:0|max:255'
        ]);

        $cart = request()->session()->pull('cart');
        $products = Product::query()->whereIn('id', $cart)->get();
        $price = $products->sum('price');
        
        $order = new Order();
        $order->fill([
            'name' => $request->input('name'),
            'contact_details' => $request->input('contactDetails'),
            'price' => $price,
            ]);
        $order->save();

        $order->products()->attach($cart);

        Mail::to(config('mail.mail_to'))->send(new Checkout($data, $products, $price));

        if ($request->expectsJson()) {
            return response()->json([
               'success' => 'Order has been sent! Thank you!'
            ]);
        }

        return redirect()->route('cart')->with('status', 'Order has been sent!');
    }
}