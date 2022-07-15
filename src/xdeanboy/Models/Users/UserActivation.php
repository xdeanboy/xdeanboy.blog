<?php

namespace xdeanboy\Models\Users;

use xdeanboy\Services\Db\Db;

class UserActivation
{
    private const TABLE_NAME = 'activation_code';

    public static function createActivationCode(User $user): string
    {
        $code = bin2hex(random_bytes(10));

        $db = Db::getInstance();
        $db->query('INSERT INTO `' . self::TABLE_NAME . '` (`user_id`, `code`) VALUES (:user_id, :code)',
            [':user_id' => $user->getId(),
                ':code' => $code],
        self::class);

        return $code;
    }

    public static function checkActivationCode(User $user, string $code): bool
    {
        $db = Db::getInstance();
        $checkActivationCode = $db->query('SELECT * FROM `' . self::TABLE_NAME . '` WHERE user_id = :user_id AND code = :code',
        [':user_id' => $user->getId(),
            'code' => $code],
        self::class);

        return !empty($checkActivationCode);
    }

    public static function deleteActivationCode(User $user, string $code): void
    {
        $db = Db::getInstance();
        $db->query('DELETE FROM `' . self::TABLE_NAME . '` WHERE user_id = :user_id AND code = :code',
        [':user_id' => $user->getId(),
            'code' => $code],
        self::class);
    }
}