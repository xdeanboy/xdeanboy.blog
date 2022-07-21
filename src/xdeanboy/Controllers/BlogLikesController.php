<?php

namespace xdeanboy\Controllers;

use xdeanboy\Exceptions\ForbiddenException;
use xdeanboy\Exceptions\InvalidArgumentException;
use xdeanboy\Exceptions\NotFoundException;
use xdeanboy\Exceptions\UnauthorizedException;
use xdeanboy\Models\Blog\Blog;
use xdeanboy\Models\Blog\BlogLikes;

class BlogLikesController extends AbstractController
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

        $checkPost = Blog::getById($postId);

        if ($checkPost === null) {
            throw new NotFoundException('Пост не знайдено');
        }

        try {
            BlogLikes::toLike($checkPost, $this->user);

            $this->view->renderHtml('blog/like/addedLikeSuccessful.php',
                ['title' => 'Успішний лайк!',
                    'toLike' => 'пост',
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
     * @param int $postId
     * @param int $likeId
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

        $checkPost = Blog::getById($postId);

        if ($checkPost === null) {
            throw new NotFoundException();
        }

        $checkLike = BlogLikes::checkLikeByPostAndUser($checkPost, $this->user);

        if (!$checkLike) {
            throw new ForbiddenException();
        }

        $this->view->renderHtml('blog/like/deleteBlogLikeConfirmation.php',
            ['title' => 'Підтвердження',
                'post' => $checkPost]);
    }

    /**
     * @param int $postId
     * @return void
     * @throws ForbiddenException
     * @throws NotFoundException
     * @throws UnauthorizedException
     */
    public function deleteConfirmed(int $postId): void
    {
        if (empty($this->user)) {
            throw new UnauthorizedException();
        }

        $checkPost = Blog::getById($postId);

        if ($checkPost === null) {
            throw new NotFoundException();
        }

        $checkLike = BlogLikes::getLikeByPostAndUser($checkPost, $this->user);

        if ($checkLike === null) {
            throw new ForbiddenException();
        }

        $checkLike->delete();

        $this->view->renderHtml('blog/like/deletedLikeSuccessful.php',
        ['title' => 'Прикро =(',
            'post' => $checkPost]);
    }
}