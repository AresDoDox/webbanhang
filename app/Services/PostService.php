<?php

namespace App\Services;

use App\Models\Post;
use App\Policies\PostPolicy;
use App\Helpers\Session;

class PostService
{
    private Post $postModel;

    public function __construct()
    {
        $this->postModel = new Post();
    }

    public function getAll()
    {
        $posts = $this->postModel->getAll();
        return $posts;
    }

    public function getByUser()
    {
        $user = Session::get('user');
        $userId = $user['id'];

        $posts = $this->postModel->getByUser($userId);
        return $posts;
    }

    public function show(int $id)
    {
        $post = $this->postModel->findOrFail($id);

        return $post;
    }

    public function create(array $data)
    {
        $user = Session::get('user');
        $userId = $user['id'];

        $this->postModel->create([
            'user_id' => $userId,
            'title' => $data['title'],
            'content' => $data['content']
        ]);

        return;
    }

    public function update(
        int $id,
        array $data
    ) {
        $post = $this->postModel->findOrFail($id);

        if (!PostPolicy::owns($post)) {
            http_response_code(403);

            throw new \Exception('Forbidden');
        }

        $updateData = [
            'title'        => $data['title'] ?? '',
            'content' => $data['content'] ?? ''
        ];

        return $this->postModel->update($id, $updateData);
    }

    public function delete(int $id)
    {
        $post = $this->postModel->findOrFail($id);

        if (!PostPolicy::owns($post)) {
            http_response_code(403);

            throw new \Exception('Forbidden');
        }

        return $this->postModel->delete($id);
    }
}
