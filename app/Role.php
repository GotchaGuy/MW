<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = ['type', 'title'];

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
