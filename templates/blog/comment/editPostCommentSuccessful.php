<?php include __DIR__ . '/../../header.php' ?>
    <div class="container">
        <div class="content successful">
            <h2>Коментар успішно редаговано!</h2>
            <div>
                Коментар до посту <a href="/post/<?= $post->getId() ?>"><?= $post->getTitle() ?></a> успішно редаговано!
            </div>
        </div>
    </div>
<?php include __DIR__ . '/../../footer.php' ?>