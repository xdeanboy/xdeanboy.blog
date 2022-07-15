<?php include __DIR__ . '/../header.php' ?>
<div class="container">
    <div class="content post-edit">
        <h2>Редагування посту</h2>
        <? if (!empty($error)): ?>
            <div class="error"><?= $error ?></div>
        <? endif; ?>
        <form action="/post/<?= $post->getId() ?>/edit" method="post" id="form-post-edit">
            <select name="section" id="form-post-edit-section">
                <option disabled>Розділ</option>
                <? if (!empty($sections)): ?>
                    <? foreach ($sections as $section): ?>
                        <? if ($section->getName() === $post->getSection()->getName()): ?>
                            <option selected value="<?= $section->getName() ?>"><?= $section->getName() ?></option>
                        <? else: ?>
                            <option value="<?= $section->getName() ?>"><?= $section->getName() ?></option>
                        <? endif; ?>
                    <? endforeach; ?>
                <? endif; ?>
            </select>
            <div class="block-input">
                <div class="inscription">Посилання на фото для посту</div>
                <input type="text" name="image" value="<?= $post->getImage()->getLink() ?? $_POST['image'] ?>"
                       placeholder="Посилання на фото"
                       class="post-edit-input">
            </div>
            <div class="block-input">
                <div class="inscription">Титулка для поста</div>
                <input type="text" name="title" value="<?= $post->getTitle() ?? $_POST['title'] ?>"
                       placeholder="Титулка посту"
                       class="post-edit-input">
            </div>
            <div class="block-input">
                <div class="inscription">Основний текст посту</div>
                <textarea name="text" placeholder="Основний текст посту ..."
                          class="textarea-text"><?= $post->getText() ?? $_POST['text'] ?></textarea>
                <input type="submit" value="Редагувати пост" class="submit">
            </div>
        </form>
    </div>
</div>
<?php include __DIR__ . '/../footer.php' ?>
