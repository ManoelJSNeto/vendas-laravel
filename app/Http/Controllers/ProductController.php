<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%'.$request->search.'%');
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $products = $query->get();
        $categories = Category::orderBy('name')->get();

        return view('products.index', compact('products', 'categories'));
    }
}

