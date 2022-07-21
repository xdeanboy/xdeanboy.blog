<?php include __DIR__ . '/../../header.php'?>
<div class="container">
    <div class="content successful">
        <h2>Дякую за лайк!</h2>
        <div>Ви успішно лайкнули <?= $liteTo?>!</div>
        <div><a href="/post/<?= $post->getId()?>">Повернутися по посту</a></div>
    </div>
</div>
<?php include __DIR__ . '/../../footer.php'?>
