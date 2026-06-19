<?php

namespace App\Policies;

use App\Enums\Role;

abstract class Policy
{
    protected static function isAdmin(): bool
    {
        return $_SESSION['user']['role'] === Role::ADMIN->value;
    }
}
