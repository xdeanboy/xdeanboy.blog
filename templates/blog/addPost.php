<?php include __DIR__ . '/../header.php' ?>
<div class="container">
    <div class="content post-add">
        <h2>Створення посту</h2>
        <? if (!empty($error)):?>
        <div class="error"><?= $error?></div>
        <? endif;?>
        <form action="/post/add" method="post" id="form-post-add">
            <select name="section" id="form-post-add-section">
                <option disabled selected>Вибрати розділ</option>
                <? if (!empty($sections)): ?>
                    <? foreach ($sections as $section): ?>
                        <option value="<?= $section->getName() ?>"><?= $section->getName() ?></option>
                    <? endforeach; ?>
                <? endif; ?>
            </select>
            <input type="text" name="image" value="<?= $_POST['image'] ?? '' ?>" placeholder="Посилання на фото"
                   class="post-add-input">
            <input type="text" name="title" value="<?= $_POST['title'] ?? '' ?>" placeholder="Титулка посту"
                   class="post-add-input">
            <textarea name="text" placeholder="Основний текст посту ..."
                      class="textarea-text"><?= $_POST['text'] ?? '' ?></textarea>
            <input type="submit" value="Створити пост" class="submit">
        </form>
    </div>
</div>
<?php include __DIR__ . '/../footer.php' ?>
