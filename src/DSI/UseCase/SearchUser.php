<?php

namespace DSI\UseCase;

use DSI\Entity\Project;
use DSI\Entity\ProjectMember;
use DSI\Entity\User;
use DSI\NotFound;
use DSI\Repository\ProjectMemberRepo;
use DSI\Repository\UserRepo;
use DSI\Service\ErrorHandler;

class SearchUser
{
    /** @var ErrorHandler */
    private $errorHandler;

    /** @var String */
    private $term;

    /** @var UserRepo */
    private $userRepo;

    /** @var User[] */
    private $users = [];

    public function exec()
    {
        $this->errorHandler = new ErrorHandler();
        $this->userRepo = new UserRepo();

        if (strpos($this->term, '@') !== false) {
            try {
                $this->users[] = $this->userRepo->getByEmail($this->term);
            } catch (NotFound $e) {
            }
        } else {
            $this->users = $this->userRepo->searchByName($this->term);
        }
    }

    /**
     * @param String $term
     */
    public function setTerm($term)
    {
        $this->term = (string)$term;
    }

    /**
     * @return User[]
     */
    public function getUsers(): array
    {
        return $this->users;
    }
}