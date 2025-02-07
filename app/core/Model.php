<?php
namespace App\Core;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Model extends Eloquent
{
    protected $guarded = ['id'];
    public $timestamps = true;
}