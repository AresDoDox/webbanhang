<?php

namespace App\Controllers;

use App\Helpers\Csrf;
use App\Helpers\Flash;
use App\Middleware\AuthMiddleware;
use App\Services\PostService;
use App\Validators\PostValidator;

class PostController extends Controller
{
    // get list
    public function index()
    {
        AuthMiddleware::handle();

        $postService = new PostService();
        $posts = $postService->getByUser();

        $this->view(
            'user/posts/index',
            compact('posts')
        );
    }

    public function show()
    {
        AuthMiddleware::handle();

        $postService = new PostService();
        $post = $postService->show();

        $this->view(
            'user/posts/show',
            compact('post')
        );
    }

    public function create()
    {
        AuthMiddleware::handle();

        $this->view(
            'user/posts/create'
        );
    }

    public function store()
    {
        AuthMiddleware::handle();

        if (!Csrf::verify($_POST['csrf'] ?? '')) {
            die('Invalid CSRF');
        }

        $errors = PostValidator::validate($_POST);

        if (!empty($errors)) {
            Flash::set('error', $errors[0]);
            return $this->redirect('?route=posts/create');
        }

        $postService = new PostService();
        $postService->create($_POST);

        $this->redirect('?route=posts');
    }

    public function edit()
    {
        AuthMiddleware::handle();

        $postService = new PostService();
        $post = $postService->show();

        $this->view(
            'user/posts/edit',
            compact('post')
        );
    }

    public function update()
    {
        AuthMiddleware::handle();

        if (
            !Csrf::verify($_POST['csrf'] ?? '')
        ) {
            die('Invalid CSRF');
        }

        $errors = PostValidator::validate($_POST);

        if (!empty($errors)) {
            Flash::set('error', $errors[0]);
            return $this->redirect('?route=posts/create');
        }

        $postService = new PostService();
        $updated = $postService->update($_POST);

        if ($updated) {
            Flash::set('success', 'Post updated');
        } else {
            Flash::set('error', 'Failed to update post');
        }

        $this->redirect('?route=posts');

        exit;
    }

    public function delete()
    {
        AuthMiddleware::handle();

        $postService = new PostService();
        $deleted = $postService->delete();

        if ($deleted) {
            Flash::set('success', 'Post deleted');
        } else {
            Flash::set('error', 'Failed to delete post');
        }

        $this->redirect('?route=posts');

        exit;
    }
}
