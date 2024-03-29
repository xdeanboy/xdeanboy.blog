<?php

namespace xdeanboy\Models\Blog;

use xdeanboy\Exceptions\InvalidArgumentException;
use xdeanboy\Exceptions\NotFoundException;
use xdeanboy\Exceptions\UnauthorizedException;
use xdeanboy\Models\ActiveRecordEntity;
use xdeanboy\Models\Users\User;

class BlogLikes extends ActiveRecordEntity
{
    protected $postId;
    protected $userId;
    protected $createdAt;

    /**
     * @param int $postId
     */
    public function setPostId(int $postId): void
    {
        $this->postId = $postId;
    }

    /**
     * @return int
     */
    public function getPostId(): int
    {
        return $this->postId;
    }

    /**
     * @param int $userId
     */
    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    /**
     * @return string
     */
    protected static function getTableName(): string
    {
        return 'blog_likes';
    }

    /**
     * @param Blog $post
     * @param User $user
     * @return void
     * @throws InvalidArgumentException
     * @throws NotFoundException
     * @throws UnauthorizedException
     */
    public static function toLike(Blog $post, User $user): void
    {
        if (empty($post)) {
            throw new NotFoundException();
        }

        if (empty($user)) {
            throw new UnauthorizedException();
        }

        $checkLike = self::checkLikeByPostAndUser($post, $user);

        if ($checkLike) {
            throw new InvalidArgumentException('Ви вже лайкнули цей пост');
        }

        $like = new BlogLikes();
        $like->setPostId($post->getId());
        $like->setUserId($user->getId());
        $like->save();
    }

    /**
     * @param int $postId
     * @return array|null
     */
    public static function findAllByPost(Blog $post): ?array
    {
        if (empty($post)) {
            return null;
        }

        $result = self::findAllByColumn('post_id', $post->getId());

        return !empty($result) ? $result : null;
    }

    /**
     * @param int $postId
     * @return int
     */
    public static function countLikesByPost(Blog $post): ?int
    {
        if (empty($post)) {
            return null;
        }

        $checkLikes = self::findAllByPost($post);

        return !empty($checkLikes) ? count($checkLikes) : 0;
    }

    /**
     * @param Blog $post
     * @param User $user
     * @return bool
     */
    public static function checkLikeByPostAndUser(Blog $post, User $user): bool
    {
        if (empty($post)) {
            return false;
        }

        if (empty($user)) {
            return false;
        }

        $checkLike = self::findOneByColumns(
            'post_id', 'user_id', $post->getId(), $user->getId());

        return !empty($checkLike);
    }

    /**
     * @param Blog $post
     * @param User $user
     * @return static|null
     */
    public static function getLikeByPostAndUser(Blog $post, User $user): ?self
    {
        if (empty($post)) {
            return null;
        }

        if (empty($user)) {
            return null;
        }

        $like = self::findOneByColumns(
            'post_id', 'user_id', $post->getId(), $user->getId());

        return !empty($like) ? $like : null;
    }

}