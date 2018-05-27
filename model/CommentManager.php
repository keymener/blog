<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace keymener\myblog\model;

use keymener\myblog\entity\Comment;
use PDO;

/**
 * Description of commentManager
 *
 * @author Keigo Matsunaga <keigo.matsunaga@gmail.com>
 */
class CommentManager
{

    private $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function getAllComments()
    {
        $statement = 'SELECT * FROM comment';
        $req = $this->db->dbLaunch()->query($statement);

        return $req->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getComments($postId)
    {
        $req = $this->db->dbLaunch()->prepare(''
                . 'SELECT * FROM comment WHERE post_id = :id ');
        $req->bindValue(':id', $postId, PDO::PARAM_INT);
        $req->execute();

        return $req->fetchall(PDO::FETCH_ASSOC);
    }

    public function getOkComments($postId)
    {
        $req = $this->db->dbLaunch()->prepare(''
                . 'SELECT * FROM comment '
                . 'WHERE published = true AND post_id = :id ');
        $req->bindValue(':id', $postId, PDO::PARAM_INT);
        $req->execute();

        return $req->fetchall(PDO::FETCH_ASSOC);
    }

    public function add(Comment $comment)
    {
        $req = $this->db->dbLaunch()->prepare(''
                . 'INSERT INTO comment '
                . 'SET content = :content,'
                . 'dateTime = :dateTime, '
                . 'published = :published, '
                . 'post_id = :postId, '
                . 'user_id = :userId, '
                . 'author = :author');

        $req->bindValue(':content', $comment->getContent(), PDO::PARAM_STR);
        $req->bindValue(':dateTime', $comment->getDateTime(), PDO::PARAM_STR);
        $req->bindValue(':published', $comment->getPubished(), PDO::PARAM_BOOL);
        $req->bindValue(':postId', $comment->getPost_id(), PDO::PARAM_INT);
        $req->bindValue(':userId', $comment->getUser_id(), PDO::PARAM_INT);
        $req->bindValue(':author', $comment->getAuthor(), PDO::PARAM_STR);

        $req->execute();
    }

    public function countWaitComment($postId)
    {
        $statement = 'SELECT * FROM comment WHERE published = false AND post_id = :id';
        $req = $this->db->dbLaunch()->prepare($statement);
        $req->bindValue(':id', $postId, PDO::PARAM_INT);
        $req->execute();

        return $req->columnCount();
    }

    public function countCommment($postId)
    {
        $statement = 'SELECT * FROM comment WHERE post_id = :id';
        $req = $this->db->dbLaunch()->prepare($statement);
        $req->bindValue(':id', $postId, PDO::PARAM_INT);
        $req->execute();

        return $req->columnCount();
    }
    
    public function publish($id)
    {
        $statement = 'UPDATE comment SET published = true WHERE id = :id';
        $req = $this->db->dbLaunch()->prepare($statement);
        $req->bindValue(':id', $id, PDO::PARAM_INT);
        $req->execute();
    }

}
