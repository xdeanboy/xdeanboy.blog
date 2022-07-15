<?php include __DIR__ . '/../header.php' ?>
    <div class="main">

        <div class="container main-img">
            <img src="https://images.unsplash.com/photo-1491947153227-33d59da6c448?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1780&q=80"
                 alt="Main image">
        </div>

        <div class="main-blog-sections" id="main-blog-sections">

            <? if (!empty($sections)): ?>
                <? foreach ($sections as $section): ?>
                    <div class="main-blog-section">
                        <a href="/post/find/by-section-<?= $section->getName()?>">
                            <img src="<?= $section->getImage() ?>"
                                 alt="Img <?= $section->getName()?>">
                            <h3><?= $section->getName()?></h3>
                        </a>
                    </div>
                <? endforeach; ?>
            <? endif; ?>

        </div>

    </div>
<?php include __DIR__ . '/../footer.php' ?>