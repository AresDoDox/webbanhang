<?php

namespace App\Policies;

use App\Helpers\Session;

class PostPolicy extends Policy
{
    public static function owns(
        array $post
    ): bool {
        if (static::isAdmin()) {
            return true;
        }

        $user = Session::get('user');
        return $post['user_id'] == $user['id'];
    }
}
