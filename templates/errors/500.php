<?php include __DIR__ . '/../header.php' ?>
<div class="divError">
    <h2>Помилка баз данних</h2>
    <div class="text"><?= $error ?? 'Помилка БД'?></div>
</div>
<?php include __DIR__ . '/../footer.php' ?>
