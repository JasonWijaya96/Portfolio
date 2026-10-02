<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Hello, ' . auth()->user()->name . '!') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("Anda telah berhasil masuk!") }}
                </div>

                @if($orders->isEmpty())
                    <p class="text-gray-500 mt-6 px-6 pb-6">Kamu belum pernah melakukan pembelian.</p>
                @else
                    <div class="mt-6">
                        <h3 class="text-lg font-semibold mb-4 ml-6">Riwayat Pemesanan</h3>
                        <ul class="space-y-6 px-6 pb-6">
                            @foreach($orders as $order)
                                <li class="border border-gray-200 rounded-lg p-4 bg-gray-50 shadow-sm">
                                    {{-- Informasi utama order dari tabel 'orders' --}}
                                    <div class="flex justify-between items-center mb-3">
                                        <div>
                                            <p class="text-lg font-bold">Pesanan #{{ $order->id }}</p>
                                            <p class="text-sm text-gray-700">Status: <span class="font-semibold text-blue-600">{{ ucfirst($order->status) }}</span></p>
                                            <p class="text-md text-gray-600">Total: Rp{{ number_format($order->total_price, 2, ',', '.') }}</p>
                                            <p class="text-xs text-gray-500">Tanggal: {{ $order->created_at->format('d M Y H:i') }}</p>
                                        </div>
                                        {{-- Jika Anda tetap ingin link ke detail terpisah, pastikan route 'orders.show' ada --}}
                                        <a href="{{ route('orders.show', $order->id) }}"
                                           class="text-blue-600 hover:text-blue-800 hover:underline text-sm font-medium">
                                            Lihat Detail
                                        </a>
                                    </div>

                                    {{-- Informasi Tambahan Order dari tabel 'orders' (tanpa item/produk) --}}
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-2 text-sm text-gray-700 mt-4 pt-4 border-t border-gray-200">
                                        <div>
                                            <p class="font-semibold">Metode Pembayaran:</p>
                                            <p>{{ $order->payment_method }}</p>
                                        </div>
                                        <div>
                                            <p class="font-semibold">Alamat Pengiriman:</p>
                                            <p>{{ $order->shipping_address }}</p>
                                        </div>
                                        @if($order->name_rekening)
                                        <div>
                                            <p class="font-semibold">Nama Rekening:</p>
                                            <p>{{ $order->name_rekening }}</p>
                                        </div>
                                        @endif
                                        @if($order->bukti_transfer)
                                        <div>
                                            <p class="font-semibold">Bukti Transfer:</p>
                                            {{-- Pastikan path storage/public sesuai jika menggunakan asset() --}}
                                            <a href="{{ asset('storage/' . $order->bukti_transfer) }}" target="_blank" class="text-blue-600 hover:underline">Lihat Bukti</a>
                                        </div>
                                        @endif
                                    </div>

                                    {{-- BAGIAN INI DIHILANGKAN karena Anda tidak ingin mengambil items.product --}}
                                    {{-- Jika Anda ingin menampilkan item di sini, Anda harus mengambilnya di controller --}}
                                    {{-- <h4 class="text-md font-semibold mt-6 mb-3 pt-4 border-t border-gray-200">Item Pesanan:</h4>
                                    <p class="text-gray-500">Detail item tidak dimuat di sini.</p> --}}
                                    
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>