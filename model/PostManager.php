<?php

namespace keymener\myblog\model;

use keymener\myblog\entity\Post;
use PDO;

/**
 * post manager for database
 *
 * @author keyme
 */
class PostManager
{

    private $db;
    private $post;

    public function __construct(Database $db, Post $post)
    {
        $this->db = $db;
        $this->post = $post;
    }

    public function getAllPosts()
    {

        $db = $this->db->dbLaunch();
        $req = $db->query('SELECT 
post.id,
post.title,
post.chapeau,
post.content,
post.lastDate,
post.published,
user.firstname
FROM post
INNER JOIN user ON ( user.id = post.userid )
ORDER BY lastDate DESC');
        $posts = $req->fetchall(PDO::FETCH_ASSOC);
        $req->closeCursor();
        return $posts;
    }

    public function addPost(Post $data)
    {

        $db = $this->db->dbLaunch();
        $req = $db->prepare('INSERT INTO post (title, chapeau, content, '
                . 'lastDate, published, userId) '
                . 'VALUES (:title, :chapeau, :content, '
                . ':lastDate, :published, :userId)');
        $req->bindValue(':title', $data->getTitle(), PDO::PARAM_STR);
        $req->bindValue(':chapeau', $data->getChapeau(), PDO::PARAM_STR);
        $req->bindValue(':content', $data->getContent(), PDO::PARAM_STR);
        $req->bindValue(':lastDate', $data->getLastDate(), PDO::PARAM_STR);
        $req->bindValue(':published', $data->getPublished(), PDO::PARAM_BOOL);
        $req->bindValue(':userId', $data->getUserId(), PDO::PARAM_INT);
        $req->execute();
        $req->closeCursor();
    }

    public function updatePost(Post $data)
    {

        $db = $this->db->dbLaunch();
        $req = $db->prepare('UPDATE post SET '
                . 'title = :title,'
                . ' chapeau = :chapeau,'
                . ' content = :content,'
                . ' lastDate = :lastDate,'
                . ' published = :published,'
                . ' userId = :adminUser  '
                . 'WHERE id = :id');
        $req->bindValue(':title', $data->getTitle(), PDO::PARAM_STR);
        $req->bindValue(':chapeau', $data->getChapeau(), PDO::PARAM_STR);
        $req->bindValue(':content', $data->getContent(), PDO::PARAM_STR);
        $req->bindValue(':lastDate', $data->getLastDate(), PDO::PARAM_STR);
        $req->bindValue(':published', $data->getPublished(), PDO::PARAM_BOOL);
        $req->bindValue(':adminUser', $data->getUserId(), PDO::PARAM_INT);
        $req->bindValue(':id', $data->getId(), PDO::PARAM_INT);
        $req->execute();
        $req->closeCursor();
    }

    public function deletePost($id)
    {

        $db = $this->db->dbLaunch();
        $req = $db->prepare('DELETE FROM post WHERE id = :id  ');
        $req->bindValue(':id', $id, PDO::PARAM_INT);
        $req->execute();
        $req->closeCursor();
    }

    public function getPost($id)
    {

        $db = $this->db->dbLaunch();
        $req = $db->prepare('SELECT * FROM post WHERE id = :id  ');
        $req->bindValue(':id', $id, PDO::PARAM_INT);
        $req->execute();

        $result = $req->fetch(PDO::FETCH_ASSOC);
        $req->closeCursor();
        return $result;
    }

    public function getLastDate()
    {
        $req = $this->db->dbLaunch()->query('SELECT lastDate FROM post ORDER BY lastDate DESC LIMIT 1');
        $req->execute();

        $date = $req->fetch();

        return $date['lastDate'];
    }
}
