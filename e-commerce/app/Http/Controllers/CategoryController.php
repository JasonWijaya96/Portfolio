<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;

class CategoryController extends Controller
{
    public function show($slug, Request $request)
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        $products = Product::where('category_id', $category->id)
            ->when($request->filled('color'), fn($q) => $q->where('color', $request->color))
            ->when($request->filled('size'), function ($q) use ($request) {
                $sizes = (array) $request->size;
                $q->whereIn('size', $sizes);
            })
            ->when($request->filled('type'), fn($q) => $q->where('type', $request->type))
            ->when($request->filled(['min_price', 'max_price']), fn($q) => 
                $q->whereBetween('price', [$request->min_price, $request->max_price])
            )
            ->paginate(12)
            ->withQueryString();

        return view('categories.index', compact('category', 'products'));
    }

    public function index(Request $request)
    {
        $products = Product::query()
            ->when($request->filled('style'), fn($q) => $q->where('style', $request->style))
            ->when($request->filled('type'), fn($q) => $q->where('type', $request->type))
            ->when($request->filled('color'), fn($q) => $q->where('color', $request->color))
->when($request->filled('size'), function ($q) use ($request) {
    foreach ((array) $request->size as $size) {
        $q->whereRaw("FIND_IN_SET(?, size)", [$size]);
    }
})

            ->when($request->filled(['min_price', 'max_price']), fn($q) => 
                $q->whereBetween('price', [$request->min_price, $request->max_price])
            )
            ->paginate(12)
            ->withQueryString();

        $category = null;

        return view('categories.index', compact('products', 'category'));
    }
}
