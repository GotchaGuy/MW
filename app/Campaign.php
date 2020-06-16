<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    protected $fillable = ['title', 'euro_goal', 'start', 'end', 'image', 'description', 'user_id', 'category_id', 'following'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function donations()
    {
        return $this->hasMany(Donation::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function follows()
    {
        return $this->belongsToMany(User::class);
    }
}
