<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WaterLocation extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'owner_id',
        'old_miter',
        'new_miter',
        'water_user_no',
        'address',
        'branch',
    ];

    // ความสัมพันธ์กับผู้ใช้
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function waterHistories()
    {
        return $this->hasMany(WaterHistory::class)
                    ->orderBy('updateAt', 'desc'); // เรียงจากใหม่ไปเก่า
    }

    public function bills()
    {
        return $this->hasMany(Bill::class);
    }

    public function trashRequest()
    {
        return $this->hasOne(TrashRequest::class, 'water_location_id', 'id');
    }

}
