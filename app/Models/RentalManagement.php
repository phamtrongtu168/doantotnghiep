<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentalManagement extends Model
{
    use HasFactory;

    protected $table = 'rental_management';

    protected $fillable = [
        'room_id',
        'tenant_id',
        'landlord_id',
        'start_date',
        'end_date',
        'rent_amount',
        'electricity_rate',
        'water_rate',
        'status',
    ];

    public function room()
    {
    return $this->belongsTo(Room::class);
    }

    public function tenant()
    {
    return $this->belongsTo(User::class, 'tenant_id');
    }

    public function landlord()
    {
    return $this->belongsTo(User::class, 'landlord_id');
    }
}