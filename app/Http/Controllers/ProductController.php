<?php

namespace App\Http\Controllers;

use App\Exceptions\ProductNotBelongsToUser;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\Product\ProductResource;
use App\Http\Resources\Product\ProductCollection;
use Auth;
use App\Model\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except('index','show');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ProductCollection::collection(Product::paginate(20));
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
    public function store(ProductRequest $request)
    {
        $product = new Product;

        $product->name= $request->name;
        $product->detail= $request->description;
        $product->stock= $request->stock;
        $product->price= $request->price;
        $product->discount= $request->discount;
        $product->save();

        return response([
            'data'=> new ProductResource($product)
        ],201);
        

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Product  $product
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
     * @param  \App\Model\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $this->ProductUserCheck($product);
        $request['detail'] = $request->description;
        unset($request['description']);
        $product->update($request->all());
        return response([
            'data'=> new ProductResource($product)
        ],201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $this->ProductUserCheck($product);
        $product->delete();
        return response(null,204);
    }

    public function ProductUserCheck($product)
    {
        if(Auth::id() !== $product->user_id){
            throw new ProductNotBelongsToUser;
        }
    }
}
