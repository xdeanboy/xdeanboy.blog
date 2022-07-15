<?php include __DIR__ . '/../header.php'?>
<div class="container">
    <div class="content sign-up">
        <h2>Реєстрація</h2>
        <? if (!empty($error)): ?>
            <div class="error"><?= $error ?></div>
        <? endif; ?>
        <form action="/sign-up" method="post" id="form-sign-up">
            <div>Email:</div>
            <input type="text" name="email" value="<?= $_POST['email'] ?? '' ?>" placeholder="example@gmail.com">
            <div>Nickname:</div>
            <input type="text" name="nickname" value="<?= $_POST['nickname'] ?? ''?>" placeholder="Nickname">
            <div>Пароль:</div>
            <input type="password" name="passwordOne">
            <div>Повторіть пароль:</div>
            <input type="password" name="passwordTwo">
            <input type="submit" value="Зареєструватися" class="submit">
            <a href="/sign-in" class="submit">Увійти</a>
        </form>
    </div>
</div>
<?php include __DIR__ . '/../footer.php'?>
