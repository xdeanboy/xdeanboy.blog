<?php

namespace xdeanboy\Controllers;

use xdeanboy\Exceptions\InvalidArgumentException;
use xdeanboy\Exceptions\NotFoundException;
use xdeanboy\Exceptions\UnauthorizedException;
use xdeanboy\Models\Blog\Blog;
use xdeanboy\Models\Blog\BlogComments;
use xdeanboy\Models\Blog\CommentAnswer;

class CommentAnswerController extends AbstractController
{
    public function add(int $postId, int $commentId): void
    {
        if (empty($this->user)) {
            throw new UnauthorizedException();
        }

        $post = Blog::getById($postId);

        if ($post === null) {
            throw new NotFoundException();
        }

        $comments = BlogComments::findAllByPost($postId);

        if ($comments === null) {
            throw new NotFoundException();
        }

        $commentAnswers = [];

        foreach ($comments as $comment) {
            $commentAnswers[$comment->getId()] = CommentAnswer::findAllByCommentId($comment->getId());
        }

        $commentForAnswer = BlogComments::getById($commentId);

        if ($commentForAnswer === null) {
            throw new NotFoundException();
        }

        if (!empty($_POST)) {
            try {
                CommentAnswer::add($commentId, $this->user->getId(), $_POST['text']);

                $this->view->renderHtml('blog/comment/answer/addCommentAnswerSuccessful.php',
                    ['title' => 'Успішно',
                        'post' => $post,
                        'commentForAnswer' => $commentForAnswer]);
                return;
            } catch (InvalidArgumentException $e) {
                $this->view->renderHtml('blog/comment/answer/postAddCommentAnswer.php',
                    ['title' => 'Помилка',
                        'post' => $post,
                        'comments' => $comments,
                        'commentForAnswer' => $commentForAnswer,
                        'commentAnswers' => $commentAnswers,
                        'commentError' => $e->getMessage()]);
                return;
            }
        }

        $this->view->renderHtml('blog/comment/answer/postAddCommentAnswer.php',
            ['title' => 'Помилка',
                'post' => $post,
                'comments' => $comments,
                'commentForAnswer' => $commentForAnswer,
                'commentAnswers' => $commentAnswers]);
    }

    public function edit(int $postId, int $commentId, int $answerId): void
    {
        //
    }

    public function delete(int $postId, int $commentId, int $answerId): void
    {
        //
    }

    public function deleteConfirmed(int $postId, int $commentId, int $answerId): void
    {
        //
    }
}