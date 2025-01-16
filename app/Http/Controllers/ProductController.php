<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function index()
    {
        $products = ProductResource::collection(Product::all());

        return Inertia::render('Products/Index', compact('products'));
    }

    public function show(Product $product)
    {
        return Inertia::render('Products/Show', compact('product'));
    }
}
