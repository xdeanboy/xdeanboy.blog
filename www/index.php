<?php

try {
    spl_autoload_register(function (string $className) {
        require_once __DIR__ . '/../src/' . $className . '.php';
    });

    //connect routes
    $routes = require_once __DIR__ . '/../src/routes.php';
    $route = $_GET['route'] ?? '';


    $isRouteFound = false;
    foreach ($routes as $pattern => $controllerAndAction) {
        preg_match($pattern, $route, $matches);
        if (!empty($matches)) {
            $isRouteFound = true;
            break;
        }
    }

    unset($matches[0]);

    if (!$isRouteFound) {
        throw new \xdeanboy\Exceptions\NotFoundException('Сторінку не знайдено');
    }

    $controllerName = $controllerAndAction[0];
    $controllerAction = $controllerAndAction[1];

    $controller = new $controllerName();
    $controller->$controllerAction(...$matches);

} catch (\xdeanboy\Exceptions\DbException $e) {
    $view = new \xDeanBoy\View\View(__DIR__ . '/../templates/errors');
    $view->renderHtml('500.php',
        ['error' => $e->getMessage(),
            'title' => 'Помилка БД'],
        500);
    return;
} catch (\xdeanboy\Exceptions\NotFoundException $e) {
    $view = new \xDeanBoy\View\View(__DIR__ . '/../templates/errors');
    $view->renderHtml('404.php',
        ['error' => $e->getMessage(),
            'title' => 'Не знайдено',
            'user' => \xDeanBoy\Models\Users\UserAuthorization::getUserByToken()],
        404);
    return;
} catch (\xdeanboy\Exceptions\ForbiddenException $e) {
    $view = new \xDeanBoy\View\View(__DIR__ . '/../templates/errors');
    $view->renderHtml('403.php',
        ['error' => $e->getMessage(),
            'title' => 'Доступ заборонено',
            'user' => \xDeanBoy\Models\Users\UserAuthorization::getUserByToken()],
        403);
    return;
} catch (\xdeanboy\Exceptions\UnauthorizedException $e) {
    $view = new \xDeanBoy\View\View( __DIR__ . '/../templates/errors');
    $view->renderHtml('401.php',
        ['title' => 'Авторизуйтеся',
            'error' => $e->getMessage()], 401);
    return;
}