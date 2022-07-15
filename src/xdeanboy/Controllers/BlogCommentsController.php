<?php

namespace xdeanboy\Controllers;

use xdeanboy\Exceptions\ForbiddenException;
use xdeanboy\Exceptions\InvalidArgumentException;
use xdeanboy\Exceptions\NotFoundException;
use xdeanboy\Exceptions\UnauthorizedException;
use xdeanboy\Models\Blog\Blog;
use xdeanboy\Models\Blog\BlogComments;
use xdeanboy\Models\Blog\CommentAnswer;

class BlogCommentsController extends AbstractController
{
    /**
     * @param int $postId
     * @return void
     * @throws NotFoundException
     * @throws UnauthorizedException
     */
    public function add(int $postId): void
    {
        if (empty($this->user)) {
            throw new UnauthorizedException();
        }

        $post = Blog::getById($postId);

        if ($post === null) {
            throw new NotFoundException('Пост не знайдено');
        }

        if (!empty($_POST)) {
            try {
                $comments = BlogComments::findAllByPost($post->getId());

                BlogComments::addComment($post->getId(), $this->user->getId(), $_POST['text']);

                header('Location: /post/' . $post->getId() . '#block-comments', true, 302);
                return;
            } catch (InvalidArgumentException $e) {
                $this->view->renderHtml('blog/post.php',
                    ['title' => 'Пост ' . $postId,
                        'post' => $post,
                        'comments' => $comments,
                        'commentError' => $e->getMessage()]);
                return;
            }
        }
    }

    public function edit(int $postId, int $commentId): void
    {
        if (empty($this->user)) {
            throw new UnauthorizedException();
        }

        $post = Blog::getById($postId);

        if ($post === null) {
            throw new NotFoundException();
        }

        $comments = BlogComments::findAllByPost($post->getId());

        $editComment = BlogComments::getById($commentId);

        if ($editComment === null) {
            throw new NotFoundException();
        }

        if ($post->getId() !== $editComment->getPostId()) {
            throw new ForbiddenException();
        }

        $commentAnswers = [];

        foreach ($comments as $comment) {
            $commentAnswers[$comment->getId()] = CommentAnswer::findAllByCommentId($comment->getId());
        }

        $forbidden = false;

        if ($this->user->getId() === $editComment->getUser()->getId()) {
            $forbidden = true;
        }

        if ($this->user->isAdmin()) {
            $forbidden = true;
        }

        if (!$forbidden) {
            throw new ForbiddenException();
        }

        if (!empty($_POST)) {
            try {
                $editComment->editComment($_POST['text']);

                $this->view->renderHtml('blog/comment/editPostCommentSuccessful.php',
                ['title' => 'Успішно редаговано',
                    'post' => $post]);
                return;
            } catch (InvalidArgumentException $e) {
                $this->view->renderHtml('blog/comment/editPostComment.php',
                    ['title' => 'Редагування коментаря',
                        'post' => $post,
                        'comments' => $comments,
                        'editComment' => $editComment,
                        'commentAnswers' => $commentAnswers,
                        'commentError' => $e->getMessage()]);
                return;
            }
        }

        $this->view->renderHtml('blog/comment/editPostComment.php',
        ['title' => 'Редагування коментаря',
            'post' => $post,
            'comments' => $comments,
            'editComment' => $editComment,
            'commentAnswers' => $commentAnswers]);
    }

    /**
     * @param int $postId
     * @param int $commentId
     * @return void
     * @throws ForbiddenException
     * @throws NotFoundException
     * @throws UnauthorizedException
     */
    public function delete(int $postId, int $commentId): void
    {
        if (empty($this->user)) {
            throw new UnauthorizedException();
        }

        $post = Blog::getById($postId);

        if ($post === null) {
            throw new NotFoundException();
        }

        $comment = BlogComments::getById($commentId);

        if ($comment === null) {
            throw new NotFoundException();
        }

        if ($post->getId() !== $comment->getPostId()) {
            throw new ForbiddenException();
        }

        $forbidden = false;

        if ($this->user->getId() === $comment->getUser()->getId()) {
            $forbidden = true;
        }

        if ($this->user->isAdmin()) {
            $forbidden = true;
        }

        if (!$forbidden) {
            throw new ForbiddenException();
        }

        $this->view->renderHtml('blog/comment/deleteCommentConfirmation.php',
        ['title' => 'Підтвердження видалення',
            'post' => $post,
            'comment' => $comment]);
    }

    /**
     * @param int $postId
     * @param int $commentId
     * @return void
     * @throws ForbiddenException
     * @throws NotFoundException
     * @throws UnauthorizedException
     */
    public function deleteConfirmed(int $postId, int $commentId): void
    {
        if (empty($this->user)) {
            throw new UnauthorizedException();
        }

        $post = Blog::getById($postId);

        if ($post === null) {
            throw new NotFoundException();
        }

        $comment = BlogComments::getById($commentId);

        if ($comment === null) {
            throw new NotFoundException();
        }

        if ($post->getId() !== $comment->getPostId()) {
            throw new ForbiddenException();
        }

        $forbidden = false;

        if ($this->user->getId() === $comment->getUser()->getId()) {
            $forbidden = true;
        }

        if ($this->user->isAdmin()) {
            $forbidden = true;
        }

        if (!$forbidden) {
            throw new ForbiddenException();
        }

        $comment->delete();

        $commentAnswers = CommentAnswer::findAllByCommentId($commentId);

        if (!empty($commentAnswers)) {
            foreach ($commentAnswers as $commentAnswer) {
                $commentAnswer->delete();
            }
        }

        $this->view->renderHtml('blog/comment/deleteCommentSuccessful.php',
        ['title' => 'Успішно виделано',
            'post' => $post,
            'comment' => $comment]);
    }
}