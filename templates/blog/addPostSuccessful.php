<?php include __DIR__ . '/../header.php'?>
<div class="container">
    <div class="content successful">
        <h2>Пост успішно створений!</h2>
        <div>Перейти до створенного посту можна за посиланням нижче</div>
        <div><a href="/post/<?= $post->getId()?>"><?= $post->getTitle()?></a></div>
    </div>
</div>
<?php include __DIR__ . '/../footer.php'?>
