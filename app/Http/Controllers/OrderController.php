<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OrderController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $order = Order::create([
            'customer_name' => $request->customer_name,
            'phone_number'  => $request->phone_number,
            'status'        => 'pending',
        ]);

        // Gán danh sách món ăn vào đơn qua attach
        if ($request->has('foods')) {
            foreach ($request->foods as $item) {
                $order->foods()->attach($item['food_id'], [
                    'order_quantity' => $item['order_quantity']
                ]);
            }
        }

        return response()->json([
            'message' => 'Đặt đơn hàng thành công',
            'data'    => $order->load('foods')
        ], Response::HTTP_CREATED);
    }

    // Xem chi tiết đơn hàng
    public function show($id): JsonResponse
    {
        $order = Order::with('foods')->find($id);

        if (!$order) {
            return response()->json(['message' => 'Not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json(['data' => $order], Response::HTTP_OK);
    }
}
