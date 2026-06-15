<?php

namespace App\Services;

use App\Models\Post;
use App\Helpers\Request;

class PostService
{
    private Post $postModel;

    public function __construct()
    {
        $this->postModel = new Post();
    }

    public function getByUser()
    {
        $userId = $_SESSION['user']['id'];

        $posts = $this->postModel->getByUser($userId);
        return $posts;
    }

    public function show()
    {
        $id = (int) Request::get('id');

        if (!$id) {
            die('Post ID is required');
        }

        $post = $this->postModel->findOrFail($id);

        return $post;
    }

    public function create(array $data)
    {
        $userId = $_SESSION['user']['id'];

        $this->postModel->create([
            'user_id' => $userId,
            'title' => $data['title'],
            'content' => $data['content']
        ]);

        return;
    }

    public function update(
        array $data
    ) {
        $id = (int) Request::post('id');

        if (!$id) {
            die('Post ID is required');
        }

        $userId = $_SESSION['user']['id'];

        $updateData = [
            'user_id' => $userId,
            'title'        => $data['title'] ?? '',
            'content' => $data['content'] ?? ''
        ];

        return $this->postModel->update($id, $updateData);
    }

    public function delete()
    {
        $id = (int) Request::get('id');

        if (!$id) {
            die('Product ID is required');
        }

        return $this->postModel->delete($id);
    }
}
