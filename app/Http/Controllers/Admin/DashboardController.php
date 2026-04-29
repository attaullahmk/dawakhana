<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Review;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_revenue' => Order::where('status', 'delivered')->sum('total'),
            'total_orders' => Order::count(),
            'total_products' => Product::count(),
            'total_users' => User::count(),
        ];

        // 1. Generate revenue data for the last 7 days
        $revenueData = [];
        $days = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $days[] = now()->subDays($i)->format('D');
            $revenueData[] = Order::where('status', 'delivered')
                ->whereDate('created_at', $date)
                ->sum('total');
        }

        // 2. Generate Sales by Category data
        $categorySales = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', 'delivered')
            ->select('categories.name', DB::raw('SUM(order_items.price * order_items.quantity) as total_sales'))
            ->groupBy('categories.name')
            ->orderBy('total_sales', 'desc')
            ->get();

        $categoryLabels = $categorySales->pluck('name')->toArray();
        $categoryValues = $categorySales->pluck('total_sales')->toArray();

        // If no sales, provide defaults to avoid empty JS arrays
        if (empty($categoryLabels)) {
            $categoryLabels = ['No Sales Yet'];
            $categoryValues = [0];
        }

        $recentOrders = Order::with('user')->latest()->take(5)->get();
        $recentReviews = Review::with(['user', 'product'])->latest()->take(3)->get();
        $lowStockProducts = Product::where('stock_quantity', '<', 10)->where('is_active', true)->take(5)->get();

        return view('admin.dashboard', compact(
            'stats', 'recentOrders', 'recentReviews', 'lowStockProducts', 
            'revenueData', 'days', 'categoryLabels', 'categoryValues'
        ));
    }
}
