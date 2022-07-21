<div class="block-comment">
    <a href="/user/<?= $comment->getUser()->getId() ?>">
        <img class="comment-user-image" src="<?= $comment->getUser()->getProfile() ?>"
             alt="User image">
    </a>

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
                    <li>
                        <a href="/post/<?= $post->getId() ?>/comment/<?= $comment->getId() ?>/answer/add#form-post-comment-answer-add"
                           class="button-mini">Відповісти</a>
                    </li>
                    <li>
                        <? if (!$comment->checkLikeByUser($user)): ?>
                            <a href="/comment/<?= $comment->getId() ?>/like/add"><i
                                    class="fa-solid fa-heart like-mini like-false"></i></a>
                        <? else: ?>
                            <a href="/comment/<?= $comment->getId() ?>/like/delete"><i
                                    class="fa-solid fa-heart like-mini like-true"></i></a>
                        <? endif; ?>
                        <?= $countCommentLikes[$comment->getId()] ?>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>