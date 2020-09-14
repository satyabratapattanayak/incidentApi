<?php

namespace App\Modules\Incidents\Models;

class Category extends \Illuminate\Database\Eloquent\Model
{
    protected $guarded = ['id'];
    protected $table = 'categories';
    public $timestamps = false;
}
