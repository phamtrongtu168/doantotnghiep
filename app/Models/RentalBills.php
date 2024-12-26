<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentalBills extends Model
{
    use HasFactory;

    protected $table = 'rental_bills';

    // Các trường có thể được gán giá trị một cách trực tiếp
    protected $fillable = [
        'rental_id',
        'start_date',
        'end_date',
        'electricity_usage',
        'water_usage',
        'status',
    ];

    // Các trạng thái hóa đơn
    const STATUS_PENDING = 'pending';
    const STATUS_PAID = 'paid';
    const STATUS_OVERDUE = 'overdue';

    // Quan hệ với RentalManagement
    public function rentalManagement()
    {
        return $this->belongsTo(RentalManagement::class, 'rental_id');
    }
}