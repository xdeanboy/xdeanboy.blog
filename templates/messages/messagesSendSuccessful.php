<?php include __DIR__ . '/../header.php' ?>
<div class="container">
    <div class="content successful">
        <h2>Повідомленння відправлено успішно!</h2>
        <div>
            Дякуємо, <strong><?= $message->getName() ?></strong>, за ваше повідомлення, адміністратори сайту
            обов'язково прочитають і зв'яжуться з вами.
        </div>
    </div>
</div>
<?php include __DIR__ . '/../footer.php' ?>
