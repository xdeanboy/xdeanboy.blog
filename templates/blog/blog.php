<?php include __DIR__ . '/../header.php' ?>
<div class="main-blog-sections">

    <? if (!empty($sections)): ?>
        <? foreach ($sections as $section): ?>
            <div class="main-blog-section">
                <a href="/post/find/by-section-<?= $section->getName() ?>">
                    <img src="<?= $section->getImage() ?>"
                         alt="Img <?= $section->getName() ?>">
                    <h3><?= $section->getName() ?></h3>
                </a>
            </div>
        <? endforeach; ?>
    <? endif; ?>

</div>

<div class="container">

    <div class="last-posts" id="last-posts">

        <? if (!empty($error)): ?>
            <div class="not-found"><?= $error ?></div>
        <? endif; ?>

        <? if (!empty($posts)): ?>
            <? foreach ($posts as $post): ?>
                <div class="last-post">
                    <a href="/post/<?= $post->getId() ?>">
                        <img src="<?= !empty($post->getImage()) ? $post->getImage()->getLink() : $post->getSection()->getImage() ?>"
                             alt="Post image"
                             class="last-post-img">
                    </a>
                    <div class="last-post-information">
                        <div class="post-information-dates">
                            <div class="post-information-date"><?= $post->getCreatedAtDate() ?></div>
                            <ul>
                                <li class="post-information-dates-ago"><?= $post->getDifferenceCreated()?></li>
                            </ul>
                        </div>
                        <div class="last-post-information-title"><a
                                    href="/post/<?= $post->getId() ?>"><?= $post->getTitle() ?></a></div>

                        <div class="last-post-information-text"><?= $post->getBeginningText() ?> ...</div>
                    </div>
                    <div class="last-post-actions">
                        <div class="post-action-comment">
                            <a href="/post/<?= $post->getId() ?>#view-post-comments">
                                <img src="https://cdn-icons-png.flaticon.com/512/1450/1450338.png" alt="Post image"
                                     class="post-icon">
                            </a>
                            <div class="post-icon-count"><?= $countCommentsByPost[$post->getId()]?></div>
                        </div>
                        <div class="post-action-like">
                            <a href="#"><i class="fa-solid fa-heart like"></i></a>
                            <div class="post-icon-count">10</div>
                        </div>
                    </div>
                </div>
            <? endforeach; ?>
        <? endif; ?>

    </div>

</div>
<?php include __DIR__ . '/../footer.php' ?>
