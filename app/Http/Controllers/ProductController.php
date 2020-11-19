<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Resources\Product\ProductResource;
use App\Http\Resources\Product\ProductCollection;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('index','show');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ProductCollection::collection(Product::paginate(5));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'name' => 'required',
            'price' => 'required',
            'description' => 'required',
            'stock' => 'required',
            'discount' => 'required',
        ]);
        $product = new Product;
        $product->name = $request->name;
        $product->price = $request->price;
        $product->detail = $request->description;
        $product->stock = $request->stock;
        $product->discount = $request->discount;
        $product->save();
        return response([
            'data'=>new ProductResource($product),
        ],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        $data = Product::find($product->id);
        return response()->json($data,200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        if (auth()->id()!= $product->user_id) {
            return response([
                'message'=>"this product does not belong to current user",
            ]);
        }
        $request['detail'] = $request->description;
        unset($request['description']);
        $product->update($request->all());
        return response([
            'data'=>new ProductResource($product),
        ],201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        if (auth()->id()!= $product->user_id) {
            return response([
                'message'=>"operation failed.This product does not belong to current user",
            ]);
        }
        $product->delete();
        return response([
            'message'=>'product deleted',
        ]);
    }
}
