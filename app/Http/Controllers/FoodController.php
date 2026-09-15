<?php

namespace App\Http\Controllers;

use App\Models\Food;
use Illuminate\Http\Request;

class FoodController extends Controller
{
    public function index(Request $request)
    {
        $query = Food::with('category');

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        return $query->paginate(10);
    }

    public function create(Request $request): array
    {
        $data = $request->all();

        $food = Food::create([
            'name'        => $data['name'],
            'description' => $data['description'] ?? null,
            'price'       => $data['price'],
            'quantity'    => $data['quantity'],
            'image'       => $data['image'] ?? null,
            'category_id' => $data['category_id'],
        ]);

        return [
            'message' => 'created',
            'data'    => $food
        ];
    }

    public function show($id)
    {
        $food = Food::with('category')->find($id);

        if (!$food) {
            return [
                'message' => 'Not found'
            ];
        }

        return [
            'data' => $food
        ];
    }

    public function update(Request $request, $id): array
    {
        $food = Food::find($id);

        if (!$food) {
            return [
                'message' => 'Not found'
            ];
        }

        $data = $request->all();

        $food->update([
            'name'        => $data['name'] ?? $food->name,
            'description' => $data['description'] ?? $food->description,
            'price'       => $data['price'] ?? $food->price,
            'quantity'    => $data['quantity'] ?? $food->quantity,
            'image'       => $data['image'] ?? $food->image,
            'category_id' => $data['category_id'] ?? $food->category_id,
        ]);

        return [
            'message' => 'updated',
            'data'    => $food
        ];
    }

    public function delete($id): array
    {
        $food = Food::find($id);

        if (!$food) {
            return [
                'message' => 'Not found'
            ];
        }

        $food->delete();

        return [
            'message' => 'deleted'
        ];
    }
}
