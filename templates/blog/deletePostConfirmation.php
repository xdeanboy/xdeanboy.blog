<?php include __DIR__ . '/../header.php'?>
<div class="container">
    <div class="content confirmation">
        <h2>Ви точно хочете видалити пост?</h2>
        <div class="confirmation-title">
            <a href="/post/<?= $post->getId()?>" target="_blank">"<?= $post->getTitle()?>"</a>
        </div>
        <div class="confirmation-submit">
            <a href="/post/<?= $post->getId()?>/delete/confirmation" class="submit-mini">Так</a>
            <a href="/post/<?= $post->getId()?>" class="submit-mini">Ні</a>
        </div>
    </div>
</div>
<?php include __DIR__ . '/../footer.php'?>
