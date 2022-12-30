<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    //
    public function index(){
        $products = Product::all();
        return response()->json([
            'status' => 'success',
            'message' => 'Products successfully retrieved',
            'data' => $products
        ]);

    }
    public function store(Request $request){
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
        ]);
        $product = auth()->user()->products()->create($request->all());
        return response()->json([
            'status' => 'success',
            'message' => 'Product successfully created',
            'data' => $product
        ]);
    }
   public function show(Product $product){
         return response()->json([
              'status' => 'success',
              'message' => 'Product successfully retrieved',
              'data' => $product
         ]);
   }
}
