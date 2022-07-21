<?php

namespace xdeanboy\Controllers;

use xdeanboy\Exceptions\ForbiddenException;
use xdeanboy\Exceptions\InvalidArgumentException;
use xdeanboy\Exceptions\NotFoundException;
use xdeanboy\Exceptions\UnauthorizedException;
use xdeanboy\Models\Blog\AnswerLikes;
use xdeanboy\Models\Blog\Blog;
use xdeanboy\Models\Blog\BlogComments;
use xdeanboy\Models\Blog\CommentAnswer;
use xdeanboy\Models\Blog\CommentLikes;

class CommentLikesController extends AbstractController
{
    /**
     * @param int $commentId
     * @return void
     * @throws NotFoundException
     * @throws UnauthorizedException
     */
    public function add(int $commentId): void
    {
        if (empty($this->user)) {
            throw new UnauthorizedException();
        }

        $comment = BlogComments::getById($commentId);

        if ($comment === null) {
            throw new NotFoundException();
        }

        $checkPost = $comment->getPost();

        if ($checkPost === null) {
            throw new NotFoundException();
        }

        try {
            CommentLikes::toLike($comment, $this->user);

            $this->view->renderHtml('blog/like/addedLikeSuccessful.php',
                ['title' => 'Успішний лайк!',
                    'toLike' => 'коммент',
                    'post' => $checkPost]);
            return;
        } catch (InvalidArgumentException $e) {
            $this->view->renderHtml('errors/errorLike.php',
                ['title' => 'Помилка to like',
                    'errorLike' => $e->getMessage()]);
            return;
        }
    }

    /**
     * @param int $commentId
     * @return void
     * @throws ForbiddenException
     * @throws NotFoundException
     * @throws UnauthorizedException
     */
    public function delete(int $commentId): void
    {
        if (empty($this->user)) {
            throw new UnauthorizedException();
        }

        $checkComment = BlogComments::getById($commentId);

        if ($checkComment === null) {
            throw new NotFoundException();
        }

        $checkPost = $checkComment->getPost();

        if ($checkPost === null) {
            throw new NotFoundException();
        }

        $checkLike = CommentLikes::checkLikeByCommentAndUser($checkComment, $this->user);

        if (!$checkLike) {
            throw new ForbiddenException();
        }

        $this->view->renderHtml('blog/like/deleteCommentLikeConfirmation.php',
            ['title' => 'Підтвердження',
                'comment' => $checkComment,
                'post' => $checkPost]);
    }

    /**
     * @param int $commentId
     * @return void
     * @throws ForbiddenException
     * @throws NotFoundException
     * @throws UnauthorizedException
     */
    public function deleteConfirmed(int $commentId): void
    {
        if (empty($this->user)) {
            throw new UnauthorizedException();
        }

        $checkComment = BlogComments::getById($commentId);

        if ($checkComment === null) {
            throw new NotFoundException();
        }

        $checkPost = $checkComment->getPost();

        if ($checkPost === null) {
            throw new NotFoundException();
        }

        $like = CommentLikes::getLikeByCommentAndUser($checkComment, $this->user);

        if ($like === null) {
            throw new ForbiddenException();
        }

        $like->delete();

        $this->view->renderHtml('blog/like/deletedLikeSuccessful.php',
            ['title' => 'Прикро =(',
                'post' => $checkPost]);
    }

    /**
     * @param int $commentId
     * @param int $answerId
     * @return void
     * @throws NotFoundException
     * @throws UnauthorizedException
     */
    public function answerAdd(int $commentId, int $answerId): void
    {
        if(empty($this->user)) {
            throw new UnauthorizedException();
        }

        $comment = BlogComments::getById($commentId);

        if ($comment === null) {
            throw new NotFoundException();
        }

        $answer = CommentAnswer::getById($answerId);

        if($answer === null) {
            throw new NotFoundException();
        }

        $checkPost = $comment->getPost();

        if ($checkPost === null) {
            throw new NotFoundException();
        }

        try {
            AnswerLikes::toLike($answer, $this->user);

            $this->view->renderHtml('blog/like/addedLikeSuccessful.php',
                ['title' => 'Успішний лайк!',
                    'toLike' => 'коммент',
                    'post' => $checkPost]);
            return;
        } catch (InvalidArgumentException $e) {
            $this->view->renderHtml('errors/errorLike.php',
                ['title' => 'Помилка to like',
                    'errorLike' => $e->getMessage()]);
            return;
        }
    }

    public function answerDelete(int $commentId, int $answerId): void
    {
        if (empty($this->user)) {
            throw new UnauthorizedException();
        }

        $checkComment = BlogComments::getById($commentId);

        if ($checkComment === null) {
            throw new NotFoundException();
        }

        $checkPost = $checkComment->getPost();

        if ($checkPost === null) {
            throw new NotFoundException();
        }

        $checkAnswer = CommentAnswer::getById($answerId);

        if ($checkAnswer === null) {
            throw new NotFoundException();
        }

        $checkLike = AnswerLikes::checkLikeByAnswerAndUser($checkAnswer, $this->user);

        if (!$checkLike) {
            throw new ForbiddenException();
        }

        $this->view->renderHtml('blog/like/deleteAnswerLikeConfirmation.php',
            ['title' => 'Підтвердження',
                'answer' => $checkAnswer,
                'comment' => $checkComment,
                'post' => $checkPost]);
    }

    /**
     * @param int $commentId
     * @return void
     * @throws ForbiddenException
     * @throws NotFoundException
     * @throws UnauthorizedException
     */
    public function answerDeleteConfirmed(int $commentId, int $answerId): void
    {
        if (empty($this->user)) {
            throw new UnauthorizedException();
        }

        $checkComment = BlogComments::getById($commentId);

        if ($checkComment === null) {
            throw new NotFoundException();
        }

        $checkPost = $checkComment->getPost();

        if ($checkPost === null) {
            throw new NotFoundException();
        }

        $checkAnswer = CommentAnswer::getById($answerId);

        if ($checkAnswer === null) {
            throw new NotFoundException();
        }

        $like = AnswerLikes::getLikeByAnswerAndUser($checkAnswer, $this->user);

        if ($like === null) {
            throw new ForbiddenException();
        }

        $like->delete();

        $this->view->renderHtml('blog/like/deletedLikeSuccessful.php',
            ['title' => 'Прикро =(',
                'post' => $checkPost]);
    }
}