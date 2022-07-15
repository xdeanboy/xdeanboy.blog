<?php include __DIR__ . '/../header.php' ?>
<div class="container">
    <div class="content sign-in">
        <h2>Авторизація</h2>
        <? if (!empty($error)): ?>
            <div class="error"><?= $error ?></div>
        <? endif; ?>
        <form action="/sign-in" method="post" id="form-sign-in">
            <div>Email:</div>
            <input type="text" name="email" value="<?= $_POST['email'] ?? '' ?>" placeholder="example@gmail.com">
            <div>Пароль:</div>
            <input type="password" name="password">
            <input type="submit" value="Увійти" class="submit">
            <a href="/sign-up" class="submit">Зареєструватися</a>
        </form>
    </div>
</div>
<?php include __DIR__ . '/../footer.php' ?>
