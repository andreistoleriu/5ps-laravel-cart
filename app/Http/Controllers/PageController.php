<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Config;

class PageController extends Controller
{
    /**
     * View index page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $cart = $request->session()->get('cart', []);
        
        if ($request->id && !in_array($request->id, $cart)) {
            $request->session()->push('cart', $request->id);

            return redirect('/');
        }

        return view('index', ['products' => DB::table('products')->whereNotIn('id', $cart)->get()]);

        // $products = DB::table('products')->get();
        // return view('index', ['products' => $products]);
    }
    
    /**
     * View cart page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function cart(Request $request)
    {
        $cart = $request->session()->pull('cart', []);

        // check for duplicate array keys
        if (($key = array_search($request->id, $cart)) !== false) {
            unset($cart[$key]);
        }

        session()->put('cart', $cart);

        $products = DB::table('products')->whereIn('id', $cart)->get();
        $price = 0;

        return view('cart', [
            'products' => $products,
            'price' => $price,
            'cart' => $cart
        ]);
    }

    
    /**
     * View login page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function login()
    {
        return view('login');
    }
    
    /**
     * View product page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function product()
    {
        return view('product');
    }
    
    /**
     * View orders page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function orders()
    {
        return view('orders');
    }
}
