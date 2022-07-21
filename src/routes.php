<?php

return [
    '~^$~' => [\xdeanboy\Controllers\MainController::class, 'main'],
    '~^send-me$~' => [\xdeanboy\Controllers\MainController::class, 'sendMe'],
    '~^test$~' => [\xdeanboy\Controllers\MainController::class, 'test'],
    '~^sign-in$~' => [\xdeanboy\Controllers\UsersController::class, 'signIn'],
    '~^sign-up$~' => [\xdeanboy\Controllers\UsersController::class, 'signUp'],
    '~^sign-up/activation-user-(\d+)/activation-code-(.*)$~' =>
        [\xdeanboy\Controllers\UsersController::class, 'activation'],
    '~^user/logout$~' => [\xdeanboy\Controllers\UsersController::class, 'logOut'],
    '~^user/(\d+)$~' => [\xdeanboy\Controllers\UsersController::class, 'profileView'],
    '~^blog$~' => [\xdeanboy\Controllers\MainController::class, 'blog'],
    '~^post/(\d+)$~' => [\xdeanboy\Controllers\BlogController::class, 'view'],
    '~^post/(\d+)/edit$~' => [\xdeanboy\Controllers\BlogController::class, 'edit'],
    '~^post/(\d+)/delete$~' => [\xdeanboy\Controllers\BlogController::class, 'delete'],
    '~^post/(\d+)/delete/confirmation$~' => [\xdeanboy\Controllers\BlogController::class, 'deleteConfirmation'],
    '~^post/add$~' => [\xdeanboy\Controllers\BlogController::class, 'add'],
    '~^post/find/by-section-(.*)$~' => [\xdeanboy\Controllers\BlogController::class, 'findBySection'],
    '~^post/(\d+)/comment/add$~' => [\xdeanboy\Controllers\BlogCommentsController::class, 'add'],
    '~^post/(\d+)/comment/(\d+)/delete$~' => [\xdeanboy\Controllers\BlogCommentsController::class, 'delete'],
    '~^post/(\d+)/comment/(\d+)/delete-confirmed$~' =>
        [\xdeanboy\Controllers\BlogCommentsController::class, 'deleteConfirmed'],
    '~^post/(\d+)/comment/(\d+)/edit$~' => [\xdeanboy\Controllers\BlogCommentsController::class, 'edit'],
    '~^post/(\d+)/comment/(\d+)/answer/add$~' =>
        [\xdeanboy\Controllers\CommentAnswerController::class, 'add'],
    '~^post/(\d+)/comment/(\d+)/answer/(\d+)/add$~' =>
        [\xdeanboy\Controllers\CommentAnswerController::class, 'addForAnswer'],
    '~^post/(\d+)/comment/(\d+)/answer/(\d+)/edit$~' =>
        [\xdeanboy\Controllers\CommentAnswerController::class, 'edit'],
    '~^post/(\d+)/comment/(\d+)/answer/(\d+)/delete$~' =>
        [\xdeanboy\Controllers\CommentAnswerController::class, 'delete'],
    '~^post/(\d+)/comment/(\d+)/answer/(\d+)/delete-confirmed$~' =>
        [\xdeanboy\Controllers\CommentAnswerController::class, 'deleteConfirmed'],
    '~^post/(\d+)/like/add$~' => [\xdeanboy\Controllers\BlogLikesController::class, 'add'],
    '~^post/(\d+)/like/delete$~' => [\xdeanboy\Controllers\BlogLikesController::class, 'delete'],
    '~^post/(\d+)/like/delete-confirmed$~' => [\xdeanboy\Controllers\BlogLikesController::class, 'deleteConfirmed'],
    '~^comment/(\d+)/like/add$~' => [\xdeanboy\Controllers\CommentLikesController::class, 'add'],
    '~^comment/(\d+)/like/delete$~' => [\xdeanboy\Controllers\CommentLikesController::class, 'delete'],
    '~^comment/(\d+)/like/delete-confirmed$~' => [\xdeanboy\Controllers\CommentLikesController::class, 'deleteConfirmed'],
    '~^comment/(\d+)/answer/(\d+)/like/add$~' => [\xdeanboy\Controllers\CommentLikesController::class, 'answerAdd'],
    '~^comment/(\d+)/answer/(\d+)/like/delete$~' => [\xdeanboy\Controllers\CommentLikesController::class, 'answerDelete'],
    '~^comment/(\d+)/answer/(\d+)/like/delete-confirmed$~' => [\xdeanboy\Controllers\CommentLikesController::class, 'answerDeleteConfirmed'],
    '~^admin-panel$~' => [\xdeanboy\Controllers\AdminControllers\MainController::class, 'main'],
];
