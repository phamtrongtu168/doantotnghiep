<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentalBills extends Model
{
    use HasFactory;

    // Tên bảng
    protected $table = 'rental_bills';

    // Các trường được phép gán dữ liệu
    protected $fillable = [
        'rental_id',
        'month',
        'electricity_usage',
        'water_usage',
    ];

    // Các trường không cần gán thủ công (tự động tính toán hoặc tự động tạo)
    protected $appends = ['electricity_cost', 'water_cost', 'total_cost'];

    // Quan hệ với bảng RentalManagement
    public function rental()
    {
        return $this->belongsTo(RentalManagement::class, 'rental_id');
    }

    // Accessor: Tính toán `electricity_cost`
    public function getElectricityCostAttribute()
    {
        return $this->electricity_usage * $this->rental->electricity_rate;
    }

    // Accessor: Tính toán `water_cost`
    public function getWaterCostAttribute()
    {
        return $this->water_usage * $this->rental->water_rate;
    }

    // Accessor: Tính toán `total_cost`
    public function getTotalCostAttribute()
    {
        return $this->electricity_cost + $this->water_cost + $this->rental->rent_amount;
    }
}
