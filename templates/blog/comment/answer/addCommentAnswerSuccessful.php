<?php include __DIR__ . '/../../../header.php'?>
    <div class="container">
        <div class="content successful">
            <h2>Відповіли успішно!</h2>
            <div>Ви успішно відповіли користувачу <a href="/user/<?= $commentForAnswer->getUser()->getId()?>"><?= $commentForAnswer->getUser()->getNickname()?></a> на його коментар</div>
            <div><q><?= $commentForAnswer->getBeginningText()?></q></div>
            <div><a href="/post/<?= $post->getId()?>">Повернутися до посту</a></div>
        </div>
    </div>
<?php include __DIR__ . '/../../../footer.php'?>