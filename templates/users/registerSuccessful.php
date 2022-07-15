<?php include __DIR__ . '/../header.php' ?>
<div class="container">
    <div class="content successful">
        <h2 class="successful-title">Реєстрація пройшла успішно!</h2>
        <div>
            <strong><?= $newUser->getNickname() ?></strong>, ви успішно зареєструвалися. На ваш email
            <strong><?= $newUser->getEmail() ?></strong> відправлено повідомлення з подальшими діями активації аккаунту.
        </div>
    </div>
</div>
<?php include __DIR__ . '/../footer.php' ?>
