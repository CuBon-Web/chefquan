<?php

namespace App\models\website;

use Illuminate\Database\Eloquent\Model;

class TovBanner extends Model
{
    protected $table = "tov_banners";
    protected $fillable = [
        'image',
        'image_mobile',
        'eyebrow',
        'title',
        'description',
        'button_text',
        'button_link',
        'video_text',
        'video_link',
        'sort',
        'status',
    ];
}
