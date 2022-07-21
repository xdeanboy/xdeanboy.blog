<?php include __DIR__ . '/../../../header.php' ?>
    <div class="container">
        <div class="content confirmation">
            <h2>Ви точно хочете видалити коментар?</h2>

            <div class="confirmation-submit">
                <a href="/post/<?= $post->getId() ?>/comment/<?= $comment->getId() ?>/answer/<?= $commentAnswer->getId()?>/delete-confirmed"
                   class="submit-mini">Так</a>
                <a href="/post/<?= $post->getId() ?>" class="submit-mini">Ні</a>
            </div>
        </div>
    </div>
<?php include __DIR__ . '/../../../footer.php' ?>