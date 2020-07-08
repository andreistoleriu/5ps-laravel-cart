<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rules\AdminName;
use App\Rules\AdminPass;

class AuthController extends Controller
{
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
     * Log in
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function auth(Request $request)
    {
        $request->validate([
            'username' => ['required', new AdminName],
            'password' => ['required', new AdminPass]
        ]);

        session(['auth' => true]);
        return redirect()->route('products.index');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function logout()
    {
        session()->pull('auth');
        session()->put(['auth' => false]);

        return redirect()->route('index');
    }
}
