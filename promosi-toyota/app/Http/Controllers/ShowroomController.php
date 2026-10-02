<?php

namespace App\Http\Controllers;

use App\Models\Promotion;
use App\Models\Showroom;
use Illuminate\Http\Request;

class ShowroomController extends Controller
{
    public function index()
{
    $showrooms = Showroom::all();

    return view('showroom', compact('showrooms'));
}

public function create()
{
    return view('create');
}

public function store(Request $request)
{
    $data = $request->validate([
        'title'   => 'required',
        'description'  => 'required',
        'specs'        => 'required',
        'price' => 'nullable|numeric|max:2147483647',
        'image' => 'required|mimes:jpg,jpeg,png',
    ]);

    $imagePath = $request->file('image')->store('showroom_images', 'public');

Showroom::create([
    'title' => $request->title,
    'description' => $request->description,
    'specs' => $request->specs,
    'price' => $request->price,
    'image' => $imagePath,
    'featured' => $request->has('featured'),
]);

    return redirect()->route('showroom.index')
                     ->with('success','Mobil berhasil ditambahkan!');
}

public function show(Showroom $showroom)
{
    return view('show', compact('showroom'));
}

public function edit(Showroom $showroom)
{
    return view('edit', compact('showroom'));
}

public function update(Request $request, Showroom $showroom)
{
    $data = $request->validate([
        'title'   => 'required',
        'description'  => 'nullable',
        'specs'        => 'nullable',
        'price' => 'nullable|numeric|max:2147483647',
        'image'        => 'nullable|mimes:jpg,jpeg,png',
        'featured'     => 'nullable|boolean',
    ]);

    if ($request->hasFile('image')) {
        $data['image'] = $request->file('image')->store('showroom_images', 'public');
    }

    $showroom->update($data);

    $promoUpdate = [
        'title'  => $data['title'],
        'description' => $data['description'] ?? '',
        'specs'       => $data['specs'] ?? '',
    ];
    
    if (isset($data['image'])) {
        $promoUpdate['image'] = $data['image'];
    }    

Promotion::where('showroom_id', $showroom->id)->update($promoUpdate);

    return redirect()->route('showroom.show', $showroom->id)
                     ->with('success','Mobil berhasil diupdate!');
}


public function destroy(Showroom $showroom)
{
    Promotion::where('showroom_id', $showroom->id)->delete();
$showroom->delete();

    return redirect()->route('showroom.index')
                     ->with('success', 'Mobil berhasil dihapus!');
}
}
