<?php include __DIR__ . '/../header.php' ?>
<div class="content div-error">
    <h2>Помилка активації</h2>
    <div class="text"><?= !empty($error) ? $error : 'Користувача не активовано'?></div>
</div>
<?php include __DIR__ . '/../footer.php' ?>
