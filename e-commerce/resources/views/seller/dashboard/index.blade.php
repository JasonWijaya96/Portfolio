{{-- @extends('layouts.seller')

@section('content')
<h1>Hallo</h1>
@endsection --}}


@extends('layouts.seller')

@section('content')
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-2xl font-bold text-gray-900">Earning</h1>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Total Earning -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center">
                                <div class="w-6 h-6 bg-yellow-500 rounded-full"></div>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Earning</p>
                            <p class="text-2xl font-bold text-gray-900">${{ number_format($totalEarning / 1000, 0) }}k</p>
                            {{-- <p class="text-sm text-green-600">↑ 2.8% this week</p> --}}
                        </div>
                    </div>
                </div>

                <!-- Balance -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center">
                                <div class="w-6 h-6 bg-red-500 rounded-full"></div>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Balance</p>
                            <p class="text-2xl font-bold text-gray-900">${{ number_format($currentMonthEarning, 2) }}</p>
                            {{-- <p class="text-sm text-green-600">↑ 2.8% this week</p> --}}
                        </div>
                    </div>
                </div>

                <!-- Total Sales Value -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                <div class="w-6 h-6 bg-green-500 rounded-full"></div>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Total value of sales</p>
                            <p class="text-2xl font-bold text-gray-900">${{ number_format($totalSalesValue / 1000, 0) }}k
                            </p>
                            {{-- <p class="text-sm text-green-600">↑ 2.8% this week</p> --}}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Chart Section -->
            <div class="bg-white rounded-lg shadow p-6 mb-8">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-lg font-semibold text-gray-900">Product views</h2>
                    <select id="time-range-select" class="border border-gray-300 rounded-md px-3 py-1 text-sm">
                        <option value="all_time">All time</option>
                        <option value="years">Years</option>
                    </select>
                </div>

                <!-- Chart Canvas -->
                <div class="h-64" id="chart-container">
                    <canvas id="productChart"></canvas>
                </div>

                <!-- Loading indicator -->
                <div id="chart-loading" class="flex hidden h-64items-center justify-center">
                    <div class="text-gray-500">Loading chart data...</div>
                </div>

                <!-- Chart Legend -->
                <div class="flex items-center justify-center mt-4 space-x-6">
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-blue-500 rounded mr-2"></div>
                        <span class="text-sm text-gray-600">Lifetime Value</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-yellow-500 rounded mr-2"></div>
                        <span class="text-sm text-gray-600">Customer Cost</span>
                    </div>
                </div>
            </div>

            <!-- Sales Table -->
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Sales History</h2>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Product sales count</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Earnings</th>
                            </tr>
                        </thead>
                        <tbody id="sales-table-body" class="bg-white divide-y divide-gray-200">
                            @include('components.sales-table-rows', ['salesHistory' => $salesHistory])
                        </tbody>
                    </table>
                </div>

                <!-- Load More Button -->
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 text-center">
                    <button id="load-more-btn"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Load more
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- @dd($chartData) --}}

    {{-- @push('scripts')

    @endpush     --}}
@endsection

@section('otherjs')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Ensure chartData is defined and has required properties
            let chartData = @json($chartData ?? ['months' => [], 'lifetimeValue' => [], 'customerCost' => []]);
            let chartInstance = null;

            const chartCanvas = document.getElementById('productChart');
            const timeRangeSelect = document.getElementById('time-range-select');
            const chartLoading = document.getElementById('chart-loading');

            function createChart(data) {
                if (chartCanvas && data.months && data.lifetimeValue && data.customerCost) {
                    const ctx = chartCanvas.getContext('2d');

                    // Destroy existing chart if it exists
                    if (chartInstance) {
                        chartInstance.destroy();
                    }

                    chartInstance = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: data.months,
                            datasets: [
                                {
                                    label: 'Lifetime Value',
                                    data: data.lifetimeValue,
                                    backgroundColor: 'rgba(59, 130, 246, 0.8)',
                                    borderColor: 'rgba(59, 130, 246, 1)',
                                    borderWidth: 1
                                },
                                {
                                    label: 'Customer Cost',
                                    data: data.customerCost,
                                    backgroundColor: 'rgba(245, 158, 11, 0.8)',
                                    borderColor: 'rgba(245, 158, 11, 1)',
                                    borderWidth: 1
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: false,
                                    position: 'top'
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        callback: function (value) {
                                            return '$' + (value / 1000) + 'k';
                                        }
                                    }
                                }
                            }
                        }
                    });
                } else {
                    console.error('Chart data or canvas not found.');
                }
            }

            // Initialize chart with default data
            createChart(chartData);

            // Handle time range selection
            if (timeRangeSelect) {
                timeRangeSelect.addEventListener('change', function () {
                    const selectedRange = this.value;

                    // Show loading indicator
                    chartCanvas.style.display = 'none';
                    chartLoading.classList.remove('hidden');

                    // Fetch new chart data
                    fetch(`{{ route('seller.dashboard.chart-data') }}?time_range=${selectedRange}`, {
                        method: 'GET',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                        }
                    })
                        .then(response => response.json())
                        .then(data => {
                            // Hide loading indicator
                            chartLoading.classList.add('hidden');
                            chartCanvas.style.display = 'block';

                            // Update chart with new data
                            createChart(data);
                        })
                        .catch(error => {
                            console.error('Error fetching chart data:', error);
                            // Hide loading indicator and show canvas again
                            chartLoading.classList.add('hidden');
                            chartCanvas.style.display = 'block';
                        });
                });
            }

            // Load more functionality
            let currentPage = 1;
            const loadMoreBtn = document.getElementById('load-more-btn');
            const salesTableBody = document.getElementById('sales-table-body');

            if (loadMoreBtn) {
                loadMoreBtn.addEventListener('click', function () {
                    currentPage++;
                    loadMoreBtn.disabled = true;
                    loadMoreBtn.innerHTML = 'Loading...';

                    fetch(`{{ route('seller.dashboard.load-more') }}?page=${currentPage}`, {
                        method: 'GET',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                        }
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (salesTableBody) {
                                salesTableBody.insertAdjacentHTML('beforeend', data.data);
                            }

                            if (!data.hasMore) {
                                loadMoreBtn.style.display = 'none';
                            } else {
                                loadMoreBtn.disabled = false;
                                loadMoreBtn.innerHTML = `
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    Load more
                                `;
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            loadMoreBtn.disabled = false;
                            loadMoreBtn.innerHTML = 'Load more';
                        });
                });
            }
        });
    </script>
@endsection