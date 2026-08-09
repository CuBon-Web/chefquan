<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class FoodCombo extends Model
{
    protected $table = 'food_combos';

    protected $fillable = [
        'name',
        'slug',
        'images',
        'description',
        'menu',
        'content',
        'price',
        'sale_price',
        'sort',
        'status',
        'status_home',
    ];

    public function getImagesArrayAttribute()
    {
        if (empty($this->images)) {
            return [];
        }
        if (is_array($this->images)) {
            return $this->images;
        }
        $decoded = json_decode($this->images, true);
        return is_array($decoded) ? $decoded : [];
    }

    public function getCoverImageAttribute()
    {
        $images = $this->images_array;
        return !empty($images[0]) ? $images[0] : null;
    }

    public function getDisplayPriceAttribute()
    {
        if ($this->sale_price !== null && $this->sale_price !== '' && (float) $this->sale_price > 0) {
            return (float) $this->sale_price;
        }
        return (float) $this->price;
    }

    public function saveFoodCombo($request)
    {
        $id = $request->id;
        $images = $request->images;
        if (is_array($images)) {
            $images = json_encode(array_values($images));
        }

        $data = [
            'name' => $request->name,
            'slug' => to_slug($request->name),
            'images' => $images ?: json_encode([]),
            'description' => $request->description ?? '',
            'menu' => $request->menu ?? '',
            'content' => $request->content ?? '',
            'price' => $request->price !== null && $request->price !== '' ? $request->price : 0,
            'sale_price' => $request->sale_price !== null && $request->sale_price !== ''
                ? $request->sale_price
                : null,
            'sort' => $request->sort !== null && $request->sort !== '' ? (int) $request->sort : 0,
            'status' => $request->status !== null ? (int) $request->status : 1,
            'status_home' => $request->status_home !== null ? (int) $request->status_home : 1,
        ];

        if ($id) {
            $query = self::find($id);
            if ($query) {
                $query->fill($data);
                $query->save();
                return $query;
            }
        }

        return self::create($data);
    }
}
