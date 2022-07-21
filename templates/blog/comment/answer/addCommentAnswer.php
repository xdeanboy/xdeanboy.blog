<div class="post-view-comments">
    <div class="comment-header">
        <h3>Коментарі:</h3>
        <div>
            <? if (!$post->checkLikeByUser($user)): ?>

                <a href="/post/<?= $post->getId() ?>/like/add"><i
                            class="fa-solid fa-heart like-false"></i></a> <?= $countPostLikes ?>
            <? else: ?>
                <a href="/post/<?= $post->getId() ?>/like/delete"><i
                            class="fa-solid fa-heart like-true"></i></a> <?= $countPostLikes ?>
            <? endif; ?>
        </div>
    </div>
    <div class="block-comments" id="block-comments">
        <? if (!empty($error)): ?>
            <div class="not-found"><?= $error ?></div>
        <? endif; ?>

        <? if (!empty($comments)): ?>
            <? foreach ($comments as $comment): ?>

            <? include __DIR__ . '/../commentContent.php'?>

                <? if (!empty($commentAnswers[$comment->getId()])): ?>
                    <? foreach ($commentAnswers[$comment->getId()] as $commentAnswer): ?>
                        <? include __DIR__ . '/viewCommentAnswer.php' ?>
                    <? endforeach; ?>
                <? endif; ?>

                <? if (!empty($commentError)): ?>
                    <div class="error"><?= $commentError ?></div>
                <? endif; ?>

                <? if ($comment->getId() === $commentForAnswer->getId()): ?>
                    <form action="/post/<?= $post->getId() ?>/comment/<?= $comment->getId() ?>/answer/add"
                          id="form-post-comment-answer-add" method="post" class="block-answer">
                        <img class="comment-user-image" src=""
                             alt="User image">
                        <div>
                            <textarea name="text"
                                      placeholder="Напишіть свій коментарій"><?= $comment->getUser()->getNickname() ?>, </textarea>
                            <input type="submit" class="submit" value="Відповісти">
                        </div>
                    </form>
                <? endif; ?>

            <? endforeach; ?>
        <? endif; ?>

        <form action="/post/<?= $post->getId() ?>/comment/add" id="form-post-comment-add" method="post">
            <img class="comment-user-image" src=""
                 alt="User image">
            <div>
                <textarea name="text" placeholder="Напишіть свій коментарій"></textarea>
                <input type="submit" class="submit" value="Коментувати">
            </div>
        </form>
    </div>
</div>