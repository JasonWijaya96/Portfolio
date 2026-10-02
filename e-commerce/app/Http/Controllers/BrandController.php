<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;


class BrandController extends Controller
{
    public function index()
{
    $brands = Brand::all();
    return view('brands.index', compact('brands'));
}

public function show($slug)
{
    $brand = Brand::where('slug', $slug)->firstOrFail();
    $products = $brand->products()->paginate(12);
    return view('brands.show', compact('brand', 'products'));
}

}
