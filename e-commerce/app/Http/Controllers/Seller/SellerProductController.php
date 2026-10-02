<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\Brand;

class SellerProductController extends Controller
{
    public function create()
{
    $categories = Category::all();
    $brands = Brand::all();
    return view('seller.products.create', compact('categories', 'brands'));
}

    public function store(Request $request)
{
    $request->validate([
        'name'        => 'required|string|max:100',
        'description' => 'nullable|string',
        'price'       => 'required|numeric|min:0',
        'discount'    => 'nullable|numeric|min:0|max:100',
        'stock'       => 'required|integer|min:1',
        'style'       => 'required|string',
        'category_id' => 'required|exists:categories,id',
        'brand_id'    => 'required|exists:brands,id',
        'image' => 'nullable|image|mimes:jpg,jpeg,png|max:10240',
        'size' => 'nullable|string',
        'color' => 'required|string',
    ]);

    $imagePath = null;
    if ($request->hasFile('image')) {
    $originalFilename = $request->file('image')->getClientOriginalName();
    $filename = time() . '_' . $originalFilename;

    $request->file('image')->move(public_path('products'), $filename);

    $imagePath = 'products/' . $filename;
}

    // Ambil kategori terkait
    $category = Category::findOrFail($request->category_id);

    Product::create([
        'name'           => $request->name,
        'slug'           => Str::slug($request->name) . '-' . uniqid(),
        'description'    => $request->description,
        'original_price' => $request->price,
'price' => $request->discount > 0
    ? round($request->price * (1 - $request->discount / 100), 2)
    : $request->price,
        'discount_type'  => $request->discount > 0 ? 'percent' : null,
        'discount_value' => $request->discount,
        'on_sale'        => $request->discount > 0,
        'stock'          => $request->stock,
        'style'          => $request->style,
        'type'           => $category->type,
        'image'          => $imagePath,
        'category_id'    => $request->category_id,
        'brand_id'       => $request->brand_id,
        'size' => $request->sizes,
        'color' => $request->color,
        'user_id'        => Auth::id(),
    ]);

    return redirect()->back()->with('success', 'Product successfully created!');
}
     public function katalogs()
    {
        $katalogs = Product::orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('seller.products.released', compact('katalogs'));
    }
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->back()->with('success', 'Product deleted successfully.');
    }
    // app/Http/Controllers/ProductController.php

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock' => 'nullable|integer',
        ]);

        $product->update($validated);

        return redirect()->back()->with('success', 'Product updated successfully!');
    }


}

