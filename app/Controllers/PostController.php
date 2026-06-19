<?php

namespace App\Controllers;

use App\Helpers\Csrf;
use App\Helpers\Flash;
use App\Middleware\AuthMiddleware;
use App\Services\PostService;
use App\Validators\PostValidator;
use App\Enums\Role;
use App\Helpers\Request;

class PostController extends Controller
{
    // get list
    public function index()
    {
        try {
            AuthMiddleware::handle();

            $postService = new PostService();
            if ($_SESSION['user']['role'] === Role::ADMIN->value) {
                $posts = $postService->getAll();
            } else {
                $posts = $postService->getByUser();
            }

            $this->view(
                'user/posts/index',
                compact('posts')
            );
        } catch (\Exception $e) {
            Flash::set('error', $e->getMessage());
        }
    }

    public function show(int $id)
    {
        try {
            AuthMiddleware::handle();

            if (!$id) {
                throw new \Exception('Post ID is required');
            }

            $postService = new PostService();
            $post = $postService->show($id);

            $this->view(
                'user/posts/show',
                compact('post')
            );
        } catch (\Exception $e) {
            Flash::set('error', $e->getMessage());
        }
    }

    public function create()
    {
        try {
            AuthMiddleware::handle();

            $this->view(
                'user/posts/create'
            );
        } catch (\Exception $e) {
            Flash::set('error', $e->getMessage());
        }
    }

    public function store()
    {
        try {
            AuthMiddleware::handle();

            if (!Csrf::verify($_POST['csrf'] ?? '')) {
                throw new \Exception('Invalid CSRF');
            }

            $errors = PostValidator::validate($_POST);

            if (!empty($errors)) {
                Flash::set('error', $errors[0]);
                return $this->redirect('/posts/create');
            }

            $postService = new PostService();
            $postService->create($_POST);

            $this->redirect('/posts');
        } catch (\Exception $e) {
            Flash::set('error', $e->getMessage());
        }
    }

    public function edit(int $id)
    {
        try {
            AuthMiddleware::handle();

            if (!$id) {
                throw new \Exception('Post ID is required');
            }

            $postService = new PostService();
            $post = $postService->show($id);

            $this->view(
                'user/posts/edit',
                compact('post')
            );
        } catch (\Exception $e) {
            Flash::set('error', $e->getMessage());
        }
    }

    public function update()
    {
        try {
            AuthMiddleware::handle();

            $id = (int) Request::post('id');

            if (!$id) {
                throw new \Exception('Post ID is required');
            }

            if (
                !Csrf::verify($_POST['csrf'] ?? '')
            ) {
                throw new \Exception('Invalid CSRF');
            }

            $errors = PostValidator::validate($_POST);

            if (!empty($errors)) {
                Flash::set('error', $errors[0]);
                return $this->redirect("/posts/edit/{$id}");
            }

            $postService = new PostService();
            $updated = $postService->update($id, $_POST);

            if ($updated) {
                Flash::set('success', 'Post updated');
            } else {
                Flash::set('error', 'Failed to update post');
            }

            $this->redirect('/posts');
        } catch (\Exception $e) {
            Flash::set('error', $e->getMessage());
        }
    }

    public function delete(int $id)
    {
        try {
            AuthMiddleware::handle();

            if (!$id) {
                throw new \Exception('Post ID is required');
            }

            $postService = new PostService();
            $deleted = $postService->delete($id);

            if ($deleted) {
                Flash::set('success', 'Post deleted');
            } else {
                Flash::set('error', 'Failed to delete post');
            }

            $this->redirect('/posts');
        } catch (\Exception $e) {
            Flash::set('error', $e->getMessage());
        }
    }
}
