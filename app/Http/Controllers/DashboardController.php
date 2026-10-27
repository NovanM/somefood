<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Ingredient;
use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalRevenue = Order::where('payment_status', 'paid')->sum('total_amount');
        $totalOrders = Order::count();
        $paidOrdersCount = Order::where('payment_status', 'paid')->count();
        $activeMenusCount = Menu::where('is_available', true)->count();
        $categoriesCount = Category::count();

        $lowStockIngredients = Ingredient::whereColumn('stock_quantity', '<=', 'min_stock_alert')
            ->orderBy('stock_quantity')
            ->get();

        $recentOrders = Order::with('items.menu')
            ->latest()
            ->take(8)
            ->get();

        $topSellingMenus = OrderItem::select('menu_id', DB::raw('SUM(quantity) as total_qty'), DB::raw('SUM(subtotal) as total_sales'))
            ->with('menu.category')
            ->groupBy('menu_id')
            ->orderByDesc('total_qty')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalRevenue',
            'totalOrders',
            'paidOrdersCount',
            'activeMenusCount',
            'categoriesCount',
            'lowStockIngredients',
            'recentOrders',
            'topSellingMenus'
        ));
    }
}
