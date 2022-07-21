<div class="block-answer">
    <a href="/user/<?= $commentAnswer->getUser()->getId() ?>"><img class="comment-user-image"
                                                                   src="<?= $commentAnswer->getUser()->getProfile() ?>"
                                                                   alt="User image"></a>
    <div class="comment">
        <div class="comment-user">
            <a href="#" class="comment-user-nickname"><?= $commentAnswer->getUser()->getNickname() ?></a>
        </div>
        <div class="comment-text" id="comment-text"><?= $commentAnswer->getText() ?></div>
        <div class="comment-footer">
            <div class="comment-date"><?= $commentAnswer->getCreatedAt() ?></div>
            <div class="comment-action">
                <ul>
                    <? if ($user->getId() === $commentAnswer->getUser()->getId() ||
                        $user->isAdmin()): ?>
                        <li>
                            <a href="/post/<?= $comment->getPostId() ?>/comment/<?= $comment->getId() ?>/answer/<?= $commentAnswer->getId() ?>/edit#form-post-comment-answer-edit"
                               class="btn-comment-edit button-mini">Редагувати</a></li>
                        <li>
                            <a href="/post/<?= $comment->getPostId() ?>/comment/<?= $comment->getId() ?>/answer/<?= $commentAnswer->getId() ?>/delete"
                               class="button-mini">Видалити</a></li>
                    <? endif; ?>
                    <li>
                        <a href="/post/<?= $post->getId() ?>/comment/<?= $comment->getId() ?>/answer/<?= $commentAnswer->getId() ?>/add#form-post-comment-answer-add"
                           class="button-mini">Відповісти</a></li>

                    <li>
                        <? if (!$commentAnswer->checkLikeByUser($user)): ?>
                            <a href="/comment/<?= $comment->getId() ?>/answer/<?= $commentAnswer->getId() ?>/like/add"><i
                                        class="fa-solid fa-heart like-mini like-false"></i></a>
                        <? else: ?>
                            <a href="/comment/<?= $comment->getId() ?>/answer/<?= $commentAnswer->getId() ?>/like/delete"><i
                                        class="fa-solid fa-heart like-mini like-true"></i></a>
                        <? endif; ?>
                        <?= $countAnswerLikes[$commentAnswer->getId()] ?>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>