<?php

namespace App\Policies;

class PostPolicy extends Policy
{
    public static function owns(
        array $post
    ): bool {
        if (static::isAdmin()) {
            return true;
        }

        return $post['user_id'] == $_SESSION['user']['id'];
    }
}
