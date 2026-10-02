@extends('layouts.default')
@section('title', 'Select Your Style')

@section('content')
<h1 class="text-2xl font-bold mb-6">Pick a Category</h1>

<div class="grid grid-cols-2 md:grid-cols-3 gap-6">
    @foreach($categories as $cat)
        <a href="{{ route('categories.show', $cat->slug) }}" class="block p-4 bg-white rounded shadow hover:shadow-lg">
            <h2 class="text-xl font-semibold">{{ $cat->name }}</h2>
        </a>
    @endforeach
</div>
@endsection
