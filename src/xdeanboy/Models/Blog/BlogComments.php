<?php

namespace xdeanboy\Models\Blog;

use xdeanboy\Exceptions\InvalidArgumentException;
use xdeanboy\Models\ActiveRecordEntity;
use xdeanboy\Models\Users\User;

class BlogComments extends ActiveRecordEntity
{
    protected $postId;
    protected $userId;
    protected $text;
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
    public function getBeginningText(): string
    {
        return mb_substr($this->getText(), 0, 100) . ' ...';
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
        return 'blog_comments';
    }

    /**
     * @param int $postId
     * @return array|null
     */
    public static function findAllByPost(int $postId): ?array
    {
        $comments = self::findAllByColumnOrdered('post_id', $postId, 'created_at');

        return !empty($comments) ? $comments : null;
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
     * @param int $postId
     * @param int $userId
     * @param string $text
     * @return void
     * @throws InvalidArgumentException
     */
    public static function addComment(int $postId, int $userId, string $text): self
    {
        if (empty($text)) {
            throw new InvalidArgumentException('Коментар не може бути пустим');
        }

        if (!preg_match('~^[АаБбВвГгҐґДдЕеЄєЖжЗзИиІіЇїЙйКкЛлМмНнОоПпРрСсТтУуФфХхЦцЧчШшЩщЬьЮюЯя\'\-!?—()/,.:;«»"|\n\r\\s+a-zA-Z0-9]+$~',
            trim($text))) {
            throw new InvalidArgumentException(
                'Текст коментаря містить заборонені символи');
        }

        $comment = new BlogComments();
        $comment->setPostId($postId);
        $comment->setUserId($userId);
        $comment->setText(trim($text));

        $comment->save();

        return $comment;
    }

    /**
     * @param string $text
     * @return $this
     * @throws InvalidArgumentException
     */
    public function editComment(string $text): self
    {
        if (empty($text)) {
            throw new InvalidArgumentException('Коментар не може бути пустим');
        }

        if (!preg_match('~^[АаБбВвГгҐґДдЕеЄєЖжЗзИиІіЇїЙйКкЛлМмНнОоПпРрСсТтУуФфХхЦцЧчШшЩщЬьЮюЯя\'\-!?—()/,.:;«»"|\n\r\\s+a-zA-Z0-9]+$~',
            trim($text))) {
            throw new InvalidArgumentException(
                'Текст коментаря містить заборонені символи');
        }

        $this->setText(trim($text));
        $this->save();

        return $this;
    }
}