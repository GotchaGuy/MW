<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = ['title'];

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
