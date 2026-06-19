<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    private User $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    public function getUsers(
        int $page,
        int $limit = 10,
        string | null $keyword = null
    ) {
        if ($keyword) {
            $result = $this->userModel->searchPaginate($keyword, $page, $limit);
        } else {
            $result = $this->userModel->paginate($page, $limit);
        }
        return $result;
    }

    public function search(string $keyword)
    {
        return $this->userModel->search($keyword);
    }

    public function findUser(int $id)
    {
        return $this->userModel->find($id);
    }
}
