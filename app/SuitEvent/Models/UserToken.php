<?php

namespace App\SuitEvent\Models;

use App\SuitEvent\Models\User;
use Suitcore\Models\SuitModel;
use \DateTime as DateTime;

/**
user_tokens :
- id
- user_id (users entity ID)
- token
- created_at (datetime)
- updated_at (datetime)
 **/

class UserToken extends SuitModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'user_tokens';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $fillable = ['user_id', 'token'];

    /**
     * The attributes that are visible
     *
     * @var array
     */
    protected $visible = ['token', 'user'];

    // METHODS

    /**
     * Relationship to User
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function generateToken()
    {
        return md5($this->getKey() . '#suitevent#' . date('YmdHis') . str_random(32));
    }

    public static function getUserTokenFromUser(User $user)
    {
        $uToken = static::firstOrNew(['user_id' => $user->getKey()]);

        if (! $uToken->token) {
            $uToken->token = $uToken->generateToken();

            $uToken->save();
        }

        return $uToken;
    }
}
