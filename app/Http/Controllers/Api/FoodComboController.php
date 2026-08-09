<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\models\FoodCombo;
use Illuminate\Http\Request;

class FoodComboController extends Controller
{
    public function create(Request $request, FoodCombo $combo)
    {
        $data = $combo->saveFoodCombo($request);
        return response()->json([
            'message' => 'Save Success',
            'data' => $data,
        ], 200);
    }

    public function list(Request $request)
    {
        $keyword = trim((string) $request->keyword);
        $query = FoodCombo::query()->orderBy('sort')->orderBy('id', 'DESC');

        if ($keyword !== '') {
            $query->where('name', 'LIKE', '%' . $keyword . '%');
        }

        $data = $query->get([
            'id',
            'name',
            'slug',
            'images',
            'price',
            'sale_price',
            'sort',
            'status',
            'status_home',
            'created_at',
        ]);

        return response()->json([
            'data' => $data,
            'message' => 'success',
        ]);
    }

    public function edit($id)
    {
        $data = FoodCombo::find($id);
        if ($data) {
            $data->images = $data->images_array;
        }

        return response()->json([
            'data' => $data,
            'message' => 'success',
        ]);
    }

    public function delete($id)
    {
        $query = FoodCombo::find($id);
        if ($query) {
            $query->delete();
        }

        return response()->json(['message' => 'Delete Success'], 200);
    }
}
