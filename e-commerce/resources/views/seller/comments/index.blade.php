@extends('layouts.seller')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <div class="bg-white rounded-lg shadow-sm">
            {{-- Header --}}
            <div class=" flex border-b border-gray-200  justify-between  px-6 py-4">
                <h1 class="text-xl font-semibold text-gray-900">Comments</h1>
                <div class="relative">
                    <form method="GET" action="{{ route('seller.comments.index') }}">
                        <input type="text" name="product_search" value="{{ request('product_search') }}" placeholder="Search product"
                            class="pl-8 pr-4 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                            onchange="this.form.submit()">
                        <svg class="w-4 h-4 absolute left-2.5 top-2.5 text-gray-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </form>
                </div>
            </div>

            <div class="flex flex-col lg:flex-row lg:space-x-6">
                {{-- Comments Section --}}
                <div class="w-full lg:w-3/5">
                    {{-- Comments Header --}}
                    <div class="px-6 py-4">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-lg font-medium text-gray-700">Comments</h2>
                        </div>

                        {{-- Comments List --}}
                        <div class="space-y-6">
                            @foreach($comments as $index => $comment)
                                <div class="flex space-x-3" data-comment-index="{{ $index }}">
                                    <img src="https://randomuser.me/api/portraits/men/{{ $comment->user->id % 100 }}.jpg"
                                         alt="{{ $comment->user->name }}" 
                                         class="w-10 h-10 rounded-full flex-shrink-0">

                                    <div class="flex-1">
                                        <div class="flex items-center space-x-2 mb-1">
                                            <h4 class="font-medium text-gray-900">{{ $comment->user->name }}</h4>
                                            <span class="text-sm text-gray-500">{{ $comment->created_at->format('M j') }}</span>
                                        </div>

                                        <p class="text-gray-700 text-sm mb-2">{{ $comment->content }}</p>

                                        {{-- Product Info if comment is related to a product (mobile only) --}}
                                        @if($comment->product)
                                            <div class="flex lg:hidden items-center space-x-2 mb-2 p-2 bg-gray-50 rounded">
                                                <img src="{{ asset($comment->product->image) }}" alt="{{ $comment->product->name }}" class="w-6 h-6 rounded">
                                                <span class="text-xs text-gray-600">{{ $comment->product->name }}</span>
                                            </div>
                                        @endif

                                        {{-- Star Rating --}}
                                        <div class="flex items-center space-x-1 mb-3">
                                            @for($i = 1; $i <= 5; $i++)
                                                <svg class="w-4 h-4 {{ $i <= $comment->rating ? 'text-yellow-400' : 'text-gray-300' }}" 
                                                     fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                </svg>
                                            @endfor
                                        </div>

                                        {{-- Action Buttons --}}
                                        <div x-data="{ showReply: false }" class="flex flex-col">
                                            <div class="flex items-center space-x-4 text-gray-500 mb-3" x-show="!showReply">
                                                <!-- Reply Button -->
                                                <button @click="showReply = !showReply" class="flex items-center space-x-1 hover:text-gray-700">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path>
                                                    </svg>
                                                </button>

                                                <button class="flex items-center space-x-1 hover:text-red-500">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                                        </path>
                                                    </svg>
                                                    <span class="text-sm">{{ $comment->likes_count ?? 0 }}</span>
                                                </button>

                                                <button class="flex items-center space-x-1 hover:text-gray-700">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z">
                                                        </path>
                                                    </svg>
                                                </button>

                                                <button class="flex items-center space-x-1 hover:text-gray-700">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z">
                                                        </path>
                                                    </svg>
                                                </button>
                                            </div>

                                            {{-- Replies --}}
                                            @foreach ($comment->replies as $reply)
                                                <div class="ml-6 mt-2 mb-2 border-l-4 pl-4 border-blue-400 bg-white rounded">
                                                    <strong class="text-blue-600">{{ $reply->user->name ?? 'Seller' }}</strong>
                                                    <p>{{ $reply->content }}</p>
                                                </div>                             
                                            @endforeach

                                            {{-- Reply Form --}}
                                            {{-- <div x-show="showReply" class="mt-3 flex space-x-3" x-cloak>
                                                <img src="https://randomuser.me/api/portraits/men/{{ auth()->user()->id ?? 1 % 100 }}.jpg"
                                                    alt="{{ auth()->user()->name ?? 'User' }}" class="w-8 h-8 rounded-full flex-shrink-0">
                                                <form action="{{ route('seller.comments.reply', $comment->id) }}" method="POST" class="flex-1">
                                                    @csrf
                                                    <textarea name="content" placeholder="Write something to reply..."
                                                        class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm resize-none focus:outline-none focus:ring-2 focus:ring-blue-500"
                                                        rows="2" required></textarea>

                                                    <div class="mt-2 flex justify-end space-x-2">
                                                        <button type="submit" class="px-4 py-1 bg-blue-500 text-white hover:bg-blue-600 rounded text-sm">
                                                            Reply
                                                        </button>
                                                        <button @click="showReply = false" type="button"
                                                            class="px-4 py-1 bg-gray-100 text-gray-600 rounded text-sm hover:bg-gray-200">
                                                            Cancel
                                                        </button>
                                                    </div>
                                                </form>
                                            </div> --}}

                                            <div class="mt-3 flex space-x-3" x-data="{ content: '' }" x-show="showReply" x-cloak>
                                                <img src="https://randomuser.me/api/portraits/men/{{ auth()->user()->id ?? 1 % 100 }}.jpg"
                                                    alt="{{ auth()->user()->name ?? 'User' }}" class="w-8 h-8 rounded-full flex-shrink-0">
                                                    <form action="{{ route('seller.comments.reply', $comment->id) }}" method="POST" class="flex-1">
                                                        @csrf
                                                        <textarea placeholder="Write something to reply..." x-model="content" name="content" required
                                                            class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm resize-none focus:outline-none focus:ring-2 focus:ring-blue-500"
                                                            rows="2"></textarea>

                                                        <div class="mt-2 flex justify-end space-x-2">
                                                            <button type="submit"
                                                                :class="content.trim().length > 0 
                                                                                                                                                                                                                                                                                                                    ? 'bg-blue-500 text-white hover:bg-blue-600' 
                                                                                                                                                                                                                                                                                                                    : 'bg-gray-300 text-gray-600 cursor-not-allowed'"
                                                                class="px-4 py-1 rounded text-sm text-white" :disabled="content.trim().length === 0" @click="showReply = false">
                                                                Reply
                                                            </button>

                                                            <button @click="showReply = false" type="button"
                                                                class="px-4 py-1 bg-gray-100 text-gray-600 rounded text-sm hover:bg-gray-200">
                                                                Cancel
                                                            </button>
                                                        </div>
                                                    </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Products Section (desktop only) - Aligned with Comments --}}
                <div class="hidden lg:block lg:w-2/5">
                    <div class="px-6 py-4">
                        <h3 class="text-lg font-medium text-gray-700 mb-4">Products</h3>

                        {{-- Products aligned with each comment --}}
                        <div class="space-y-6">
                            @foreach($comments as $index => $comment)
                                @php
    // Calculate approximate height based on comment content and replies
    $contentLines = ceil(strlen($comment->content) / 80); // Rough estimate of lines
    $replyCount = $comment->replies ? $comment->replies->count() : 0;
    $baseHeight = 120; // Base height for comment structure
    $replyHeight = $replyCount * 60; // Each reply adds ~60px
    $extraHeight = $contentLines > 2 ? ($contentLines - 2) * 20 : 0; // Extra height for long content
    $totalHeight = $baseHeight + $replyHeight + $extraHeight;
                                @endphp

                                <div class="flex items-start" style="min-height: {{ $totalHeight }}px;" data-product-index="{{ $index }}">
                                    @if($comment->product)
                                        <div class="flex items-start space-x-3 p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors w-full">
                                            <img src="{{ asset($comment->product->image) }}" 
                                                 alt="{{ $comment->product->name }}" 
                                                 class="w-16 h-16 rounded-lg object-cover flex-shrink-0">
                                            <div class="flex-1 min-w-0">
                                                <h4 class="text-sm font-semibold text-gray-900 mb-1 leading-tight">{{ $comment->product->name }}</h4>
                                                {{-- Product metadata (if available) --}}
                                                @if(isset($comment->product->description))
                                                    <p class="text-xs text-gray-600 mt-2 line-clamp-2">{{ Str::limit($comment->product->description, 80) }}</p>
                                                @endif
                                                <p class="text-xs text-gray-500 mb-2 leading-relaxed">{{ $comment->product->category->name ?? 'Product Category' }}</p>
                                                <p class="text-lg font-bold text-gray-900">${{ number_format($comment->product->price, 2) }}</p>
                                                
                                            </div>
                                        </div>
                                    @else
                                        {{-- Empty space to maintain alignment when no product --}}
                                        <div class="w-full flex items-center justify-center text-gray-300 border-2 border-dashed border-gray-200 rounded-lg p-8">
                                            <div class="text-center">
                                                <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                                </svg>
                                                <span class="text-sm">No product</span>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            {{-- Pagination --}}
            <div class="border-t border-gray-200 px-6 py-4">
                <div class="flex items-center justify-center space-x-2">
                    <button class="p-2 rounded-md hover:bg-gray-100" {{ $comments->onFirstPage() ? 'disabled' : '' }}>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </button>

                    <button class="p-2 rounded-md hover:bg-gray-100" {{ !$comments->hasMorePages() ? 'disabled' : '' }}>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

@endsection