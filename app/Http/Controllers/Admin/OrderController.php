<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->status;
        $search = $request->search;

        $orders = Order::with('user')
            ->when($status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('order_number', 'like', '%' . $search . '%')
                      ->orWhere('shipping_name', 'like', '%' . $search . '%')
                      ->orWhere('shipping_email', 'like', '%' . $search . '%');
                });
            })
            ->latest()
            ->get();

        return view('admin.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with(['user', 'items.product'])->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
            'admin_remarks' => 'nullable|string|max:1000',
        ]);

        $order = Order::with('items.product')->findOrFail($id);
        $oldStatus = $order->status;
        $newStatus = $request->status;

        try {
            \Illuminate\Support\Facades\DB::beginTransaction();

            // Status Categories
            $wasActive = in_array($oldStatus, ['processing', 'shipped', 'delivered']);
            $willBeActive = in_array($newStatus, ['processing', 'shipped', 'delivered']);

            // Scenario A: Move to Active (Pending/Cancelled -> Processing+)
            // This is when we DEDUCT stock
            if (!$wasActive && $willBeActive) {
                foreach ($order->items as $item) {
                    if ($item->product) {
                        if ($item->product->stock_quantity < $item->quantity) {
                            throw new \Exception("Insufficient stock for product: " . $item->product->name . " (Available: " . $item->product->stock_quantity . ")");
                        }
                        $item->product->stock_quantity -= $item->quantity;
                        $item->product->save();
                    }
                }
            }

            // Scenario B: Move from Active to Inactive (Processing+ -> Pending/Cancelled)
            // This is when we RESTORE stock
            if ($wasActive && !$willBeActive) {
                foreach ($order->items as $item) {
                    if ($item->product) {
                        $item->product->stock_quantity += $item->quantity;
                        $item->product->save();
                    }
                }
            }

            $order->update([
                'status' => $newStatus,
                'admin_remarks' => $request->admin_remarks
            ]);

            \Illuminate\Support\Facades\DB::commit();
            return redirect()->back()->with('success', 'Order status updated successfully and inventory adjusted.');

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();
        
        return redirect()->route('admin.orders.index')->with('success', 'Order soft deleted successfully!');
    }
}
