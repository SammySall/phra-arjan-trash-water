<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'trash_location_id',
        'water_location_id',
        'user_id',
        'amount',
        'status',
        'due_date',
        'paid_date',
        'slip_path',
        'unit_price',
    ];

    // ✅ ความสัมพันธ์กับผู้ใช้
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ✅ ความสัมพันธ์กับจุดทิ้งขยะ
    public function trashLocation()
    {
        return $this->belongsTo(TrashLocation::class, 'trash_location_id');
    }

    // ✅ ความสัมพันธ์กับจุดใช้น้ำ
    public function waterLocation()
    {
        return $this->belongsTo(WaterLocation::class, 'water_location_id');
    }
    public function histories()
    {
        return $this->belongsTo(WaterHistory::class, 'water_location_id');
    }
}
