<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Brand;
use Illuminate\Http\Request;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index()
    {
        $brands = Brand::all(); 
        $products = Product::all();

        $released = Product::orderBy('created_at', 'desc')
                        ->take(5)
                        ->get();

        $topselling = Product::orderBy('price', 'desc')
                            ->take(5)
                            ->get();

        return view('home', compact('released', 'topselling' , 'brands' , 'products'));
    }
}