<?php

namespace xdeanboy\Models\Users;

use xdeanboy\Models\ActiveRecordEntity;

class UserRoles extends ActiveRecordEntity
{
    protected $name;

    /**
     * @param string $name
     */
    public function setName($name): void
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
     * @param string $name
     * @return static|null
     */
    public static function getRoleByName(string $name): ?self
    {
        $checkRole = self::findOneByColumn('name', $name);

        return !empty($checkRole) ? $checkRole : null;
    }

    protected static function getTableName(): string
    {
        return 'user_roles';
    }
}