<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Room extends Model
{
    use HasFactory;

    protected $fillable = [

        'name',
        'description',
        'price',
        'area',
        'max_occupants',
        'air_conditioners',
        'kitchens',
        'refrigerators',
        'washing_machines',
        'toilets',
        'bathrooms',
        'bedrooms',
        'province_id',
        'district_id',
         'address',
        'image_url',
        'province_id',
        'district_id',
        'landlord_id',
    ];

    public function images()
    {
        return $this->hasMany(RoomImage::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
