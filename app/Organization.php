<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
     protected $fillable = ['title', 'location', 'user_id', 'field_of_work', 'description'];

     public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function campaigns()
    {
        return $this->hasMany(Campaign::class);
    }
}
