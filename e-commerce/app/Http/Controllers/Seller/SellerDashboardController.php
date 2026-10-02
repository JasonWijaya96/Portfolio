<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SellerDashboardController extends Controller
{
    // public function index(){
    //     return view('seller.dashboard.index');
    // }

    public function index()
    {
        // Calculate total earnings
        $totalEarning = $this->calculateTotalEarning();

        // Calculate balance (assuming it's current month earnings)
        $currentMonthEarning = $this->calculateCurrentMonthEarning();

        // Calculate total sales value
        $totalSalesValue = $this->calculateTotalSalesValue();

        // Get monthly chart data
        $chartData = $this->getMonthlyChartData();

        // Get sales history with pagination
        $salesHistory = $this->getSalesHistory();


        $chartData['lifetimeValue'] = array_map('floatval', $chartData['lifetimeValue']);
        $chartData['customerCost'] = array_map('floatval', $chartData['customerCost']);

        // dd($salesHistory, $chartData, $totalEarning, $currentMonthEarning, $totalSalesValue);

        return view('seller.dashboard.index', compact(
            'totalEarning',
            'currentMonthEarning',
            'totalSalesValue',
            'chartData',
            'salesHistory'
        ));
    }


    public function getChartData(Request $request)
    {
        $timeRange = $request->get('time_range', 'all_time');

        if ($timeRange === 'years') {
            $chartData = $this->getYearlyChartData();
        } else {
            $chartData = $this->getMonthlyChartData();
        }

        $chartData['lifetimeValue'] = array_map('floatval', $chartData['lifetimeValue']);
        $chartData['customerCost'] = array_map('floatval', $chartData['customerCost']);

        return response()->json($chartData);
    }


    private function calculateTotalEarning()
    {
        // Earning = (selling_price - cost_price) * quantity_sold
        // Menggunakan price dari order_items sebagai selling_price
        // $anu = OrderItem::join('orders', 'order_items.order_id', '=', 'orders.id')
        //     ->join('products', 'order_items.product_id', '=', 'products.id')
        //     ->where('orders.status', 'completed')
        //     ->selectRaw('SUM(order_items.price * order_items.quantity) as total_earning')
        //     ->first();
        return OrderItem::with('product')
            ->whereHas('order', function ($query) {
                $query->where('status', 'completed');
            })
            ->selectRaw('SUM(order_items.price * order_items.quantity) as total_earning')
            ->first()->total_earning ?? 0;

        // return $aa; // Mengembalikan 0 jika tidak ada data
    }

    private function calculateCurrentMonthEarning()
    {
        return OrderItem::with('product')
            ->whereHas('order', function ($query) {
                $query->where('status', 'completed')
                    ->whereMonth('created_at', Carbon::now()->month)
                    ->whereYear('created_at', Carbon::now()->year);
            })
            ->selectRaw('SUM(order_items.price * order_items.quantity) as current_earning')
            ->first()->current_earning ?? 0;
        // $anu = OrderItem::join('orders', 'order_items.order_id', '=', 'orders.id')
        //     ->join('products', 'order_items.product_id', '=', 'products.id')
        //     ->selectRaw('SUM(order_items.price * order_items.quantity) as current_earning')
        //     ->where('orders.status', 'completed')
        //     ->whereMonth('orders.created_at', Carbon::now()->month)
        //     ->whereYear('orders.created_at', Carbon::now()->year)
        //     ->first();

        // return $anu;
    }

    private function calculateTotalSalesValue()
    {
        return Order::where('status', 'completed')
            ->sum('total_price');
    }

    private function getMonthlyChartData()
    {
        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $lifetimeValue = [];
        $customerCost = [];

        foreach ($months as $index => $month) {
            $monthNumber = $index + 1;

            // Lifetime Value (Total Revenue)
            $lifetimeValue[] = Order::where('status', 'completed')
                ->whereMonth('created_at', $monthNumber)
                ->whereYear('created_at', Carbon::now()->year)
                ->sum('total_price');

            // Customer Cost (Total Cost)
            $customerCost[] = OrderItem::join('orders', 'order_items.order_id', '=', 'orders.id')
                ->join('products', 'order_items.product_id', '=', 'products.id')
                ->where('orders.status', 'completed')
                ->whereMonth('orders.created_at', $monthNumber)
                ->whereYear('orders.created_at', Carbon::now()->year)
                ->sum(\DB::raw('products.price * order_items.quantity'));
        }

        return [
            'months' => $months,
            'lifetimeValue' => $lifetimeValue,
            'customerCost' => $customerCost
        ];
    }

    private function getYearlyChartData()
    {
        $currentYear = Carbon::now()->year;
        $years = [];
        $lifetimeValue = [];
        $customerCost = [];

        // Get data for last 3 years plus current year (4 years total)
        for ($i = 3; $i >= 0; $i--) {
            $year = $currentYear - $i;
            $years[] = (string) $year;

            // Lifetime Value (Total Revenue for the year)
            $lifetimeValue[] = Order::where('status', 'completed')
                ->whereYear('created_at', $year)
                ->sum('total_price');

            // Customer Cost (Total Cost for the year)
            $customerCost[] = OrderItem::join('orders', 'order_items.order_id', '=', 'orders.id')
                ->join('products', 'order_items.product_id', '=', 'products.id')
                ->where('orders.status', 'completed')
                ->whereYear('orders.created_at', $year)
                ->sum(\DB::raw('products.price * order_items.quantity'));
        }

        return [
            'months' => $years, // Using 'months' key for consistency with frontend
            'lifetimeValue' => $lifetimeValue,
            'customerCost' => $customerCost
        ];
    }

    private function getSalesHistory()
    {
        return Order::with(['items.product'])
            ->select(
                'orders.created_at as date',
                'orders.status',
                'orders.id',
                'orders.total_price'
            )
            ->selectRaw('
            (SELECT SUM(order_items.quantity) 
             FROM order_items 
             WHERE order_items.order_id = orders.id) as product_sales_count
        ')
            ->selectRaw('
            (SELECT SUM(order_items.price * order_items.quantity) 
             FROM order_items 
             JOIN products ON order_items.product_id = products.id 
             WHERE order_items.order_id = orders.id) as earnings
        ')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
    }

    public function loadMore(Request $request)
    {
        $page = $request->get('page', 1);
        $salesHistory = $this->getSalesHistory();

        return response()->json([
            'data' => view('components.sales-table-rows', compact('salesHistory'))->render(),
            'hasMore' => $salesHistory->hasMorePages()
        ]);
    }
}
