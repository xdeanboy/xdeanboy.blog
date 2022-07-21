<?php

namespace xdeanboy\Controllers;

use xdeanboy\Exceptions\ForbiddenException;
use xdeanboy\Exceptions\InvalidArgumentException;
use xdeanboy\Exceptions\NotFoundException;
use xdeanboy\Exceptions\UnauthorizedException;
use xdeanboy\Models\Blog\AnswerLikes;
use xdeanboy\Models\Blog\Blog;
use xdeanboy\Models\Blog\BlogComments;
use xdeanboy\Models\Blog\BlogLikes;
use xdeanboy\Models\Blog\CommentAnswer;
use xdeanboy\Models\Blog\CommentLikes;

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

        $countPostLikes = BlogLikes::countLikesByPost($post);

        $comments = BlogComments::findAllByPost($postId);

        if ($comments === null) {
            throw new NotFoundException();
        }

        $commentAnswers = [];
        $countCommentLikes = [];
        $countAnswerLikes = [];

        foreach ($comments as $comment) {
            $commentAnswers[$comment->getId()] = CommentAnswer::findAllByCommentId($comment->getId());
            $countCommentLikes[$comment->getId()] = CommentLikes::countLikesByComment($comment);

            if (!empty($commentAnswers)) {
                foreach ($commentAnswers[$comment->getId()] as $commentAnswer) {
                    $countAnswerLikes[$commentAnswer->getId()] = AnswerLikes::countLikesByAnswer($commentAnswer);
                }
            }
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
                        'countPostLikes' => $countPostLikes,
                        'countCommentLikes' => $countCommentLikes,
                        'countAnswerLikes' => $countAnswerLikes,
                        'commentError' => $e->getMessage()]);
                return;
            }
        }

        $this->view->renderHtml('blog/comment/answer/postAddCommentAnswer.php',
            ['title' => 'Помилка',
                'post' => $post,
                'comments' => $comments,
                'commentForAnswer' => $commentForAnswer,
                'commentAnswers' => $commentAnswers,
                'countPostLikes' => $countPostLikes,
                'countCommentLikes' => $countCommentLikes,
                'countAnswerLikes' => $countAnswerLikes,]);
    }

    public function addForAnswer(int $postId, int $commentId, int $answerId): void
    {
        if(empty($this->user)) {
            throw new UnauthorizedException();
        }

        $post = Blog::getById($postId);

        if ($post === null) {
            throw new NotFoundException();
        }

        $countPostLikes = BlogLikes::countLikesByPost($post);

        $comments = BlogComments::findAllByPost($postId);

        if ($comments === null) {
            throw new NotFoundException();
        }

        $commentAnswers = [];
        $countCommentLikes = [];
        $countAnswerLikes = [];

        foreach ($comments as $comment) {
            $commentAnswers[$comment->getId()] = CommentAnswer::findAllByCommentId($comment->getId());
            $countCommentLikes[$comment->getId()] = CommentLikes::countLikesByComment($comment);

            if (!empty($commentAnswers)) {
                foreach ($commentAnswers[$comment->getId()] as $commentAnswer) {
                    $countAnswerLikes[$commentAnswer->getId()] = AnswerLikes::countLikesByAnswer($commentAnswer);
                }
            }
        }

        $commentForAnswer = BlogComments::getById($commentId);

        if ($commentForAnswer === null) {
            throw new NotFoundException();
        }

        $answerForAnswer = CommentAnswer::getById($answerId);

        if($answerForAnswer === null) {
            throw new NotFoundException();
        }

        if (!empty($_POST)) {
            try {
                CommentAnswer::add($commentId, $this->user->getId(), $_POST['text']);

                $this->view->renderHtml('blog/comment/answer/addCommentAnswerSuccessful.php',
                    ['title' => 'Успішно',
                        'post' => $post,
                        'commentForAnswer' => $answerForAnswer]);
                return;
            } catch (InvalidArgumentException $e) {
                $this->view->renderHtml('blog/comment/answer/postAddAnswerForAnswer.php',
                    ['title' => 'Помилка',
                        'post' => $post,
                        'comments' => $comments,
                        'commentForAnswer' => $commentForAnswer,
                        'commentAnswers' => $commentAnswers,
                        'answerForAnswer' => $answerForAnswer,
                        'countPostLikes' => $countPostLikes,
                        'countCommentLikes' => $countCommentLikes,
                        'countAnswerLikes' => $countAnswerLikes,
                        'commentError' => $e->getMessage()]);
                return;
            }
        }

        $this->view->renderHtml('blog/comment/answer/postAddAnswerForAnswer.php',
            ['title' => 'Помилка',
                'post' => $post,
                'comments' => $comments,
                'commentForAnswer' => $commentForAnswer,
                'commentAnswers' => $commentAnswers,
                'answerForAnswer' => $answerForAnswer,
                'countPostLikes' => $countPostLikes,
                'countCommentLikes' => $countCommentLikes,
                'countAnswerLikes' => $countAnswerLikes]);
    }

    public function edit(int $postId, int $commentId, int $answerId): void
    {
        if (empty($this->user)) {
            throw new UnauthorizedException();
        }

        $post = Blog::getById($postId);

        if ($post === null) {
            throw new NotFoundException();
        }

        $countPostLikes = BlogLikes::countLikesByPost($post);

        $comments = BlogComments::findAllByPost($postId);

        if ($comments === null) {
            throw new NotFoundException();
        }

        $commentAnswers = [];
        $countCommentLikes = [];
        $countAnswerLikes = [];

        foreach ($comments as $comment) {
            $commentAnswers[$comment->getId()] = CommentAnswer::findAllByCommentId($comment->getId());
            $countCommentLikes[$comment->getId()] = CommentLikes::countLikesByComment($comment);

            if (!empty($commentAnswers)) {
                foreach ($commentAnswers[$comment->getId()] as $commentAnswer) {
                    $countAnswerLikes[$commentAnswer->getId()] = AnswerLikes::countLikesByAnswer($commentAnswer);
                }
            }
        }

        $commentForAnswer = BlogComments::getById($commentId);

        if ($commentForAnswer === null) {
            throw new NotFoundException();
        }

        $editAnswer = CommentAnswer::getById($answerId);

        if( $editAnswer === null) {
            throw new NotFoundException();
        }

        $forbidden = false;

        if ($this->user->getId() === $editAnswer->getUser()->getId()) {
            $forbidden = true;
        }

        if ($this->user->isAdmin()) {
            $forbidden = true;
        }

        if ($this->user->isModerator()) {
            $forbidden = true;
        }

        if (!$forbidden) {
            throw new ForbiddenException();
        }

        if (!empty($_POST)) {
            try {
                $editAnswer->edit($_POST['text']);

                $this->view->renderHtml('blog/comment/answer/editCommentAnswerSuccessful.php',
                    ['title' => 'Успішно',
                        'post' => $post,
                        'editAnswer' => $editAnswer]);
                return;
            } catch (InvalidArgumentException $e) {
                $this->view->renderHtml('blog/comment/answer/postEditCommentAnswer.php',
                    ['title' => 'Помилка',
                        'post' => $post,
                        'comments' => $comments,
                        'commentForAnswer' => $commentForAnswer,
                        'commentAnswers' => $commentAnswers,
                        'editAnswer' => $editAnswer,
                        'countPostLikes' => $countPostLikes,
                        'countCommentLikes' => $countCommentLikes,
                        'countAnswerLikes' => $countAnswerLikes,
                        'editAnswerError' => $e->getMessage()]);
                return;
            }
        }

        $this->view->renderHtml('blog/comment/answer/postEditCommentAnswer.php',
            ['title' => 'Помилка',
                'post' => $post,
                'comments' => $comments,
                'commentForAnswer' => $commentForAnswer,
                'commentAnswers' => $commentAnswers,
                'editAnswer' => $editAnswer,
                'countPostLikes' => $countPostLikes,
                'countCommentLikes' => $countCommentLikes,
                'countAnswerLikes' => $countAnswerLikes]);
    }

    /**
     * @param int $postId
     * @param int $commentId
     * @param int $answerId
     * @return void
     * @throws ForbiddenException
     * @throws NotFoundException
     * @throws UnauthorizedException
     */
    public function delete(int $postId, int $commentId, int $answerId): void
    {
        if (empty($this->user)) {
            throw new UnauthorizedException();
        }

        $post = Blog::getById($postId);

        if ($post === null) {
            throw new NotFoundException('Пост не знайдено');
        }

        $comment = BlogComments::getById($commentId);

        if ($comment === null) {
            throw new NotFoundException('Комент не знайдений');
        }

        if ($post->getId() !== $comment->getPostId()) {
            throw new ForbiddenException();
        }

        $commentAnswer = CommentAnswer::getById($answerId);

        if ($commentAnswer === null) {
            throw new NotFoundException('Відповідь не знайдена');
        }

        $forbidden = false;

        if ($this->user->getId() === $commentAnswer->getUser()->getId()) {
            $forbidden = true;
        }

        if ($this->user->isAdmin()) {
            $forbidden = true;
        }

        if ($this->user->isModerator()) {
            $forbidden = true;
        }

        if (!$forbidden) {
            throw new ForbiddenException();
        }

        $this->view->renderHtml('blog/comment/answer/deleteCommentAnswerConfirmation.php',
            ['title' => 'Підтвердження видалення',
                'post' => $post,
                'comment' => $comment,
                'commentAnswer' => $commentAnswer]);
    }

    /**
     * @param int $postId
     * @param int $commentId
     * @param int $answerId
     * @return void
     * @throws ForbiddenException
     * @throws NotFoundException
     * @throws UnauthorizedException
     */
    public function deleteConfirmed(int $postId, int $commentId, int $answerId): void
    {
        if (empty($this->user)) {
            throw new UnauthorizedException();
        }

        $post = Blog::getById($postId);

        if ($post === null) {
            throw new NotFoundException('Пост не знайдено');
        }

        $comment = BlogComments::getById($commentId);

        if ($comment === null) {
            throw new NotFoundException('Коментарій не знайдено');
        }

        if ($post->getId() !== $comment->getPostId()) {
            throw new ForbiddenException();
        }

        $commentAnswer = CommentAnswer::getById($answerId);

        if ($commentAnswer === null) {
            throw new NotFoundException('Відповідь не знайдена');
        }

        $forbidden = false;

        if ($this->user->getId() === $commentAnswer->getUser()->getId()) {
            $forbidden = true;
        }

        if ($this->user->isAdmin()) {
            $forbidden = true;
        }

        if($this->user->isModerator()) {
            $forbidden = true;
        }

        if (!$forbidden) {
            throw new ForbiddenException();
        }

        $this->view->renderHtml('blog/comment/deleteCommentSuccessful.php',
            ['title' => 'Успішно виделано',
                'post' => $post]);
    }
}