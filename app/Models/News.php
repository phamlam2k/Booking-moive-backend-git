<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\Fluent\Concerns\Has;

class  News extends Model
{
    use HasFactory;
    protected  $table ='news';

    protected $fillable =[
        'name','detail','image','description',
    ];
}
