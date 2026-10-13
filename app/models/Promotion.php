<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    protected $table = "promotion";

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function savePromotion($request)
    {
        $query = $request->id ? Promotion::find($request->id) : null;
        if (!$query) {
            $query = new Promotion();
        }

        $query->name = $request->name;
        $query->slug = $this->uniqueSlug($request->name, $query->id);
        $query->badge = $request->badge;
        $query->description = $request->description;
        $query->link = $request->link;
        $query->image = $request->image;
        $query->status = $request->status;
        $query->content = $request->content;
        $query->start_date = $request->start_date ?: null;
        $query->end_date = $request->end_date ?: null;
        $query->save();

        return $query;
    }

    private function uniqueSlug($name, $ignoreId = null)
    {
        $base = trim(preg_replace('/-+/', '-', to_slug((string) $name)), '-') ?: 'uu-dai';
        $slug = $base;
        $i = 2;
        while (Promotion::where('slug', $slug)
            ->when($ignoreId, function ($q) use ($ignoreId) {
                $q->where('id', '!=', $ignoreId);
            })
            ->exists()) {
            $slug = $base . '-' . $i++;
        }
        return $slug;
    }

    public function getIsExpiredAttribute()
    {
        return $this->end_date && $this->end_date->endOfDay()->isPast();
    }

    public function getPeriodTextAttribute()
    {
        if ($this->start_date && $this->end_date) {
            return $this->start_date->format('d/m/Y') . ' – ' . $this->end_date->format('d/m/Y');
        }
        if ($this->end_date) {
            return 'Đến hết ' . $this->end_date->format('d/m/Y');
        }
        if ($this->start_date) {
            return 'Từ ' . $this->start_date->format('d/m/Y');
        }
        return '';
    }
}
