<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WaterHistory extends Model
{
    use HasFactory;

    public $timestamps = false; // ✅ ปิด timestamps

    protected $fillable = [
        'water_location_id',
        'old_miter',
        'update_miter',
        'updateAt',
        'updateBy',
    ];

    // ความสัมพันธ์กับ water_location
    public function waterLocation()
    {
        return $this->belongsTo(WaterLocation::class);
    }
}
