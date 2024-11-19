<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    //index
public function index(Request $request)
{
    $start = $request->start ?? now()->subMonth()->startOfDay();
    $end = $request->end ?? now()->endOfDay();


    // Fetch data efficiently
    $orders_all = Order::with('cashier')
    ->whereDate('created_at', '>=', $start)
    ->whereDate('created_at', '<=', $end)
    ->orderBy('created_at', 'DESC');

    $products = Product::all();
    $categories = Category::all();

    $sales = [];

    if ($categories->isNotEmpty() && $products->isNotEmpty()) {
        // Pre-fetch product sales data in a single query
        $productSales = OrderItem::selectRaw('product_id, SUM(total_price) as total_sales')
        	->whereDate('created_at', '>=', $start)
            ->whereDate('created_at', '<=', $end)
            ->groupBy('product_id')
            ->pluck('total_sales', 'product_id');

        foreach ($categories as $category) {
            $categorySales = 0;

            foreach ($products->where('category_id', $category->id) as $product) {
                $categorySales += $productSales[$product->id] ?? 0;
            }

            $sales[$category->name] = $categorySales;
        }
    }

    // Paginate orders
    $orders = $orders_all->paginate(20);
    // Handle AJAX requests
    if ($request->ajax()) {
        return response()->json([
            'html' => view('pages.orders.partials.order_table', compact('sales', 'orders'))->render()
        ]);
    }
    // Pass data to the view
    return view('pages.orders.index', compact('sales', 'orders'));
}


    //show
    public function show($id)
    {
        $order = Order::with(('cashier'))->findOrFail($id);

        $orderItems = $order->orderItems;
        return view('pages.orders.view', compact('order', 'orderItems'));
    }
}
