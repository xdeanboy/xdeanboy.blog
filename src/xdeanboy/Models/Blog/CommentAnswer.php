<?php

namespace xdeanboy\Models\Blog;

use xdeanboy\Exceptions\InvalidArgumentException;
use xdeanboy\Models\ActiveRecordEntity;
use xdeanboy\Models\Users\User;

class CommentAnswer extends ActiveRecordEntity
{
    protected $commentId;
    protected $userId;
    protected $text;
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
     * @param string $text
     */
    public function setText(string $text): void
    {
        $this->text = $text;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
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
        return 'comment_answer';
    }

    /**
     * @param int $commentId
     * @return array|null
     */
    public static function findAllByCommentId(int $commentId): ?array
    {
        $result = self::findAllByColumnOrdered('comment_id', $commentId, 'created_at');

        return !empty($result) ? $result : null;
    }

    /**
     * @return User|null
     */
    public function getUser(): ?User
    {
        $result = User::getById($this->getUserId());

        return !empty($result) ? $result : null;
    }

    /**
     * @param int $commentId
     * @param int $userId
     * @param string $text
     * @return static
     * @throws InvalidArgumentException
     */
    public static function add(int $commentId, int $userId, string $text): self
    {
        if (empty($text)) {
            throw new InvalidArgumentException();
        }

        if (!preg_match('~^[АаБбВвГгҐґДдЕеЄєЖжЗзИиІіЇїЙйКкЛлМмНнОоПпРрСсТтУуФфХхЦцЧчШшЩщЬьЮюЯя\'\-!?—()/,.:;«»"|\n\r\\s+a-zA-Z0-9]+$~',
            trim($text))) {
            throw new InvalidArgumentException(
                'Текст коментаря містить заборонені символи');
        }

        $answer = new CommentAnswer();
        $answer->setCommentId($commentId);
        $answer->setUserId($userId);
        $answer->setText($text);
        $answer->save();

        return $answer;
    }
}