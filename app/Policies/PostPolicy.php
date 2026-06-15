<?php

namespace App\Policies;

use App\Enums\Role;

class PostPolicy
{
    public static function owns(
        array $post
    ): bool {
        if ($_SESSION['user']['role'] === Role::ADMIN->value) {
            return true;
        }

        return $post['user_id'] == $_SESSION['user']['id'];
    }
}
