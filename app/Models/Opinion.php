<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\Fluent\Concerns\Has;

class  Opinion extends Model
{
    use HasFactory;
    protected  $table ='opinion';

    protected $fillable =[
        'title','detail','user_id',
    ];
}
