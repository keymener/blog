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

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function getAllPosts()
    {
        $posts = [];

        $db = $this->db->dbLaunch();
        $req = $db->query('SELECT * FROM post ORDER BY lastDate DESC');

        foreach ($req as $value) {
            $posts[] = new Post($value);
        }
     
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
                . ' UserId = :adminUser  '
                . 'WHERE id = :id');
        $req->bindValue(':title', $data->getTitle(), PDO::PARAM_STR);
        $req->bindValue(':chapeau', $data->getChapeau(), PDO::PARAM_STR);
        $req->bindValue(':content', $data->getContent(), PDO::PARAM_STR);
        $req->bindValue(':lastDate', $data->getLastDate(), PDO::PARAM_STR);
        $req->bindValue(':published', $data->getPublished(), PDO::PARAM_BOOL);
        $req->bindValue(':adminUser', $data->getUserId(), PDO::PARAM_INT);
        $req->bindValue(':id', $data->getUserId(), PDO::PARAM_INT);
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

    public function getPost($id) : Post
    {

        $db = $this->db->dbLaunch();
        $req = $db->prepare('SELECT * FROM post WHERE id = :id  ');
        $req->bindValue(':id', $id, PDO::PARAM_INT);
        $req->execute();

        $result = $req->fetch(PDO::FETCH_ASSOC);
       
        $post = new Post($result);
        $req->closeCursor();

        return $post;
    }

    public function getLastDate()
    {
        $req = $this->db->dbLaunch()->query('SELECT lastDate FROM post ORDER BY lastDate DESC LIMIT 1');
        $req->execute();

        $date = $req->fetch();

        return $date['lastDate'];
    }

}
