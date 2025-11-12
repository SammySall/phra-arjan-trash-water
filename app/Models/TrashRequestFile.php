<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrashRequestFile extends Model
{
    use HasFactory;
    

    protected $fillable = [
        'trash_request_id',
        'field_name',
        'file_path',
        'file_name',
    ];

    public function trashRequest()
    {
        return $this->belongsTo(TrashRequest::class);
    }
}
