<?php

namespace App\Http\Controllers;

use App\Models\Home;
use App\Models\OrderItem;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {
		if ($request->date == "week") {
    		// Last 7 days, starting from 6 days ago including today
			$start = Carbon::now()->subDays(6)->startOfDay();
			$end = Carbon::now()->endOfDay();
		} elseif ($request->date == "month") {
    		// From the start of the current month to today
			$start = Carbon::now()->startOfMonth();
			$end = Carbon::now()->endOfDay();
		} else {
    		// Default date range
			$start = $request->start ? Carbon::parse($request->start)->startOfDay() : Carbon::now()->startOfMonth();
			$end = $request->end ? Carbon::parse($request->end)->endOfDay() : Carbon::now()->endOfDay();
		}


    	// Fetch data efficiently
    	$paymentSumsPerDate = Order::selectRaw('DATE(created_at) as date, SUM(payment_amount) as total_payment')
        	->whereDate('created_at', '>=', $start)
        	->whereDate('created_at', '<=', $end)
        	->groupBy('date')
        	->orderBy('date', 'ASC')
        	->get();

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

		$latestOrders = Order::latest()->take(4)->get();
    	$salesByProducts= OrderItem::select('order_items.product_id', 'products.name', 'products.image','orders.cashier_name', DB::raw('SUM(order_items.total_price) as total_sales, SUM(order_items.quantity) as total_item'))
    		->join('products', 'order_items.product_id', '=', 'products.id')
    		->join('orders', 'order_items.order_id', '=', 'orders.id')
    		->whereBetween('order_items.created_at', [
        		Carbon::now()->subWeek()->startOfWeek(), // Start of last week
        		Carbon::now()->subWeek()->endOfWeek()    // End of last week
    		])
    		->groupBy('order_items.product_id', 'products.name', 'orders.cashier_name', 'products.image')
        	->orderBy('total_sales', 'DESC') // Order by total_sales in descending order
    		->limit(7) // Get only the top 7 records
    		->get();
    	// Pass data to the view
		$comparison = OrderItem::select([
        		'products.name as product_name', // Select product name
        		'products.image as product_image', // Select product image
        		DB::raw('SUM(CASE WHEN DATE(order_items.created_at) = "' . Carbon::yesterday()->toDateString() . '" THEN order_items.total_price ELSE 0 END) as yesterday_sales'),
        		DB::raw('SUM(CASE WHEN DATE(order_items.created_at) = "' . Carbon::yesterday()->subWeek()->toDateString() . '" THEN order_items.total_price ELSE 0 END) as last_week_sales')
    		])
    		->join('products', 'order_items.product_id', '=', 'products.id') // Join with products table
    		->groupBy('products.name', 'products.image') // Group by product name and image
    		->orderByDesc(DB::raw('SUM(CASE WHEN DATE(order_items.created_at) = "' . Carbon::yesterday()->toDateString() . '" THEN order_items.total_price ELSE 0 END)')) // Order by yesterday's sales
    		->limit(5) // Limit to the top 5 products
    		->get(); // Get the result


    	$resultsCompare = $comparison->map(function ($item) {
    	$difference = $item->yesterday_sales - $item->last_week_sales;
    	$percentageChange = $item->last_week_sales > 0
        	? ($difference / $item->last_week_sales) * 100
       	 	: ($item->yesterday_sales > 0 ? 100 : 0);

    		return [
        		'product_name' => $item->product_name,
            	'product_image' => $item->product_image,
        		'yesterday_sales' => $item->yesterday_sales,
        		'last_week_sales' => $item->last_week_sales,
        		'difference' => $difference,
        		'percentage_change' => round($percentageChange, 2)
    		];
		});

        if ($request->ajax()) {
        	return response()->json($paymentSumsPerDate);
    	}

    	return view('pages.dashboard', compact('sales', 'paymentSumsPerDate','latestOrders', 'salesByProducts', 'resultsCompare'));
	}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Home $home)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Home $home)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Home $home)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Home $home)
    {
        //
    }
}
