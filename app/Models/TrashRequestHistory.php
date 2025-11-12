<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrashRequestHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'trash_request_id',
        'user_id',
        'message',
        'status_after'
    ];

    public function trashRequest()
    {
        return $this->belongsTo(TrashRequest::class, 'trash_request_id');
    }

    // ✅ เปลี่ยนชื่อให้ชัดเจนว่า user คือ responder
    public function responder()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

