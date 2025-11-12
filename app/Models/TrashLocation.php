<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrashLocation extends Model
{
    use HasFactory;

    public function trashRequest()
    {
        return $this->hasOne(TrashRequest::class, 'trash_location_id', 'id');
    }
    // กำหนดความสัมพันธ์ 1-to-many กับ Bill
    public function bills()
    {
        return $this->hasMany(Bill::class, 'trash_location_id');
    }
}
