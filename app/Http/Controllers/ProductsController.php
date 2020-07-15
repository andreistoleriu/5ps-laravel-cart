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
    public function index(Request $request)
    {
        $products = Product::all();

        if ($request->ajax()) {
            return $products;
        }
        
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if ($request->ajax()) {
            return [
               'product' => true
            ];
        }

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
        $this->validateRequest($request);

        $fileNameToStore = $this->fileToUpload($request);

        $product = new Product;
        $product->fill([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
            'image' => $fileNameToStore,
        ]);
        $product->save();

        if ($request->ajax()) {
            return [
                'success' => 'Product created'
            ];
        }

        return redirect()->route('products.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product, Request $request)
    {
        if ($request->ajax()) {
            return $product;
        }

        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Product $product, Request $request)
    {
        $product->update($this->validateRequest($request));

        if ($request->hasFile('image')) {
            $fileNameToStore = $this->filetoUpload($request);
            $product->update(['image' => $fileNameToStore]);
        }

        if ($request->ajax()) {
            return [
                'success' => 'Product updated'
            ];
        }

        return redirect()->route('products.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product, Request $request)
    {
        $product->delete();

        if ($request->ajax()) {
            return [
                'product' => 'deleted'
            ];
        }

        return redirect()->route('products.index');
    }

    /**
     * Validate data
     *
     * @return mixed
     */
    public function validateRequest(Request $request)
    {
        return $request->validate([
            'title' => 'required|min:3',
            'description' => 'required|min:10',
            'price' => 'required|numeric',
            'image' => 'image|mimes:jpg,jpeg,png,bmp|max:5000'
        ]);
    }

    public function filetoUpload(Request $request)
    {
        if ($request->hasFile('image')) {
            $filenameWithExt = $request->file('image')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('image')->getClientOriginalExtension();
            $fileNameToStore = $filename . '_' . time() . '.' . $extension;

            $request->file('image')->storeAs('public/images', $fileNameToStore);
        } else {
            $fileNameToStore = null;
        }

        return $fileNameToStore;
    }
}
