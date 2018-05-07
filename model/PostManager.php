<?php

require 'DbConnect.php';


namespace keymener\myblog\model;

/**
 * post manager for database
 *
 * @author keyme
 */
class PostManager extends DbConnect
{

    public function __construct()
    {
        $this->dblaunch();
    }

    public function getAllPosts()
    {

        $posts = [];

        $db = $this->getDb();
        $req = $db->query('SELECT * FROM post ORDER BY lastDate DESC');

        foreach ($req as $value) {
            $posts[] = $value;
        }
        $req->closeCursor();
        return $posts;
    }

    public function addPost($data)
    {

        $db = $this->getDb();
        $req = $db->prepare('INSERT INTO post (title, chapeau, content, '
                . 'lastDate, published, adminUser) '
                . 'VALUES (:title, :chapeau, :content, '
                . ':lastDate, :published, :adminUser)');
        $req->bindValue(':title', $data->getTitle(), \PDO::PARAM_STR);
        $req->bindValue(':chapeau', $data->getChapeau(), \PDO::PARAM_STR);
        $req->bindValue(':content', $data->getContent(), \PDO::PARAM_STR);
        $req->bindValue(':lastDate', $data->getLastDate(), \PDO::PARAM_STR);
        $req->bindValue(':published', $data->getPublished(), \PDO::PARAM_BOOL);
        $req->bindValue(':adminUser', $data->getAdminUser(), \PDO::PARAM_INT);
        $req->execute();
        $req->closeCursor();
    }

    public function updatePost($data)
    {

        $db = $this->getDb();
        $req = $db->prepare('UPDATE post SET '
                . 'title = :title,'
                . ' chapeau = :chapeau,'
                . ' content = :content,'
                . ' lastDate = :lastDate,'
                . ' published = :published,'
                . ' adminUser = :adminUser  ');
        $req->bindValue(':title', $data->getTitle(), \PDO::PARAM_STR);
        $req->bindValue(':chapeau', $data->getChapeau(), \PDO::PARAM_STR);
        $req->bindValue(':content', $data->getContent(), \PDO::PARAM_STR);
        $req->bindValue(':lastDate', $data->getLastDate(), \PDO::PARAM_STR);
        $req->bindValue(':published', $data->getPublished(), \PDO::PARAM_BOOL);
        $req->bindValue(':adminUser', $data->getAdminUser(), \PDO::PARAM_INT);
        $req->execute();
        $req->closeCursor();
    }

    public function deletePost($id)
    {

        $db = $this->getDb();
        $req = $db->prepare('DELETE FROM post WHERE id = :id  ');
        $req->bindValue(':id', $id, \PDO::PARAM_INT);
        $req->execute();
        $req->closeCursor();
    }

    public function getPost($id)
    {

        $db = $this->getDb();
        $req = $db->prepare('SELECT * FROM post WHERE id = :id  ');
        $req->bindValue(':id', $id, \PDO::PARAM_INT);
        $req->execute();

        $post = $req->fetch(\PDO::FETCH_OBJ);

        $req->closeCursor();

        return $post;
    }
}
