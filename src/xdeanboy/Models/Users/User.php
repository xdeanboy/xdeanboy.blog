<?php

namespace xdeanboy\Models\Users;

use xdeanboy\Exceptions\ForbiddenException;
use xdeanboy\Exceptions\InvalidArgumentException;
use xdeanboy\Models\ActiveRecordEntity;
use xdeanboy\Models\Users\UserProfile\UserProfile;

class User extends ActiveRecordEntity
{
    protected $nickname;
    protected $email;
    protected $roleId;
    protected $isConfirmed;
    protected $passwordHash;
    protected $authToken;
    protected $createdAt;

    /**
     * @param string $nickname
     */
    public function setNickname(string $nickname): void
    {
        $this->nickname = $nickname;
    }

    /**
     * @return string
     */
    public function getNickname(): string
    {
        return $this->nickname;
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
     * @param int $roleId
     */
    public function setRoleId(int $roleId): void
    {
        $this->roleId = $roleId;
    }

    /**
     * @return void
     */
    public function setRoleUser(): void
    {
        $roleUser = UserRoles::getRoleByName('user');

        if (!empty($roleUser)) {
            $this->roleId = $roleUser->getId();
        }
    }

    /**
     * @return int
     */
    public function getRoleId(): int
    {
        return $this->roleId;
    }

    /**
     * @return UserRoles|null
     */
    public function getRole(): ?UserRoles
    {
        return UserRoles::getById($this->getRoleId());
    }

    /**
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->getRole()->getName() === 'Адмін';
    }

    /**
     * @return bool
     */
    public function isUser(): bool
    {
        return $this->getRole()->getName() === 'Користувач';
    }

    /**
     * @return bool
     */
    public function isModerator(): bool
    {
        return $this->getRole()->getName() === 'Модератор';
    }

    /**
     * @param bool $isConfirmed
     */
    public function setIsConfirmed(bool $isConfirmed): void
    {
        $this->isConfirmed = $isConfirmed;
    }

    /**
     * @return bool
     */
    public function getIsConfirmed(): bool
    {
        return $this->isConfirmed;
    }

    /**
     * @param string $passwordHash
     */
    public function setPasswordHash(string $passwordHash): void
    {
        $this->passwordHash = $passwordHash;
    }

    /**
     * @return string
     */
    public function getPasswordHash(): string
    {
        return $this->passwordHash;
    }

    /**
     * @param string $authToken
     */
    public function setAuthToken(string $authToken): void
    {
        $this->authToken = $authToken;
    }

    /**
     * @return string
     */
    public function getAuthToken(): string
    {
        return $this->authToken;
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
        return 'users';
    }

    public function getProfile()
    {
        echo 'Profile user - ' . $this->getId();
    }

    public static function signIn(array $dataUser): self
    {
        if (empty($dataUser['email'])) {
            throw new InvalidArgumentException('Введіть ваш email');
        }

        if (empty($dataUser['password'])) {
            throw new InvalidArgumentException('Введіть ваш пароль');
        }

        $user = User::findOneByColumn('email', $dataUser['email']);

        if ($user === null) {
            throw new InvalidArgumentException('Користувача з таким email не існує');
        }

        if (!password_verify($dataUser['password'], $user->getPasswordHash())) {
            throw new InvalidArgumentException('Не правильний email або пароль');
        }

        return $user;
    }

    public static function userLogOut(): void
    {
        if (empty($_COOKIE['token'])) {
            throw new ForbiddenException('Неможливо вийти з аккаунту');
        }

        setcookie('token', '', -1, '/', '', false, true);
    }

    public static function register(array $dataUser): ?self
    {
        if (empty($dataUser['email'])) {
            throw new InvalidArgumentException('Заповність поле Email');
        }

        if (!filter_var($dataUser['email'], FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Некоректний Email');
        }

        if (self::findOneByColumn('email', $dataUser['email']) !== null) {
            throw new InvalidArgumentException('Користувач з таким Email вже існує');
        }

        if (empty($dataUser['nickname'])) {
            throw new InvalidArgumentException('Заповність поле Nickname');
        }

        if (!preg_match('~^[ҐґЄєІіЇїа-яА-Яa-zA-Z0-9]+$~', $dataUser['nickname'])) {
            throw new InvalidArgumentException('Некоретний Nickname');
        }

        if (self::findOneByColumn('nickname', $dataUser['nickname']) !== null) {
            throw new InvalidArgumentException('Користувач з таким Nickname вже існує');
        }

        if (empty($dataUser['passwordOne'])) {
            throw new InvalidArgumentException('Заповність поле Пароль');
        }

        if (empty($dataUser['passwordTwo'])) {
            throw new InvalidArgumentException('Повторіть пароль');
        }

        if ($dataUser['passwordOne'] !== $dataUser['passwordTwo']) {
            throw new InvalidArgumentException('Повторний пароль введений невірно');
        }

        $user = new User();
        $user->setNickname($dataUser['nickname']);
        $user->setEmail($dataUser['email']);
        $user->setRoleUser();
        $user->setIsConfirmed(false);
        $user->setPasswordHash(password_hash($dataUser['passwordOne'], PASSWORD_DEFAULT));
        $user->setAuthToken(sha1(random_bytes(100)) . sha1(random_bytes(100)));

        $user->save();
        return $user;
    }

    public function activate(): void
    {
        $this->isConfirmed = true;
        $this->save();
    }
}
