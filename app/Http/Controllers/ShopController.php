<?php

namespace App\Http\Controllers;

use App\Mail\Checkout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Product;
use App\Order;

class ShopController extends Controller
{
    /**
     * View index page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $cart = $request->session()->get('cart', []);

        return view('index', ['products' => Product::query()->whereNotIn('id', $cart)->get()]);
    }

    public function addItemstoCart(Request $request)
    {
        $cart = $request->session()->get('cart', []);
        
        if ($request->id && !in_array($request->id, $cart)) {
            $request->session()->push('cart', $request->id);

            return redirect('/');
        }
    }
    
    /**
     * View cart page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function cart(Request $request)
    {
        $cart = $request->session()->pull('cart', []);

        if (($key = array_search($request->id, $cart)) !== false) {
            unset($cart[$key]);
        }

        session()->put('cart', $cart);

        $products = Product::query()->whereIn('id', $cart)->get();
        $price = 0;

        foreach ($products as $product) {
            $price += $product->price;
        }

        return view('cart', [
            'products' => $products,
            'price' => $price,
            'cart' => $cart
        ]);
    }

    public function mail()
    {
        $data = request()->validate([
            'name' => 'required|min:3|max:255',
            'contactDetails' => 'required|min:3|max:255',
            'comments' => 'min:3|max:255'
        ]);

        $cart = request()->session()->pull('cart');
        $products = Product::query()->whereIn('id', $cart)->get();
        $price = 0;

        foreach ($products as $product) {
            $price += $product->price;
        }
        $order = new Order();
        
        $order->name = request()->input('name');
        $order->contact_details = request()->input('contactDetails');
        $order->price = $price;

        $order->save();
        $order->products()->attach($cart);

        Mail::to('example@test.com')->send(new Checkout($data, $products, $price));

        return redirect('/cart?success');
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

    public function auth()
    {
        $errorMessage = [];

        if (request()->input('name') !== config('admin.admin_name')) {
            $errorMessage['name'][] = __('The username is incorrect');
        }

        if (request()->input('password') !== config('admin.admin_password')) {
            $errorMessage['password'][] = __('The password is incorrect');
        }

        if (!$errorMessage) {
            session(['auth' => true]);
            return redirect('products');
        } else {
            return view('login', compact('errorMessage'));
        }
    }

    public function logout()
    {
        session()->pull('auth');
        session()->put(['auth' => false]);

        return redirect('/');
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
