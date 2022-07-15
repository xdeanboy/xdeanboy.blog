<?php include __DIR__ . '/../../../header.php' ?>
    <div class="container">
        <div class="content post">
            <? if (!empty($user)): ?>
                <? if ($user->isAdmin()): ?>
                    <div class="post-header-btn">
                        <div>
                            <a href="#">...</a>
                            <ul>
                                <li><a href="/post/<?= $post->getId() ?>/edit">Редагувати</a></li>
                                <li><a href="/post/<?= $post->getId() ?>/delete">Видалити</a></li>
                            </ul>
                        </div>
                    </div>
                <? endif; ?>
            <? endif; ?>
            <div class="post-information-dates">
                <div class="post-information-date"><?= $post->getCreatedAtDate() ?></div>
                <ul>
                    <li class="post-information-dates-ago"><?= $post->getDifferenceCreated()?></li>
                </ul>
            </div>
            <div>
                <a href="/post/find/by-section-<?= $post->getSection()->getName() ?>#last-posts"
                   class="post-section"><?= $post->getSection()->getName() ?></a>
            </div>
            <img src="<?= !empty($post->getImage()) ? $post->getImage()->getLink() : $post->getSection()->getImage() ?>" alt="Image for post">
            <div class="post-content">
                <h2 class="post-content-title"><?= $post->getTitle() ?></h2>
                <div class="post-content-text"><?= $post->getText() ?></div>
                <? include __DIR__ . '/addCommentAnswer.php' ?>
            </div>
        </div>
    </div>
<?php include __DIR__ . '/../../../footer.php' ?>