<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'content' => 'required|string|max:1000',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        Comment::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'product_id' => $request->product_id,
            ],
            [
                'content' => $request->content,
                'rating' => $request->rating,
            ]
        );

        return redirect()->back()->with('success', 'Thank you for your review!');
    }
    public function index(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $filter = $request->query('filter');

        $comments = $product->comments()->with('user');

        if (in_array($filter, ['1', '2', '3', '4', '5'])) {
            $comments->where('rating', $filter);
        } elseif ($filter === 'latest') {
            $comments->latest();
        } elseif ($filter === 'oldest') {
            $comments->oldest();
        }

        $comments = $comments->get();

        return view('categories._comments', compact('comments'));
    }
}
