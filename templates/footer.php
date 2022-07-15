<footer id="footer">
    <div class="footer">
        <div class="blog-contacts">
            <div class="blog-contacts-socials">
                <a href="<?= !empty($projectAuthor) ? $projectAuthor->getInstagram() : null ?>" target="_blank">
                    <img src="https://cdn-icons-png.flaticon.com/512/174/174855.png" alt="Instagram logo">
                </a>
                <a href="<?= !empty($projectAuthor) ? $projectAuthor->getTelegram() : null ?>" target="_blank">
                    <img src="https://cdn-icons-png.flaticon.com/512/5968/5968804.png" alt="Telegram logo">
                </a>
                <a href="<?= !empty($projectAuthor) ? $projectAuthor->getLinkedin() : null ?>" target="_blank">
                    <img src="https://cdn-icons-png.flaticon.com/512/145/145807.png" alt="LinkedIn">
                </a>
            </div>
            <div class="blog-contacts-name">
                <?= !empty($projectAuthor) ? $projectAuthor->getName() : 'Невідомий автор' ?>
            </div>
            <? if (!empty($projectAuthor)): ?>
                <div class="blog-contacts-email">
                    <?= $projectAuthor->getEmail() ?>
                </div>
            <? endif; ?>
        </div>
        <div class="send-blog">
            <div class="send-blog-title">Напиши мені</div>
            <? if (!empty($errorFooter)): ?>
                <div class="error"><?= $errorFooter ?></div>
            <? endif; ?>
            <form action="/send-me" method="post" id="send-blog-message">
                <div class="blog-message-user-information">
                    <input type="text" name="messageName" value="<?= $_POST['messageName'] ?? '' ?>"
                           placeholder="Введіть ваше імя">
                    <input type="text" name="messageEmail" value="<?= $_POST['messageEmail'] ?? '' ?>"
                           placeholder="Введіть ваш email">
                </div>
                <textarea name="messageText" id="send-blog-text"
                          placeholder="Ваше повідомлення"><?= $_POST['messageText'] ?? '' ?></textarea>
                <input type="submit" value="Відправити" class="submit">
            </form>
        </div>
    </div>
    <div class="footer-by">© 2022 by Denis Boyko</div>
</footer>

</body>
</html>