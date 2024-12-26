<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentalManagement extends Model
{
    use HasFactory;

    protected $table = 'rental_managements';

    // Các trường có thể được gán giá trị một cách trực tiếp
    protected $fillable = [
        'room_id',
        'tenant_id',
        'start_date',
        'end_date',
        'status',
    ];

    // Các trạng thái của hợp đồng
    const STATUS_ACTIVE = 'active';
    const STATUS_PENDING = 'pending';
    const STATUS_COMPLETED = 'completed';
    const STATUS_CANCELLED = 'cancelled';

    // Quan hệ với Rooms
    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }

    // Quan hệ với Users (Tenant)
    public function tenant()
    {
        return $this->belongsTo(User::class, 'tenant_id');
    }

    // Quan hệ với RentalBills
    public function rentalBills()
    {
        return $this->hasMany(RentalBills::class, 'rental_id');
    }

}
