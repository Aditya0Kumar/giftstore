<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Mail\OrderPlaced;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function checkout(Request $request)
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $request->validate([
            'delivery_date' => 'nullable|date|after_or_equal:today',
            'gift_wrap' => 'nullable|boolean',
            'gift_message' => 'nullable|string|max:500',
        ]);

        DB::beginTransaction();
        try {
            $totalAmount = array_sum(array_map(function($item) {
                return $item['price'] * ($item['quantity'] ?? 1);
            }, $cart));

            // Add Gift Wrap Fee
            $isGiftWrapped = $request->has('gift_wrap') && $request->gift_wrap;
            if ($isGiftWrapped) {
                $totalAmount += 150;
            }

            $order = Order::create([
                'user_id' => Auth::id(),
                'total_amount' => $totalAmount,
                'status' => 'pending',
                'delivery_date' => $request->delivery_date,
                'gift_wrap' => $isGiftWrapped,
                'gift_message' => $request->gift_message,
            ]);

            foreach ($cart as $cartItemId => $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'customization_json' => $item['customization'],
                    'calculated_price' => $item['price'],
                    'quantity' => $item['quantity'] ?? 1,
                ]);
            }

            DB::commit();

            // Clear the cart
            session()->forget('cart');

            // Send email notification
            Mail::to(Auth::user()->email)->send(new OrderPlaced($order));

            return redirect()->route('orders.success', $order->id)->with('success', 'Order placed successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('cart.index')->with('error', 'Something went wrong while placing your order: ' . $e->getMessage());
        }
    }

    public function success(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }
        
        return view('orders.success', compact('order'));
    }
}
