<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['name'];


    /* 
    constant variables
    */
    public const IS_AUTHOR = 1;
    public const IS_EDITOR = 2;
    public const IS_SUBSCRIBER = 3;
    public const IS_ADMIN = 4;
}
