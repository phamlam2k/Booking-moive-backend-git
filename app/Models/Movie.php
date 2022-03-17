<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type_of_movie',
        'range_of_movie',
        'range_age',
        'dimension',
        'start_date',
        'start_time',
        'actor',
        'director',
        'trailer'
    ];
}
