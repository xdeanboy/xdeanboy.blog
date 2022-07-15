<?php include __DIR__ . '/../header.php' ?>
    <div class="content div-error">
        <h2>Помилка Авторизації</h2>
        <div class="text"><?= !empty($error) ? $error : 'Ви не авторизовані'?></div>
        <div><a href="/sign-in" class="submit">Авторизуйтеся</a></div>
    </div>
<?php include __DIR__ . '/../footer.php' ?>