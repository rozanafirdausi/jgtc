<?php

namespace App\SuitEvent\Models;

use App\SuitEvent\Models\User;
use Suitcore\Models\SuitModel;

class OauthUser extends SuitModel
{
    public $fillable = ['provider', 'oauth_id', 'user_id', 'graph'];

    protected $casts = ['graph' => 'array'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
