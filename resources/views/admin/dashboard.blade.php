@extends('admin.layouts.admin')

@section('header', __('Overview Dashboard'))

@section('content')
    <!-- Stats Cards -->
    <div class="row g-3 g-md-4 mb-4">
        <div class="col-6 col-lg-3">
            <div class="card bg-white h-100 p-2 p-md-3 border-start border-4 border-primary">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted small text-uppercase fw-bold mb-1" style="font-size: 0.65rem;">{{ __('Total Revenue') }}</p>
                        <h4 class="fw-bold mb-0 text-truncate">{{ $globalSettings['currency_symbol'] ?? '$' }} {{ number_format($stats['total_revenue'], 2) }}</h4>
                    </div>
                    <div class="bg-light rounded-circle p-2 p-md-3 text-primary d-none d-sm-block">
                        <i class="fas fa-dollar-sign fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card bg-white h-100 p-2 p-md-3 border-start border-4 border-success">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted small text-uppercase fw-bold mb-1" style="font-size: 0.65rem;">{{ __('Total Orders') }}</p>
                        <h4 class="fw-bold mb-0">{{ $stats['total_orders'] }}</h4>
                    </div>
                    <div class="bg-light rounded-circle p-2 p-md-3 text-success d-none d-sm-block">
                        <i class="fas fa-shopping-bag fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card bg-white h-100 p-2 p-md-3 border-start border-4 border-warning">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted small text-uppercase fw-bold mb-1" style="font-size: 0.65rem;">{{ __('Total Products') }}</p>
                        <h4 class="fw-bold mb-0">{{ $stats['total_products'] }}</h4>
                    </div>
                    <div class="bg-light rounded-circle p-2 p-md-3 text-warning d-none d-sm-block">
                        <i class="fas fa-box fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card bg-white h-100 p-2 p-md-3 border-start border-4 border-info">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted small text-uppercase fw-bold mb-1" style="font-size: 0.65rem;">{{ __('Total Users') }}</p>
                        <h4 class="fw-bold mb-0">{{ $stats['total_users'] }}</h4>
                    </div>
                    <div class="bg-light rounded-circle p-2 p-md-3 text-info d-none d-sm-block">
                        <i class="fas fa-users fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="row g-4 mb-4">
        <div class="col-lg-8">
            <div class="card p-4 h-100 shadow-sm border-0">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold mb-0">{{ __('Revenue Overview (Last 7 Days)') }}</h5>
                    <div class="badge bg-light text-muted border px-3 py-2 text-uppercase" style="font-size: 0.75rem; letter-spacing: 1px;">{{ __('Real-time Data') }}</div>
                </div>
                <div style="position: relative; height: 350px;">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card p-4 h-100 shadow-sm border-0">
                <h5 class="fw-bold mb-4">{{ __('Sales by Category') }}</h5>
                <div style="position: relative; height: 350px;">
                    <canvas id="categoryChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Recent Orders -->
        <div class="col-lg-8">
            <div class="card p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold mb-0">{{ __('Recent Orders') }}</h5>
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-primary">{{ __('View All') }}</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>{{ __('Order ID') }}</th>
                                <th>{{ __('Customer') }}</th>
                                <th>{{ __('Date') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Total') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentOrders as $order)
                            <tr>
                                <td><a href="{{ route('admin.orders.show', $order->id) }}" class="fw-bold text-decoration-none">#{{ $order->order_number }}</a></td>
                                <td>{{ $order->user->name ?? $order->shipping_name }}</td>
                                <td>{{ $order->created_at->format('M d, Y') }}</td>
                                <td>
                                    @php
                                        $badgeClass = match($order->status) {
                                            'delivered' => 'bg-success',
                                            'processing' => 'bg-info',
                                            'shipped' => 'bg-primary',
                                            'cancelled' => 'bg-danger',
                                            default => 'bg-warning'
                                        };
                                    @endphp
                                    <span class="badge {{ $badgeClass }}">{{ __(ucfirst($order->status)) }}</span>
                                </td>
                                <td class="fw-bold">{{ $globalSettings['currency_symbol'] ?? '$' }} {{ number_format($order->total, 2) }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-3">{{ __('No recent orders found.') }}</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <!-- Low Stock Alerts -->
        <div class="col-lg-4">
            <div class="card p-4 h-100">
                <h5 class="fw-bold text-danger mb-4"><i class="fas fa-exclamation-triangle me-2"></i> {{ __('Low Stock Alerts') }}</h5>
                <div class="list-group list-group-flush">
                    @forelse($lowStockProducts as $lowProduct)
                    <div class="list-group-item px-0 d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center gap-3">
                            <img src="{{ $lowProduct->main_image }}" class="rounded shadow-sm object-fit-cover" width="40" height="40">
                            <div>
                                <h6 class="mb-0 fw-bold">{{ Str::limit($lowProduct->name, 20) }}</h6>
                                <small class="text-muted">{{ __('SKU') }}: {{ $lowProduct->sku }}</small>
                            </div>
                        </div>
                        <span class="badge bg-danger rounded-pill">{{ $lowProduct->stock_quantity }} {{ __('left') }}</span>
                    </div>
                    @empty
                    <div class="text-center text-muted py-4">{{ __('No low stock items!') }}</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Dynamic Chart Data from Controller
        const revenueLabels = @json($days);
        const revenueValues = @json($revenueData);
        
        const categoryLabels = @json($categoryLabels);
        const categoryValues = @json($categoryValues);

        // Revenue Line Chart
        const ctxRev = document.getElementById('revenueChart').getContext('2d');
        new Chart(ctxRev, {
            type: 'line',
            data: {
                labels: revenueLabels,
                datasets: [{
                    label: '{{ __('Revenue') }} (' + window.currencySymbol + ')',
                    data: revenueValues,
                    borderColor: '#5C3D2E',
                    backgroundColor: 'rgba(92, 61, 46, 0.08)',
                    borderWidth: 4,
                    pointBackgroundColor: '#5C3D2E',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 8,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: { 
                responsive: true, 
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                        backgroundColor: '#5C3D2E',
                        padding: 12,
                        cornerRadius: 8,
                        titleFont: { size: 14 }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { borderDash: [5, 5], color: '#f0f0f0' },
                        ticks: { callback: (value) => window.currencySymbol + value }
                    },
                    x: { grid: { display: false } }
                }
            }
        });

        // Category Chart (Real Data)
        const ctxCat = document.getElementById('categoryChart').getContext('2d');
        new Chart(ctxCat, {
            type: 'doughnut',
            data: {
                labels: categoryLabels,
                datasets: [{
                    data: categoryValues,
                    backgroundColor: ['#5C3D2E', '#D4A853', '#7DA19F', '#A3B18A', '#344E41', '#E0D8CC'],
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: { 
                responsive: true, 
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            padding: 20,
                            font: { size: 12 }
                        }
                    }
                },
                cutout: '70%'
            }
        });
    });
</script>
@endpush
