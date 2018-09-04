<?php

namespace App\Models;

use App\SuitEvent\Models\GenericModel;

class PasswordReset extends GenericModel
{
    public $table = 'password_resets';
}
