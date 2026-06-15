<?php

namespace App\Policies;

class PostPolicy
{
    public static function owns(
        array $post
    ): bool {
        $userId = $_SESSION['user']['id'];

        return $post['user_id'] == $userId;
    }
}
