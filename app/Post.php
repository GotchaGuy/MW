<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['title', 'body', 'image', 'campaign_id'];

     public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }
}
