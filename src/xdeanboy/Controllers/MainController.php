<?php

namespace xdeanboy\Controllers;

use xdeanboy\Exceptions\ForbiddenException;
use xdeanboy\Exceptions\InvalidArgumentException;
use xdeanboy\Exceptions\NotFoundException;
use xdeanboy\Exceptions\UnauthorizedException;
use xdeanboy\Models\Blog\Blog;
use xdeanboy\Models\Blog\BlogComments;
use xdeanboy\Models\Blog\BlogLikes;
use xdeanboy\Models\Blog\BlogSections;
use xDeanBoy\Models\Messages\FromUnauthorized\MessagesFromUnauthorized;
use xdeanboy\Services\EmailSender;

class MainController extends AbstractController
{
    /**
     * @return void
     */
    public function main(): void
    {
        $sections = BlogSections::findAll();

        try {
            if ($sections === null) {
                throw new InvalidArgumentException('Постів ще не має');
            }
        } catch (InvalidArgumentException $e) {
            $this->view->renderHtml('blog/main.php',
                ['title' => 'Головна сторінка',
                    'error' => $e->getMessage()]);
            return;
        }

        $this->view->renderHtml('blog/main.php',
            ['title' => 'Головна сторінка',
                'sections' => $sections]);
    }

    /**
     * @return void
     * @throws NotFoundException
     * @throws UnauthorizedException
     */
    public function blog(): void
    {
        if (empty($this->user)) {
            throw new UnauthorizedException();
        }

        $sections = BlogSections::findAll();

        if ($sections === null) {
            throw new NotFoundException('Розділи контенту не знайдено');
        }

        $posts = Blog::findAllBySortCreated();

        try {
            if ($posts === null) {
                throw new InvalidArgumentException('Не знайдено жодного посту');
            }

            foreach ($posts as $post) {
                $comments[$post->getId()] = BlogComments::findAllByPost($post->getId());
                $likes[$post->getId()] = BlogLikes::findAllByPost($post);
                $countlikes[$post->getId()] = BlogLikes::countLikesByPost($post);
            }

            if (!empty($comments)) {
                foreach ($comments as $postId => $commentsByPost) {
                    if (!empty($commentsByPost)) {
                        $countCommentsByPost[$postId] = BlogComments::getCountCommentsByPost($postId);
                    } else {
                        $countCommentsByPost[$postId] = 0;
                    }
                }
            }

            $this->view->renderHtml('blog/blog.php',
                ['title' => 'Блог xdeanboy',
                    'sections' => $sections,
                    'posts' => $posts,
                    'countCommentsByPost' => $countCommentsByPost,
                    'countLikes' => $countlikes]);
            return;
        } catch (InvalidArgumentException $e) {
            $this->view->renderHtml('blog/blog.php',
                ['title' => 'Блог xdeanboy',
                    'sections' => $sections,
                    'countCommentsByPost' => $countCommentsByPost,
                    'countLikes' => $countlikes,
                    'error' => $e->getMessage()]);
            return;
        }
    }

    /**
     * @return void
     */
    public function sendMe(): void
    {
        try {
            $message = MessagesFromUnauthorized::newMessage($_POST);

            if (!empty($message)) {
                EmailSender::send(
                    $this->projectContacts->getEmail(),
                'Анонімне повідомлення з footer проекта',
                'unauthorizedMessage.php',
                ['email' => $message->getEmail(),
                    'name' => $message->getName(),
                    'message' => $message->getText()]);
            }

            $this->view->renderHtml('messages/messagesSendSuccessful.php',
                ['title' => 'Успішно відправлено',
                    'message' => $message]);
            return;
        } catch (InvalidArgumentException $e) {
            $this->view->renderHtml('errors/errorSendMe.php',
                ['title' => 'Не відправлено',
                    'errorFooter' => $e->getMessage()]);
            return;
        }
    }

    /**
     * For test renderHtml
     * @return void
     * @throws ForbiddenException
     * @throws UnauthorizedException
     */
    public function test(): void
    {
        if (empty($this->user)) {
            throw new UnauthorizedException();
        }

        if (!$this->user->isAdmin()) {
            throw new ForbiddenException();
        }

        echo 'Tester';
    }

}