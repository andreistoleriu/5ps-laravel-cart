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

        return view('index', ['products' => Product::query()->whereNotIn('id', $cart)->get()]);
    }

    public function addItemsToCart(Request $request)
    {
        if (Product::where('id', '=', $request->input('id'))->exists()) {
            $request->session()->push('cart', $request->input('id'));
            return redirect('/');
        } else {
            abort(404, 'Product not found!');
        }
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
        $price = $products->sum('price');

        return view(
            'cart',
            [
                'products' => $products,
                'cart' => $cart,
                'price' => $price,
            ]
        );
    }

    public function removeItemsFromCart(Request $request)
    {
        $cart = $request->session()->pull('cart', []);

        if (($key = array_search($request->input('id'), $cart)) !== false) {
            unset($cart[$key]);
        }

        session()->put('cart', $cart);

        return redirect('cart');
    }

    public function mail(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|min:3|max:255',
            'contactDetails' => 'required|min:3|max:255',
            'comments' => 'min:0|max:255'
        ]);

        $cart = $request->session()->pull('cart');
        $products = Product::query()->whereIn('id', $cart)->get();


        $price = $products->sum('price');
        $order = new Order();
        $order->fill([
            'name' => $request->input('name'),
            'contact_details' => $request->input('contactDetails'),
        ]);
        $order->price = $price;
        $order->save();

        $order->products()->attach($cart);

        Mail::to(config('mail.mail_to'))->send(new Checkout($data, $products, $price));

        return redirect('cart')->with('status', 'Order has been sent!');
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

    public function auth(Request $request)
    {
        $errorMessage = [];

        if ($request->input('name') !== config('admin.admin_name')) {
            $errorMessage['name'][] = __('The username is incorrect');
        }

        if ($request->input('password') !== config('admin.admin_password')) {
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

        return redirect('index');
    }
}
