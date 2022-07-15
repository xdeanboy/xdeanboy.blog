<?php include __DIR__ . '/../../header.php'?>
<div class="container">
    <div class="content successful">
        <h2>Видалено успішно!</h2>
        <div>Коментар до посту успішно видалено.</div>
        <div><a href="/post/<?= $post->getId()?>"><?= $post->getTitle()?></a></div>
    </div>
</div>
<?php include __DIR__ . '/../../footer.php'?>
