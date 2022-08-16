<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Create order
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store()
    {
        $user = Auth::user();

        if($user->cart()->count() === 0) {
            return response()->json([
                'error' => [
                    'code' => 422,
                    'message' => 'Cart is empty',
                ],
            ], 422);
        }

        $order = $user->orders()->create([
            'products' => $user->cart->pluck('product_id'),
            'order_price' => $user->cart->sum('product.price'),
        ]);

        $user->cart()->delete();

        return response()->json([
            'data' => [
                'order_id' => $order->id,
                'message' => 'Order is processed',
            ],
        ], 201);
    }

    /**
     * Get orders
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function show()
    {
        return OrderResource::collection(Auth::user()->orders);
    }
}
