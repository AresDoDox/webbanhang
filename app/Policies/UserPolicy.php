<?php

namespace App\Policies;

use App\Enums\Role;
use App\Helpers\Session;

class UserPolicy extends Policy
{
    public static function canDelete(
        array $targetUser
    ): bool {
        $user = Session::get('user');
        return $user['id'] != $targetUser['id'];
    }

    public static function canChangeRole(
        array $targetUser,
        string $newRole,
        int $adminCount
    ): bool {
        if (
            $targetUser['role'] === Role::ADMIN->value
            && $newRole === Role::USER->value
            && $adminCount <= 1
        ) {
            return false;
        }

        return true;
    }
}
