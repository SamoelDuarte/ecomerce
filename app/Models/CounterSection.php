<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CounterSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'language_id',
        'image',
        'title',
        'text'
    ];
}
