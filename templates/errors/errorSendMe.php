<?php include __DIR__ . '/../header.php'?>
<div class="container">
    <div class="content div-error">
        <?= !empty($errorFotter) ? $errorFotter : '<h2>Упс, повідомлення не відправлено</h2>'?>
    </div>
</div>
<?php include __DIR__ . '/../footer.php'?>
