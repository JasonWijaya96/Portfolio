<?php

namespace App\Http\Controllers;

use App\Models\Showroom;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    public function index()
{
    $featuredModels = Showroom::where('featured', true)->get();
    $normalModels   = Showroom::where('featured', false)->get();

    return view('home', compact('featuredModels', 'normalModels'));
}
    
    public function create() {
        return view('promotions.create');
    }
    
    public function store(Request $request) {
        $data = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'image' => 'required|image'
        ]);
    
        $data['image'] = $request->file('image')->store('promotions', 'public');
    
        Promotion::create($data);
        return redirect()->route('showroom.index');
    }
    
    public function show(Promotion $promotion) {
        return view('promotions.show', compact('promotion'));
    }
    
    public function edit(Promotion $promotion) {
        return view('promotions.edit', compact('promotion'));
    }
    
    public function update(Request $request, Promotion $promotion) {
        $data = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'image' => 'nullable|image'
        ]);
    
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('promotions', 'public');
        }
    
        $promotion->update($data);
        return redirect()->route('home');
    }
    
    public function destroy(Promotion $promotion)
{
    $promotion->delete();
    return redirect()->route('home')
        ->with('success','Promotion deleted successfully!');
}
}
