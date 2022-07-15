<?php

namespace xDeanBoy\Models\Messages\FromUnauthorized;

use xdeanboy\Exceptions\EmailSenderException;
use xdeanboy\Exceptions\InvalidArgumentException;
use xdeanboy\Models\ActiveRecordEntity;
use xdeanboy\Services\EmailSender;

class MessagesFromUnauthorized extends ActiveRecordEntity
{
    protected $name;
    protected $email;
    protected $text;
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

    protected static function getTableName(): string
    {
        return 'messages_from_unauthorized';
    }

    public static function newMessage(array $dataMessage): self
    {
        if (empty($dataMessage['messageName'])) {
            throw new InvalidArgumentException('Вкажіть ваше ім\'я');
        }

        if (empty($dataMessage['messageEmail'])) {
            throw new InvalidArgumentException('Вкажіть ваш Email');
        }

        if (!filter_var($dataMessage['messageEmail'], FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Некоректний email');
        }

        if (empty($dataMessage['messageText'])) {
            throw new InvalidArgumentException('Текст повідомлення не може бути пустим');
        }

        $message = new MessagesFromUnauthorized();
        $message->setName($dataMessage['messageName']);
        $message->setEmail($dataMessage['messageEmail']);
        $message->setText($dataMessage['messageText']);
        $message->save();

        return $message;
    }

}