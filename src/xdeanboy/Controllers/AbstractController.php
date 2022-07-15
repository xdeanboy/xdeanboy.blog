<?php

namespace xdeanboy\Controllers;

use xdeanboy\Models\ContactsProject\ContactsProject;
use xdeanboy\Models\Users\UserAuthorization;
use xdeanboy\View\View;

abstract class AbstractController
{
    protected $view;
    protected $user;
    protected $projectAuthor;
    protected $projectContacts;

    public function __construct()
    {
        //connect templates
        $this->view = new View(__DIR__ . '/../../../templates');

        //get User by token
        $this->user = UserAuthorization::getUserByToken();
        $this->view->setVars('user', $this->user);

        //get project author for footer contacts
        $this->projectAuthor = ContactsProject::getProjectAuthor();
        $this->view->setVars('projectAuthor', $this->projectAuthor);

        //get project contacts for send-me in footer
        $this->projectContacts = ContactsProject::getProjectContacts();
    }
}