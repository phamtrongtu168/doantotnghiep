<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Room extends Model
{
    use HasFactory;

    protected $fillable = [

        'name',
        'landlord_id',
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
        'wifi',
        'electricity_rate',
        'water_rate',
        'province_id',
        'district_id',
         'address',
        'image_url',
        'province_id',
        'district_id',
    ];

    public function images()
    {
        return $this->hasMany(RoomImage::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function landlord()
    {
    return $this->belongsTo(User::class, 'landlord_id');
    }
    public function rentalManagement()
{
    return $this->hasMany(RentalManagement::class, 'room_id');
}

}
