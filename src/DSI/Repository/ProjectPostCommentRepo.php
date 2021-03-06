<?php

namespace DSI\Repository;

use DSI\Entity\ProjectPostComment;
use DSI\Entity\User;
use DSI\NotFound;
use DSI\Service\SQL;

class ProjectPostCommentRepo
{
    public function insert(ProjectPostComment $projectPostComment)
    {
        if (!$projectPostComment->getProjectPost() OR !$projectPostComment->getProjectPostId())
            throw new \InvalidArgumentException();
        if (!$projectPostComment->getUserId() OR !$projectPostComment->getUserId())
            throw new \InvalidArgumentException();
        if ($projectPostComment->getComment() == '')
            throw new \InvalidArgumentException();

        $insert = array();
        $insert[] = "`postID` = '" . (int)($projectPostComment->getProjectPostId()) . "'";
        $insert[] = "`userID` = '" . (int)($projectPostComment->getUserId()) . "'";
        $insert[] = "`comment` = '" . addslashes($projectPostComment->getComment()) . "'";
        $insert[] = "`time` = NOW()";
        $insert[] = "`repliesCount` = '" . (int)($projectPostComment->getRepliesCount()) . "'";

        $query = new SQL("INSERT INTO `project-post-comments` SET " . implode(', ', $insert) . "");
        $query->query();

        $projectPostComment->setId($query->insert_id());
    }

    public function save(ProjectPostComment $projectPostComment)
    {
        if (!$projectPostComment->getProjectPost() OR !$projectPostComment->getProjectPostId())
            throw new \InvalidArgumentException();
        if (!$projectPostComment->getUserId() OR !$projectPostComment->getUserId())
            throw new \InvalidArgumentException();
        if ($projectPostComment->getComment() == '')
            throw new \InvalidArgumentException();

        $query = new SQL("SELECT id FROM `project-post-comments` WHERE id = '{$projectPostComment->getId()}' LIMIT 1");
        $existingPost = $query->fetch();
        if (!$existingPost)
            throw new NotFound('commentID: ' . $projectPostComment->getId());

        $insert = array();
        $insert[] = "`postID` = '" . (int)($projectPostComment->getProjectPostId()) . "'";
        $insert[] = "`userID` = '" . (int)($projectPostComment->getUserId()) . "'";
        $insert[] = "`comment` = '" . addslashes($projectPostComment->getComment()) . "'";
        $insert[] = "`repliesCount` = '" . (int)($projectPostComment->getRepliesCount()) . "'";

        $query = new SQL("UPDATE `project-post-comments` SET " . implode(', ', $insert) . " WHERE `id` = '{$projectPostComment->getId()}'");
        $query->query();
    }

    public function remove(ProjectPostComment $projectPostComment)
    {
        $query = new SQL("SELECT id FROM `project-post-comments` WHERE id = '{$projectPostComment->getId()}' LIMIT 1");
        $existingPost = $query->fetch();
        if (!$existingPost)
            throw new NotFound('commentID: ' . $projectPostComment->getId());

        $query = new SQL("DELETE FROM `project-post-comments` WHERE `id` = '{$projectPostComment->getId()}'");
        $query->query();
    }

    public function getById(int $id): ProjectPostComment
    {
        return $this->getObjectWhere([
            "`id` = {$id}"
        ]);
    }

    /**
     * @param string[] $dbComment
     * @return ProjectPostComment
     */
    private function buildPostFromData($dbComment)
    {
        $comment = new ProjectPostComment();
        $comment->setId($dbComment['id']);

        $comment->setProjectPost(
            (new ProjectPostRepo())->getById($dbComment['postID'])
        );
        $comment->setUser(
            (new UserRepo())->getById($dbComment['userID'])
        );
        $comment->setComment($dbComment['comment']);
        $comment->setTime($dbComment['time']);
        $comment->setRepliesCount($dbComment['repliesCount']);

        return $comment;
    }

    public function getAll()
    {
        return $this->getObjectsWhere([
            "1"
        ]);
    }

    public function getByUser(User $user)
    {
        return $this->getObjectsWhere([
            "`userID` = '" . $user->getId() . "'"
        ]);
    }

    public function getByPostID(int $postID)
    {
        return $this->getObjectsWhere([
            "`postID` = '{$postID}'"
        ]);
    }

    public function clearAll()
    {
        $query = new SQL("TRUNCATE TABLE `project-post-comments`");
        $query->query();
    }

    /**
     * @param $where
     * @return ProjectPostComment
     * @throws NotFound
     */
    private function getObjectWhere($where)
    {
        $dbPost = $this->getObjectsWhere($where);
        if (count($dbPost) < 1)
            throw new NotFound();

        return $dbPost[0];
    }

    /**
     * @param array $where
     * @return ProjectPostComment[]
     */
    private function getObjectsWhere($where)
    {
        $posts = [];
        $query = new SQL("SELECT 
            id, postID, userID, comment, `time`, repliesCount
            FROM `project-post-comments` WHERE " . implode(' AND ', $where) . "
            ORDER BY `id` DESC");
        foreach ($query->fetch_all() AS $dbPost) {
            $posts[] = $this->buildPostFromData($dbPost);
        }
        return $posts;
    }
}