<?php

namespace App\Http\Controllers;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // {
        //     // Fetch all orders from the database
        //     $orders = Order::all();
    
        //     // Pass the orders to the Blade view
        //     return view('admin.orders.index', compact('orders'));
        // }

        // Assuming you have an Order model
         $all_orders = Order::all(); // or any query to fetch orders
         return view('admin.orders.index', compact('all_orders')); // Pass the orders to the view
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    // 
    

    public function edit($order_id) {
        $order = Order::findOrFail($order_id); // Retrieve the order by ID
        return view('admin.orders.edit', compact('order')); // Pass the order to the view
    }
    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


    public function updateStatus($order_id, $status)
{
    // Define valid status values based on the ENUM in the database
    $validStatuses = ['pending', 'processing', 'completed', 'cancelled'];

    // Check if the provided status is valid
    if (!in_array($status, $validStatuses)) {
        return redirect()->route('order.index')->with('error', 'Invalid status update');
    }

    // Find the order and update its status
    $order = Order::findOrFail($order_id);
    $order->status = $status;  // Update with the chosen status

    // Save the order
    $order->save();

    // Redirect with a success message
    return redirect()->route('order.index')->with('success', 'Order status updated to ' . ucfirst($status));
}

    
    



}
