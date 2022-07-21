<?php include __DIR__ . '/../../header.php' ?>
    <div class="container">
        <div class="content confirmation">
            <h2>Ви точно хочете прибрати ваш лайк?</h2>

            <div class="confirmation-submit">
                <a href="/comment/<?= $comment->getId()?>/like/delete-confirmed"
                   class="submit-mini">Так</a>
                <a href="/<?= $post->getId() ?>" class="submit-mini">Ні</a>
            </div>
        </div>
    </div>
<?php include __DIR__ . '/../../footer.php' ?>