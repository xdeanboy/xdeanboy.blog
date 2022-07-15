<?php include __DIR__ . '/../header.php' ?>
    <div class="content div-error">
        <h2>Помилка доступу</h2>
        <div class="text"><?= !empty($error) ? $error : 'Доступ заборонено'?></div>
    </div>
<?php include __DIR__ . '/../footer.php' ?>
