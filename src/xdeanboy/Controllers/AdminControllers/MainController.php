<?php

namespace xDeanBoy\Controllers\AdminControllers;

use xdeanboy\Controllers\AbstractController;
use xdeanboy\Exceptions\ForbiddenException;
use xdeanboy\Exceptions\UnauthorizedException;

class MainController extends AbstractController
{
    public function main(): void
    {
        if (empty($this->user)) {
            throw new UnauthorizedException();
        }

        if (!$this->user->isAdmin()) {
            throw new ForbiddenException();
        }

        echo 'Головна адмінки';
    }
}