<?php

namespace App\Http\Controllers\Api\Website;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\models\website\TovBanner;

class TovBannerController extends Controller
{
    public function createOrUpdate(Request $request)
    {
        $rows = is_array($request->data) ? $request->data : [];

        DB::transaction(function () use ($rows) {
            TovBanner::query()->delete();

            foreach (array_values($rows) as $index => $value) {
                TovBanner::create([
                    'image' => $value['image'] ?? '',
                    'image_mobile' => $value['image_mobile'] ?? '',
                    'eyebrow' => $value['eyebrow'] ?? '',
                    'title' => $value['title'] ?? '',
                    'description' => $value['description'] ?? '',
                    'button_text' => $value['button_text'] ?? '',
                    'button_link' => $value['button_link'] ?? '',
                    'video_text' => $value['video_text'] ?? '',
                    'video_link' => $value['video_link'] ?? '',
                    'sort' => $index + 1,
                    'status' => isset($value['status']) ? (int) $value['status'] : 1,
                ]);
            }
        });

        return response()->json([
            'messenge' => 'success'
        ], 200);
    }

    public function list()
    {
        $data = TovBanner::orderBy('sort')->orderBy('id')->get();
        return response()->json([
            'messenge' => 'success',
            'data' => $data
        ], 200);
    }
}
