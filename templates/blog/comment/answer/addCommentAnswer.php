<div class="post-view-comments">
    <div class="comment-header">
        <h3>Коментарі:</h3>
        <div><a href="#"><i class="fa-solid fa-heart like"></i></a> 10</div>
    </div>
    <div class="block-comments" id="block-comments">
        <? if (!empty($error)): ?>
            <div class="not-found"><?= $error ?></div>
        <? endif; ?>

        <? if (!empty($comments)): ?>
            <? foreach ($comments as $comment): ?>
                <div class="block-comment">
                    <a href="/user/<?= $comment->getUser()->getId() ?>"><img class="comment-user-image"
                                                                             src="<?= $comment->getUser()->getProfile() ?>"
                                                                             alt="User image"></a>
                    <div class="comment">
                        <div class="comment-user">
                            <a href="#" class="comment-user-nickname"><?= $comment->getUser()->getNickname() ?></a>
                        </div>
                        <div class="comment-text" id="comment-text"><?= $comment->getText() ?></div>
                        <div class="comment-footer">
                            <div class="comment-date"><?= $comment->getCreatedAt() ?></div>
                            <div class="comment-action">
                                <ul>
                                    <? if ($user->getId() === $comment->getUser()->getId() ||
                                        $user->isAdmin()): ?>
                                        <li>
                                            <a href="/post/<?= $comment->getPostId() ?>/comment/<?= $comment->getId() ?>/edit#form-post-comment-edit"
                                               class="btn-comment-edit button-mini">Редагувати</a></li>
                                        <li>
                                            <a href="/post/<?= $comment->getPostId() ?>/comment/<?= $comment->getId() ?>/delete"
                                               class="button-mini">Видалити</a></li>
                                    <? endif; ?>
                                    <li><a href="#" class="button-mini">Відповісти</a></li>
                                    <li><a href="#"><i class="fa-solid fa-heart like like-mini"></i></a> 10</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

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