<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrashBank extends Model
{
    use HasFactory;

    protected $table = 'trash_bank';

    protected $fillable = [
        'type',
        'subtype',
        'weight',
        'amount',
        'depositor',
        'creator_id',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }
}
