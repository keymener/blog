<?php

namespace keymener\myblog\model;

/**
 * post manager for database
 *
 * @author keyme
 */
class PostManager extends DbConnect {

    public function getAllPost() {

        $posts = [];

        $db = $this->getDb();
        $req = $db->query('SELECT * FROM post ORDER BY lastDate DESC');

        foreach ($req as $value) {

            $posts[] = $value;
        }
        $req = closeCursor();
        return $posts;
    }

    public function setPost($data) {

        $db = $this->getDb();
        $req = $db->prepare('INSERT INTO post (title, chapeau, content, lastDate, published) VALUES (:title, :chapeau, :content: :lastDate, :published)');
        $req->bindValue(':title', $data->getTitle(), PDO::PARAM_STR);
        $req->bindValue(':chapeau', $data->getChapeau(), PDO::PARAM_STR);
        $req->bindValue(':content', $data->getContent(), PDO::PARAM_STR);
        $req->bindValue(':lastDate', $data->getlastDate(), PDO::PARAM_STR);
        $req->bindValue(':published', $data->getPublished(), PDO::PARAM_BOOL);
        $req->execute();
        $req->closeCursor();
    }

}
