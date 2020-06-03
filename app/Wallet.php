<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    protected $fillable = ['public_key', 'euro_balance', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
