<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Emergency extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'name',
        'tel',
        'description',
        'picture',
        'lat',
        'lng',
    ];
}
