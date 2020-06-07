<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    protected $fillable = ['public_key', 'user_id'];
//    'euro_balance',

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
