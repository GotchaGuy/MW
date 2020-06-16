<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    protected $fillable = ['user_id', 'campaign_id'];

    public function campaigns()
    {
        return $this->hasMany(Campaign::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
