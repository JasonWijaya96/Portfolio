@forelse($salesHistory as $sale)
    <tr>
        <td class="px-4 py-2">{{ \Carbon\Carbon::parse($sale->date)->format('M j') }}</td>
        <td class="px-4 py-2">
            @php
                $status = strtolower($sale->status);
                $statusColors = [
                    'pending' => 'bg-red-100 text-red-800',
                    'processed' => 'bg-yellow-100 text-yellow-800',
                    'shipped' => 'bg-green-100 text-green-800',
                    'completed' => 'bg-green-100 text-green-800',
                ];
            @endphp
            <span
                class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $statusColors[$status] ?? 'bg-gray-100 text-gray-800' }}">
                {{ ucfirst($sale->status) }}
            </span>
        </td>
        <td class="px-4 py-2">{{ number_format($sale->product_sales_count) }}</td>
        <td class="px-4 py-2 text-green-600">${{ number_format($sale->earnings, 2) }}</td>
    </tr>
@empty
    <tr>
        <td colspan="4" class="text-center py-4 text-gray-500">No sales data available</td>
    </tr>
@endforelse