<?php

namespace xdeanboy\Models\ContactsProject;

use xdeanboy\Models\ActiveRecordEntity;

class ContactsProject extends ActiveRecordEntity
{
    protected $name;
    protected $email;
    protected $instagram;
    protected $telegram;
    protected $linkedin;
    protected $comment;
    protected $createdAt;

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $instagram
     */
    public function setInstagram(string $instagram): void
    {
        $this->instagram = $instagram;
    }

    /**
     * @return string
     */
    public function getInstagram(): string
    {
        return $this->instagram;
    }


    /**
     * @param string $telegram
     */
    public function setTelegram(string $telegram): void
    {
        $this->telegram = $telegram;
    }

    /**
     * @return string
     */
    public function getTelegram(): string
    {
        return $this->telegram;
    }

    /**
     * @param string $linkedin
     */
    public function setLinkedin(string $linkedin): void
    {
        $this->linkedin = $linkedin;
    }

    /**
     * @return string
     */
    public function getLinkedin(): string
    {
        return $this->linkedin;
    }

    /**
     * @param string $comment
     */
    public function setComment(string $comment): void
    {
        $this->comment = $comment;
    }

    /**
     * @return string
     */
    public function getComment(): string
    {
        return $this->comment;
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
        return 'contacts_project';
    }

    /**
     * @return static|null
     */
    public static function getProjectAuthor(): ?self
    {
        $author = self::findOneByColumn('comment', 'author');

        if ($author === null) {
            return null;
        }

        return $author;
    }

    /**
     * @return static|null
     */
    public static function getProjectContacts(): ?self
    {
        $project = self::findOneByColumn('comment', 'project');

        if ($project === null) {
            return null;
        }

        return $project;
    }
}