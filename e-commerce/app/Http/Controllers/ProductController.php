<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Comment;

class ProductController extends Controller
{
 public function onSale(Request $request)
{
    $products = Product::where(function ($query) {
        $query->whereNotNull('discount_type')
              ->whereNotNull('discount_value')
              ->whereColumn('price', '<', 'original_price');
    })->paginate(12);

    return view('products.on-sale', compact('products'));
}


public function newArrivals(Request $request)
{
    $products = Product::orderBy('created_at', 'desc')
        ->take(30)
        ->paginate(12);

    return view('products.new-arrivals', compact('products'));
}

public function topSelling()
{
    $products = Product::orderBy('price', 'desc')->paginate(12); // atau logika top selling yang kamu gunakan
    return view('products.top-selling', compact('products'));
}

public function search(Request $request)
{
    $keyword = $request->input('q');

    $products = Product::where('name', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('description', 'LIKE', '%' . $keyword . '%')
                    ->paginate(12);

    return view('products.search-results', compact('products', 'keyword'));
}
public function show($slug, Request $request)
{

    $product = Product::with('comments.user')->where('slug', $slug)->firstOrFail();

    $product->increment('views');

    $commentsQuery = $product->comments()->with('user');
    
    $sizes = explode(',', $product->size);

    $filter = request('filter');

     $comments = Comment::where('product_id', $product->id)
        ->latest()
        ->with(['user', 'replies.user']) // << penting: load user dan replies
        ->paginate(8);

    if (is_numeric($filter)) {
        // Kalau numeric berarti filter rating
        $commentsQuery->where('rating', (int) $filter);
    } elseif ($filter === 'oldest') {
        $commentsQuery->orderBy('created_at', 'asc');
    } else {
        // default: latest
        $commentsQuery->orderBy('created_at', 'desc');
    }

    $comments = $commentsQuery->get();

    $from = $request->query('from'); 

    return view('categories.desc', compact('product', 'comments', 'sizes', 'from'));
}

public function loadComments($id)
{
    $product = Product::findOrFail($id);
    $filter = request('filter');

    $commentsQuery = $product->comments()->with('user');

    if (is_numeric($filter)) {
        $commentsQuery->where('rating', (int) $filter);
    } elseif ($filter === 'oldest') {
        $commentsQuery->orderBy('created_at', 'asc');
    } else {
        $commentsQuery->orderBy('created_at', 'desc'); // default: latest
    }

    $comments = $commentsQuery->get();

    return view('categories._comments', compact('comments'))->render();
}

}
