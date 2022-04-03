<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $table = 'photos';
    protected $guarded = [];


    public function imageable()
    {
        return $this->morphTo();
    }
}
