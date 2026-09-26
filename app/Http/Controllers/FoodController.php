<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateFoodRequest;
use App\Http\Requests\UpdateFoodRequest;
use App\Models\Food;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FoodController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Food::with('category');

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        return response()->json($query->paginate(10));
    }

    public function create(CreateFoodRequest $request): JsonResponse
    {
        $data = $request->validated();

        $food = Food::create([
            'name'        => $data['name'],
            'description' => $data['description'] ?? null,
            'price'       => $data['price'],
            'quantity'    => $data['quantity'],
            'image'       => $data['image'] ?? null,
            'category_id' => $data['category_id'],
        ]);

        return response()->json([
            'message' => 'created',
            'data'    => $food
        ], Response::HTTP_CREATED);
    }

    public function show($id): JsonResponse
    {
        $food = Food::with('category')->find($id);

        if (!$food) {
            return response()->json([
                'message' => 'Not found'
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'data' => $food
        ], Response::HTTP_OK);
    }

    public function update(UpdateFoodRequest $request, $id): JsonResponse
    {
        $food = Food::find($id);

        if (!$food) {
            return response()->json([
                'message' => 'Not found'
            ], Response::HTTP_NOT_FOUND);
        }
        $data = $request->validated();

        $food->update([
            'name'        => $data['name'] ?? $food->name,
            'description' => array_key_exists('description', $data) ? $data['description'] : $food->description,
            'price'       => $data['price'] ?? $food->price,
            'quantity'    => $data['quantity'] ?? $food->quantity,
            'image'       => array_key_exists('image', $data) ? $data['image'] : $food->image,
            'category_id' => $data['category_id'] ?? $food->category_id,
        ]);

        return response()->json([
            'message' => 'updated',
            'data'    => $food
        ], Response::HTTP_OK);
    }

    public function delete($id): JsonResponse
    {
        $food = Food::find($id);

        if (!$food) {
            return response()->json([
                'message' => 'Not found'
            ], Response::HTTP_NOT_FOUND);
        }

        $food->delete();

        return response()->json([
            'message' => 'deleted'
        ], Response::HTTP_OK);
    }
}
