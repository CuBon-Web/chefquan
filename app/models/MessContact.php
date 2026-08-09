<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class MessContact extends Model
{
    protected $table = "mess_contact";

    protected $fillable = [
        'name',
        'email',
        'phone',
        'type',
        'booking_date',
        'booking_time',
        'guests',
        'status',
        'mess',
        'service_id',
        'service_name',
        'service_slug',
        'service_cate_slug',
    ];

    protected $casts = [
        'booking_date' => 'date',
        'guests' => 'integer',
    ];
}
