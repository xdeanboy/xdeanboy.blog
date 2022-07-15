<!doctype html>
<html lang="ua">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'Блог xdeanboy' ?></title>

    <!--Include JQuery-->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/350930385b.js" crossorigin="anonymous"></script>

    <!--My styles-->
    <link rel="stylesheet" href="/styles.css">
</head>
<body>

<header class="header">
    <div class="container">
        <div class="logo">XDEANBOY</div>
        <nav class="main-menu">
            <ul>
                <li><a href="/">Головна</a></li>
                <li><a href="/blog">Блог</a></li>
                <li><a href="#">Про мене</a></li>
                <li><a href="#footer">Контакти</a></li>
            </ul>
        </nav>

        <? if (!empty($user)): ?>
            <div class="header-user">
                <div class="header-user-nickname">
                    <div>
                        <a href="/user/<?= $user->getId() ?>"><?= $user->getNickname() ?></a>
                        <ul class="header-user-btn">
                            <? if ($user->isAdmin()):?>
                                <li><a href="/admin-panel">Адмінка</a></li>
                            <? endif;?>
                            <li><a href="/user/<?= $user->getId() ?>">Профіль</a></li>
                            <li><a href="/user/logout">Вийти</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        <? else: ?>
            <div class="main-sign-in">
                <a href="/sign-in" class="submit">Увійти</a>
            </div>
        <? endif; ?>

    </div>
</header>