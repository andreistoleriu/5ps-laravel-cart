<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (session('auth') === true) {
            return view('products.index', ['products' => Product::all()]);
        } else {
            return redirect('/login?unauthorized');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validateRequest();

        $fileNameToStore = $this->fileToUpload();

        $product = new Product;

        $product->title = $request->input('title');
        $product->description = $request->input('description');
        $product->price = $request->input('price');
        $product->image = $fileNameToStore;

        $product->save();

        return redirect('/products');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        return redirect('/products');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Product $product)
    {
        if (request()->hasFile('image')) {
            $fileNameToStore = $this->filetoUpload();
            $product->update($this->validateRequest());
            $product->update(['image' => $fileNameToStore]);
        }
        return redirect('/products');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect('/products');
    }

    /**
     * Validate data
     *
     * @return mixed
     */
    public function validateRequest()
    {
        return request()->validate([
            'title' => 'required|min:3',
            'description' => 'required|min:10',
            'price' => 'required|numeric',
            'image' => 'image|mimes:jpg,jpeg,png,bmp|max:5000'
        ]);
    }

    public function filetoUpload()
    {
        if (request()->hasFile('image')) {
            $filenameWithExt = request()->file('image')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = request()->file('image')->getClientOriginalExtension();
            $fileNameToStore = $filename . '_' . time() . '.' . $extension;

            request()->file('image')->storeAs('public/images', $fileNameToStore);
        } else {
            $fileNameToStore = null;
        }

        return $fileNameToStore;
    }
}
