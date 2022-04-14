<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\Fluent\Concerns\Has;

class  Evaluation extends Model
{
    use HasFactory;
    protected  $table ='evaluation';

    protected $fillable =[
        'user_id','movie_id','comment','star',
    ];
}
