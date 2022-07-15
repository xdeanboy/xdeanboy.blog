<?php

namespace xdeanboy\Controllers;

use xdeanboy\Exceptions\ForbiddenException;
use xdeanboy\Exceptions\InvalidArgumentException;
use xdeanboy\Exceptions\NotFoundException;
use xdeanboy\Exceptions\UnauthorizedException;
use xdeanboy\Exceptions\UserActivationException;
use xdeanboy\Models\Users\User;
use xdeanboy\Models\Users\UserActivation;
use xdeanboy\Models\Users\UserAuthorization;
use xdeanboy\Services\EmailSender;

class UsersController extends AbstractController
{
    /**
     * @return void
     * @throws ForbiddenException
     */
    public function signIn(): void
    {
        if (!empty($this->user)) {
            throw new ForbiddenException('Ви вже авторизовані');
        }

        if (!empty($_POST)) {
            try {
                $user = User::signIn($_POST);
                UserAuthorization::createTokenByUser($user);

                header('Location: /blog', true, 302);
                return;
            } catch (InvalidArgumentException $e) {
                $this->view->renderHtml('users/signIn.php',
                    ['title' => 'Помилка авторизації',
                        'error' => $e->getMessage()]);
                return;
            }
        }

        $this->view->renderHtml('users/signIn.php',
            ['title' => 'Авторизація']);
    }

    /**
     * @return void
     * @throws ForbiddenException
     */
    public function signUp(): void
    {
        if (!empty($this->user)) {
            throw new ForbiddenException('Ви вже авторизовані');
        }

        if (!empty($_POST)) {
            try {
                $user = User::register($_POST);

                if ($user instanceof User) {
                    $activationCode = UserActivation::createActivationCode($user);

                    $projectLink = include __DIR__ . '/../Settings/Project.php';
                    EmailSender::send(
                        $user->getEmail(),
                        'Підтвердження авторизації',
                        'registerConfirmation.php',
                        ['projectLink' => $projectLink['link'],
                            'userId' => $user->getId(),
                            'code' => $activationCode]);
                }

                $this->view->renderHtml('users/registerSuccessful.php',
                    ['title' => 'Успішна реєстрація',
                        'newUser' => $user]);
                return;
            } catch (InvalidArgumentException $e) {
                $this->view->renderHtml('users/signUp.php',
                    ['title' => 'Помилка реєстрації',
                        'error' => $e->getMessage()]);
                return;
            }
        }

        $this->view->renderHtml('users/signUp.php',
            ['title' => 'Реєстрація']);
    }

    /**
     * @param int $userId
     * @param string $code
     * @return void
     * @throws ForbiddenException
     * @throws NotFoundException
     */
    public function activation(int $userId, string $code): void
    {
        if (!empty($this->user)) {
            throw new ForbiddenException('Ви вже авторизовані');
        }

        $user = User::getById($userId);

        if ($user === null) {
            throw new NotFoundException('Користувача не знайдено');
        }

        try {
            $checkActivationCode = UserActivation::checkActivationCode($user, $code);

            if (!$checkActivationCode) {
                throw new UserActivationException('Не правильний код активації');
            }

            $user->activate();

            UserActivation::deleteActivationCode($user, $code);

            $this->view->renderHtml('/users/activateSuccessful.php',
            ['title' => 'Успішна активація',
                'newUser' => $user]);
            return;
        } catch (UserActivationException $e) {
            $this->view->renderHtml('errors/errorUserActivation.php',
                ['title' => 'Помилка активації',
                    'error' => $e->getMessage()]);
            return;
        }
    }

    /**
     * @return void
     * @throws ForbiddenException
     * @throws UnauthorizedException
     */
    public function logOut(): void
    {
        if (empty($this->user)) {
            throw new UnauthorizedException('Ви не авторизовані');
        }

        User::userLogOut();

        header('Location: /sign-in', true, 302);
        return;
    }

    public function profileView(int $userId): void
    {
        echo 'Профіль користувача з айді ' . $userId;
    }
}