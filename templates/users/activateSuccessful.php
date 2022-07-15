<?php include __DIR__ . '/../header.php' ?>
<div class="container">
    <div class="content successful">
        <h2 class="successful-title">Аккаунт успішно активовано!</h2>
        <div class="text">
            <strong><?= $newUser->getNickname() ?></strong>
            , ви успішно активували свій аккаунт.
        </div>
        <div><a href="/sign-in">Увійти</a></div>
    </div>
</div>
<?php include __DIR__ . '/../footer.php' ?>
