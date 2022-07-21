<?php

namespace xdeanboy\Models\Blog;

use xdeanboy\Exceptions\InvalidArgumentException;
use xdeanboy\Exceptions\NotFoundException;
use xdeanboy\Exceptions\UnauthorizedException;
use xdeanboy\Models\ActiveRecordEntity;
use xdeanboy\Models\Users\User;

class AnswerLikes extends ActiveRecordEntity
{
    protected $answerId;
    protected $userId;
    protected $createdAt;

    /**
     * @param int $answerId
     */
    public function setAnswerId(int $answerId): void
    {
        $this->answerId = $answerId;
    }

    /**
     * @return int
     */
    public function getAnswerId(): int
    {
        return $this->answerId;
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
        return 'answer_likes';
    }

    /**
     * @param CommentAnswer $answer
     * @param User $user
     * @return bool
     */
    public static function checkLikeByAnswerAndUser(CommentAnswer $answer, User $user): bool
    {
        if (empty($answer)) {
            return false;
        }

        if (empty($user)) {
            return false;
        }

        $checkLike = self::findOneByColumns(
            'answer_id', 'user_id', $answer->getId(), $user->getId());

        return !empty($checkLike);
    }

    /**
     * @param CommentAnswer $answer
     * @param User $user
     * @return void
     * @throws InvalidArgumentException
     * @throws NotFoundException
     * @throws UnauthorizedException
     */
    public static function toLike(CommentAnswer $answer, User $user): void
    {
        if (empty($answer)) {
            throw new NotFoundException();
        }

        if (empty($user)) {
            throw new UnauthorizedException();
        }

        $checkLike = self::checkLikeByAnswerAndUser($answer, $user);

        if ($checkLike) {
            throw new InvalidArgumentException('Ви вже лайкнули цей пост');
        }

        $like = new AnswerLikes();
        $like->setAnswerId($answer->getId());
        $like->setUserId($user->getId());
        $like->save();
    }

    /**
     * @param CommentAnswer $answer
     * @return array|null
     */
    public static function findAllByAnswer(CommentAnswer $answer): ?array
    {
        if (empty($answer)) {
            return null;
        }

        $result = self::findAllByColumn('answer_id', $answer->getId());

        return !empty($result) ? $result : null;
    }

    /**
     * @param CommentAnswer $answer
     * @return int
     */
    public static function countLikesByAnswer(CommentAnswer $answer): int
    {
        if (empty($answer)) {
            return 0;
        }

        $checkLikes = self::findAllByAnswer($answer);

        return !empty($checkLikes) ? count($checkLikes) : 0;
    }

    /**
     * @param BlogComments $comment
     * @param User $user
     * @return static|null
     */
    public static function getLikeByAnswerAndUser(CommentAnswer $answer, User $user): ?self
    {
        if (empty($answer)) {
            return null;
        }

        if (empty($user)) {
            return null;
        }

        $like = self::findOneByColumns(
            'answer_id', 'user_id', $answer->getId(), $user->getId());

        return !empty($like) ? $like : null;
    }
}