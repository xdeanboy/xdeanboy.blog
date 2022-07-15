<?php

namespace xdeanboy\Models\Users\UserProfile;

use xdeanboy\Models\ActiveRecordEntity;

class UserProfile extends ActiveRecordEntity
{
    protected static function getTableName(): string
    {
        return 'user_profiles';
    }
}