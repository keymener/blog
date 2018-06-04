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
                . 'SELECT * FROM comment WHERE postId = :id ');
        $req->bindValue(':id', $postId, PDO::PARAM_INT);
        $req->execute();

        return $req->fetchall(PDO::FETCH_ASSOC);
    }

    /**
     * Return comment data by its Id
     * @param int $id
     * @return type
     */
    public function getComment(int $id)
    {
        $req = $this->db->dbLaunch()->prepare(''
                . 'SELECT * FROM comment WHERE id = :id ');
        $req->bindValue(':id', $id, PDO::PARAM_INT);
        $req->execute();

        return $req->fetch(PDO::FETCH_ASSOC);
    }

    public function getOkComments($postId)
    {
        $req = $this->db->dbLaunch()->prepare(''
                . 'SELECT * FROM comment '
                . 'WHERE published = true AND postId = :id ');
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
                . 'postId = :postId, '
                . 'userId = :userId, '
                . 'author = :author');

        $req->bindValue(':content', $comment->getContent(), PDO::PARAM_STR);
        $req->bindValue(':dateTime', $comment->getDateTime(), PDO::PARAM_STR);
        $req->bindValue(':published', $comment->getPublished(), PDO::PARAM_BOOL);
        $req->bindValue(':postId', $comment->getPostId(), PDO::PARAM_INT);
        $req->bindValue(':userId', $comment->getUserId(), PDO::PARAM_INT);
        $req->bindValue(':author', $comment->getAuthor(), PDO::PARAM_STR);

        $req->execute();
    }

    public function countWaitComment($postId)
    {
        $statement = 'SELECT * FROM comment WHERE published = false AND postId = :id';
        $req = $this->db->dbLaunch()->prepare($statement);
        $req->bindValue(':id', $postId, PDO::PARAM_INT);
        $req->execute();

        return $req->columnCount();
    }
    
    /**
     * count all comments waiting for validation
     * @return type
     */
      public function countAllWaitComment()
    {
        $statement = 'SELECT * FROM comment WHERE published = false';
        $req = $this->db->dbLaunch()->query($statement);
    
        return $req->columnCount();
    }

    public function countCommment($postId)
    {
        $statement = 'SELECT * FROM comment WHERE postId = :id';
        $req = $this->db->dbLaunch()->prepare($statement);
        $req->bindValue(':id', $postId, PDO::PARAM_INT);
        $req->execute();

        return $req->columnCount();
    }

    public function update(Comment $comment)
    {
        $statement = 'UPDATE comment SET published = true WHERE id = :id';
        $req = $this->db->dbLaunch()->prepare($statement);
        $req->bindValue(':id', $comment->getId(), PDO::PARAM_INT);
        $req->execute();
    }

}
