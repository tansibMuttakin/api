<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Resources\ReviewResource;

class ReviewController extends Controller
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
    public function index(Product $product)
    {
        return ReviewResource::collection($product->reviews);
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
    public function store(Request $request, Product $product)
    {
        $validator = $request->validate([
            'customer'=>'required',
            'star'=>'required|integer|between:0,5',
            'body'=>'required'
        ]);

        // $review = $request->all();
        // $product->reviews()->save($review);

        $review = new Review;
        $review->product_id = $product->id;
        $review->customer = $request->customer;
        $review->star = $request->star;
        $review->review = $request->body;
        $review->save();
        
        return response([
            "data"=>new ReviewResource($review)
        ],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product,Review $review)
    {
        $review = Review::find($review->id);
        return response([
            "data"=>new ReviewResource($review)
        ],200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function edit(Review $review)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Product $product, Review $review)
    {
        $review->update($request->all());
        return response([
            "data"=>new ReviewResource($review)
        ],201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product,Review $review)
    {
        $review->delete();
        return response([
            "message"=>"review deleted"
        ]);
    }
}
