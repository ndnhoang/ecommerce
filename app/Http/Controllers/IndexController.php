<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
//        get all products
        $products = Product::orderBy('id', 'desc')->get();

//        get all categories
        $categories = Category::with('categories')->where(['parent_id' => 0])->get();

        return view('index')->with(compact('products', 'categories'));
    }
}
