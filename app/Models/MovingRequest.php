<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovingRequest extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'moving_from', 'moving_to', 'moving_date', 'service_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}