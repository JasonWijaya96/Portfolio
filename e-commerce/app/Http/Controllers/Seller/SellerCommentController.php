<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Product;
use Illuminate\Http\Request;

class SellerCommentController extends Controller
{
    public function index(Request $request)
    {
        // Get comments with user relationship and pagination
        // Get comments with user and product relationship and pagination
        $comments = Comment::with(['user', 'product', 'replies.user',])
            ->whereNull('parent_id')
            ->when($request->product_search, function ($query) use ($request) {
                $query->whereHas('product', function ($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->product_search . '%');
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Get products that have comments only
        $products = Product::whereHas('comments', function ($query) {
            $query->whereNull('parent_id'); // Hanya komentar utama
        })
            ->when($request->product_search, function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->product_search . '%');
            })
            ->withCount([
                'comments' => function ($query) {
                    $query->whereNull('parent_id'); // Hitung komentar utama saja
                }
            ])
            ->with([
                'comments' => function ($query) {
                    $query->whereNull('parent_id')->latest()->limit(1)->with('user');
                },
                'user'
            ])
            ->orderBy('comments_count', 'desc')
            ->limit(10)
            ->get();


        return view('seller.comments.index', compact('comments', 'products'));
    }

    public function reply(Request $request, Comment $comment)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        Comment::create([
            'user_id' => auth()->id(), // seller id
            'product_id' => $comment->product_id,
            'parent_id' => request()->segment(3),
            'content' => $request->content,
            'rating' => null, // karena ini reply, bukan review
        ]);

        return redirect()->back()->with('success', 'Reply posted successfully.');
    }
}
