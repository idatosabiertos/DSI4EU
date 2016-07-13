<?php

namespace DSI\Controller;

use DSI\Repository\UserRepository;
use DSI\Service\Auth;

class StaticHtmlController
{
    public $format = 'html';
    public $view;

    public function exec()
    {
        $authUser = new Auth();

        if ($authUser->isLoggedIn())
            $loggedInUser = (new UserRepository())->getById($authUser->getUserId());
        else
            $loggedInUser = null;

        if($this->format == 'txt')
            header("Content-Type: text/plain");

        require __DIR__ . '/../../../www/' . $this->view;
    }
}