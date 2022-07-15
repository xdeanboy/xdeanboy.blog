<?php

namespace xdeanboy\Models\Users;

class UserAuthorization
{
    /**
     * @param User $user
     * @return void
     */
    public static function createTokenByUser(User $user): void
    {
        $token = $user->getId() . ':' . $user->getAuthToken();
        setcookie('token', $token, 0, '/', '', false, true);
    }

    /**
     * @return User|null
     */
    public static function getUserByToken(): ?User
    {
        $token = $_COOKIE['token'] ?? '';

        if (empty($token)) {
            return null;
        }

        [$userId, $userAuthToken] = explode(':', $token, 2);

        $user = User::getById($userId);

        if ($user === null) {
            return null;
        }

        if ($user->getAuthToken() !== $userAuthToken) {
            return null;
        }

        return $user;
    }
}