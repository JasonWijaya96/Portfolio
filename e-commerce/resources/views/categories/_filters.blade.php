<form method="GET"
      class="w-full space-y-6 text-sm bg-gray-50 p-6 rounded-xl shadow-sm border border-gray-200"
      x-data="{ open: { type: true, price: true, color: true, size: true, style: true } }">

    {{-- Filters Header --}}
    <div class="flex items-center justify-between font-bold text-base mb-2">
        <span>Filters</span>
        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707l-6.414
                  6.414a1 1 0 00-.293.707V19a1 1 0 01-1.447.894l-4-2A1
                  1 0 018 17v-5.172a1 1 0 00-.293-.707L1.293
                  6.707A1 1 0 011 6V4z" />
        </svg>
    </div>

    {{-- Type --}}
    <div>
        <div class="flex justify-between items-center cursor-pointer mb-2" @click="open.type = !open.type">
            <span class="font-semibold">Types</span>
            <span x-text="open.type ? '–' : '+'"></span>
        </div>
        <div x-show="open.type" class="bg-white rounded-lg border border-gray-200 divide-y divide-gray-100 overflow-hidden">
            @foreach(['T-shirts', 'Shorts', 'Shirts', 'Hoodie', 'Jeans'] as $type)
                <a href="?type={{ urlencode($type) }}"
                   class="flex items-center justify-between px-4 py-3 hover:bg-gray-50">
                    <span class="text-gray-700">{{ $type }}</span>
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            @endforeach
        </div>
    </div>

    {{-- Price --}}
<div x-data="{ min: {{ request('min_price', 50) }}, max: {{ request('max_price', 200) }} }">
    <div class="flex justify-between items-center cursor-pointer mb-2" @click="open.price = !open.price">
        <span class="font-semibold">Price</span>
        <span x-text="open.price ? '–' : '+'"></span>
    </div>

    <div x-show="open.price" class="space-y-3">
        <input type="range" min="0" max="500" step="1" x-model="min" class="w-full accent-black">
        <input type="range" min="0" max="500" step="1" x-model="max" class="w-full accent-black">

        {{-- Hidden inputs to submit --}}
        <input type="hidden" name="min_price" :value="min">
        <input type="hidden" name="max_price" :value="max">

        <div class="text-sm text-gray-500 flex justify-between">
            <span>Min: $<span x-text="min"></span></span>
            <span>Max: $<span x-text="max"></span></span>
        </div>
    </div>
</div>


    {{-- Colors --}}
<div x-data="{ selectedColor: '{{ request('color') }}' }">
    <div class="flex justify-between items-center cursor-pointer mb-2" @click="open.color = !open.color">
        <span class="font-semibold">Colors</span>
        <span x-text="open.color ? '–' : '+'"></span>
    </div>

    <div x-show="open.color" class="grid grid-cols-5 gap-3">
        @foreach(['green', 'red', 'yellow', 'orange', 'cyan', 'blue', 'purple', 'pink', 'white', 'black'] as $color)
            <label
                class="relative w-6 h-6 rounded-full cursor-pointer border-2 flex items-center justify-center transition
                       duration-200"
                :class="selectedColor === '{{ $color }}' ? 'ring-2 ring-offset-2 ring-black' : 'border-gray-300'"
                style="background-color: {{ $color }};"
                title="{{ ucfirst($color) }}"
            >
                <input
                    type="radio"
                    name="color"
                    value="{{ $color }}"
                    class="sr-only"
                    x-model="selectedColor"
                    @change="$root.submit()"
                >

                <template x-if="selectedColor === '{{ $color }}'">
                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                </template>
            </label>
        @endforeach
    </div>
</div>



    {{-- Size --}}
    <div>
        <div class="flex justify-between items-center cursor-pointer mb-2" @click="open.size = !open.size">
            <span class="font-semibold">Size</span>
            <span x-text="open.size ? '–' : '+'"></span>
        </div>
        <div x-show="open.size" class="grid grid-cols-3 gap-2">
            @foreach(['XXS','XS','S','M','L','XL','XXL','3XL','4XL'] as $size)
                <label>
                    <input type="checkbox" name="size[]" value="{{ $size }}" class="hidden peer"
                           {{ collect(request('size'))->contains($size) ? 'checked' : '' }}>
                    <div class="px-3 py-1 rounded-full border text-center cursor-pointer text-xs font-medium
                                peer-checked:bg-black peer-checked:text-white">
                        {{ $size }}
                    </div>
                </label>
            @endforeach
        </div>
    </div>

    {{-- Dress Style --}}
    <div>
        <div class="flex justify-between items-center cursor-pointer mb-2" @click="open.style = !open.style">
            <span class="font-semibold">Dress Style</span>
            <span x-text="open.style ? '–' : '+'"></span>
        </div>
        <div x-show="open.style" class="space-y-1">
            @foreach(['Casual','Formal','Party','Gym'] as $style)
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="radio" name="style" value="{{ $style }}" {{ request('style') == $style ? 'checked' : '' }}>
                    <span>{{ $style }}</span>
                </label>
            @endforeach
        </div>
    </div>

    {{-- Submit --}}
    <button type="submit" class="w-full mt-4 py-2 bg-black text-white rounded text-sm font-semibold hover:bg-gray-900 transition">
        Apply Filter
    </button>
</form>
