<?php

namespace xdeanboy\Controllers;

use xdeanboy\Exceptions\ForbiddenException;
use xdeanboy\Exceptions\InvalidArgumentException;
use xdeanboy\Exceptions\NotFoundException;
use xdeanboy\Exceptions\UnauthorizedException;
use xdeanboy\Models\Blog\Blog;
use xdeanboy\Models\Blog\BlogComments;
use xdeanboy\Models\Blog\BlogSections;
use xdeanboy\Models\Blog\CommentAnswer;

class BlogController extends AbstractController
{
    /**
     * @param int $postId
     * @return void
     * @throws NotFoundException
     * @throws UnauthorizedException
     */
    public function view(int $postId): void
    {
        if (empty($this->user)) {
            throw new UnauthorizedException();
        }

        $post = Blog::getById($postId);

        if ($post === null) {
            throw new NotFoundException('Пост не знайдено');
        }

        try {
            $comments = BlogComments::findAllByPost($post->getId());

            if ($comments === null) {
                throw new NotFoundException('Ви можете бути першим, хто прокоментує');
            }

            $commentAnswers = [];

            foreach ($comments as $comment) {
                $commentAnswers[$comment->getId()] = CommentAnswer::findAllByCommentId($comment->getId());
            }

            $this->view->renderHtml('blog/post.php',
                ['title' => 'Пост ' . $postId,
                    'post' => $post,
                    'comments' => $comments,
                    'commentAnswers' => $commentAnswers]);
            return;
        } catch (NotFoundException $e) {
            $this->view->renderHtml('blog/post.php',
                ['title' => 'Пост ' . $postId,
                    'post' => $post,
                    'error' => $e->getMessage()]);
            return;
        }
    }

    /**
     * @param int $postId
     * @return void
     * @throws ForbiddenException
     * @throws NotFoundException
     * @throws UnauthorizedException
     */
    public function edit(int $postId): void
    {
        if (empty($this->user)) {
            throw new UnauthorizedException();
        }

        if (!$this->user->isAdmin()) {
            throw new ForbiddenException();
        }

        $post = Blog::getById($postId);

        if ($post === null) {
            throw new NotFoundException('Пост не знайдено');
        }

        $sections = BlogSections::findAll();

        if ($sections === null) {
            throw new NotFoundException('Розділи контенту не знайдено');
        }

        if (!empty($_POST)) {
            try {
                $editedPost = $post->edit($_POST);

                $this->view->renderHtml('blog/editPostSuccessful.php',
                    ['title' => 'Успішно редаговано',
                        'post' => $editedPost]);
                return;
            } catch (InvalidArgumentException $e) {
                $this->view->renderHtml('blog/editPost.php',
                    ['title' => 'Редагування посту',
                        'post' => $post,
                        'sections' => $sections,
                        'error' => $e->getMessage()]);
                return;
            }
        }

        $this->view->renderHtml('blog/editPost.php',
            ['title' => 'Редагування посту',
                'post' => $post,
                'sections' => $sections]);
    }

    /**
     * @param int $postId
     * @return void
     * @throws ForbiddenException
     * @throws NotFoundException
     * @throws UnauthorizedException
     */
    public function deleteConfirmation(int $postId): void
    {
        if (empty($this->user)) {
            throw new UnauthorizedException();
        }

        if (!$this->user->isAdmin()) {
            throw new ForbiddenException();
        }

        $checkPost = Blog::getById($postId);
        $comments = BlogComments::findAllByPost($checkPost->getId());

        if ($checkPost === null) {
            throw new NotFoundException('Неможливо видалити неснуючий пост');
        }

        $postTitle = $checkPost->getTitle();
        $postImage = $checkPost->getImage();
        $checkPost->delete();

        if (!empty($postImage)) {
            $postImage->delete();
        }

        if (!empty($comments)) {
            foreach ($comments as $comment) {
                $commentAnswers = CommentAnswer::findAllByCommentId($comment->getId());

                if (!empty($commentAnswers)) {
                    foreach ($commentAnswers as $commentAnswer) {
                        $commentAnswer->delete();
                    }
                }

                $comment->delete();
            }
        }

        $this->view->renderHtml('/blog/deletePostSuccessful.php',
            ['title' => 'Успішно видалено',
                'postTitle' => $postTitle]);
    }

    /**
     * @param int $postId
     * @return void
     * @throws ForbiddenException
     * @throws NotFoundException
     * @throws UnauthorizedException
     */
    public function delete(int $postId): void
    {
        if (empty($this->user)) {
            throw new UnauthorizedException();
        }

        if (!$this->user->isAdmin()) {
            throw new ForbiddenException();
        }

        $post = Blog::getById($postId);

        if ($post === null) {
            throw new NotFoundException('Пост не знайдено');
        }

        $this->view->renderHtml('blog/deletePostConfirmation.php',
            ['title' => 'Підтвердження видалення',
                'post' => $post]);
    }

    /**
     * @return void
     * @throws ForbiddenException
     * @throws NotFoundException
     * @throws UnauthorizedException
     */
    public function add(): void
    {
        if (empty($this->user)) {
            throw new UnauthorizedException();
        }

        if (!$this->user->isAdmin()) {
            throw new ForbiddenException();
        }

        $sections = BlogSections::findAll();

        if ($sections === null) {
            throw new NotFoundException('Помилка пошуку розділів контенту');
        }

        if (!empty($_POST)) {
            try {
                $newPost = Blog::add($_POST);


                $this->view->renderHtml('blog/addPostSuccessful.php',
                    ['title' => 'Успішно створено',
                        'post' => $newPost]);
                return;
            } catch (InvalidArgumentException $e) {
                $this->view->renderHtml('blog/addPost.php',
                    ['title' => 'Створення посту',
                        'sections' => $sections,
                        'error' => $e->getMessage()]);
                return;
            }
        }

        $this->view->renderHtml('blog/addPost.php',
            ['title' => 'Створення посту',
                'sections' => $sections]);
    }

    /**
     * @param string $sectionName
     * @return void
     * @throws NotFoundException
     * @throws UnauthorizedException
     */
    public function findBySection(string $sectionName): void
    {
        if (empty($this->user)) {
            throw new UnauthorizedException();
        }

        try {
            $sections = BlogSections::findAll();

            if ($sections === null) {
                throw new NotFoundException('Розділи контенту не знайдено');
            }

            $postBySection = Blog::findAllBySection($sectionName);
        } catch (InvalidArgumentException $e) {
            $this->view->renderHtml('blog/blog.php',
                ['title' => 'Розділ ' . $sectionName,
                    'sections' => $sections,
                    'error' => $e->getMessage()]);
            return;
        }

        $this->view->renderHtml('blog/blog.php',
            ['title' => 'Розділ ' . $sectionName,
                'sections' => $sections,
                'posts' => $postBySection]);
    }

}