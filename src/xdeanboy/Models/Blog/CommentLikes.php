<?php

namespace xdeanboy\Models\Blog;

use xdeanboy\Exceptions\InvalidArgumentException;
use xdeanboy\Exceptions\NotFoundException;
use xdeanboy\Exceptions\UnauthorizedException;
use xdeanboy\Models\ActiveRecordEntity;
use xdeanboy\Models\Users\User;

class CommentLikes extends ActiveRecordEntity
{
    protected $commentId;
    protected $userId;
    protected $createdAt;

    /**
     * @param int $commentId
     */
    public function setCommentId(int $commentId): void
    {
        $this->commentId = $commentId;
    }

    /**
     * @return int
     */
    public function getCommentId(): int
    {
        return $this->commentId;
    }

    /**
     * @param int $userId
     * @return void
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
        return 'comment_likes';
    }

    /**
     * @param BlogComments $comment
     * @param User $user
     * @return bool
     */
    public static function checkLikeByCommentAndUser(BlogComments $comment, User $user): bool
    {
        if (empty($comment)) {
            return false;
        }

        if (empty($user)) {
            return false;
        }

        $checkLike = self::findOneByColumns(
            'comment_id', 'user_id', $comment->getId(), $user->getId());

        return !empty($checkLike);
    }

    /**
     * @param BlogComments $comment
     * @param User $user
     * @return void
     * @throws InvalidArgumentException
     * @throws NotFoundException
     * @throws UnauthorizedException
     */
    public static function toLike(BlogComments $comment, User $user): void
    {
        if (empty($comment)) {
            throw new NotFoundException();
        }

        if (empty($user)) {
            throw new UnauthorizedException();
        }

        $checkLike = self::checkLikeByCommentAndUser($comment, $user);

        if ($checkLike) {
            throw new InvalidArgumentException('Ви вже лайкнули цей пост');
        }

        $like = new CommentLikes();
        $like->setCommentId($comment->getId());
        $like->setUserId($user->getId());
        $like->save();
    }

    /**
     * @param BlogComments $comment
     * @return array|null
     */
    public static function findAllByComment(BlogComments $comment): ?array
    {
        if (empty($comment)) {
            return null;
        }

        $result = self::findAllByColumn('comment_id', $comment->getId());

        return !empty($result) ? $result : null;
    }

    /**
     * @param BlogComments $comment
     * @return int|null
     */
    public static function countLikesByComment(BlogComments $comment): ?int
    {
        if (empty($comment)) {
            return 0;
        }

        $checkLikes = self::findAllByComment($comment);

        return !empty($checkLikes) ? count($checkLikes) : 0;
    }

    /**
     * @param BlogComments $comment
     * @param User $user
     * @return static|null
     */
    public static function getLikeByCommentAndUser(BlogComments $comment, User $user): ?self
    {
        if (empty($comment)) {
            return null;
        }

        if (empty($user)) {
            return null;
        }

        $like = self::findOneByColumns(
            'comment_id', 'user_id', $comment->getId(), $user->getId());

        return !empty($like) ? $like : null;
    }
}