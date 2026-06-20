<?php

namespace App\Policies;

use App\Enums\Role;
use App\Helpers\Session;

abstract class Policy
{
    protected static function isAdmin(): bool
    {
        $user = Session::get('user');
        return $user['role'] === Role::ADMIN->value;
    }
}
