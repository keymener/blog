<?php

namespace keymener\myblog\model;

use keymener\myblog\entity\Post;
use PDO;

/**
 * crud of post
 *
 * @author keymener
 */
class PostManager
{

    private $db;
  

    public function __construct(Database $db)
    {
        $this->db = $db;

    }

    /**
     * gets all posts
     * @return array
     */
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

    /**
     * get all posts with comments
     * @return array
     */
    public function getAllPostsComments()
    {
        $statement = 'SELECT
 pt.id,
 pt.title,
count(co.id) com
   
                    FROM
                    post pt,
                    comment co
                    WHERE
                    pt.id = (SELECT co.postId WHERE co.published = false)
                    group by pt.id';
        $db = $this->db->dbLaunch();
        $req = $db->query($statement);
        $posts = $req->fetchall(PDO::FETCH_ASSOC);
        $req->closeCursor();
        return $posts;
    }

    /**
     * get all published posts
     * @return array
     */
    public function getAllPublished()
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
WHERE post.published = true
ORDER BY lastDate DESC');
        $posts = $req->fetchall(PDO::FETCH_ASSOC);
        $req->closeCursor();
        return $posts;
    }

    /**
     * add a new post
     * @param Post $data
     */
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

    /**
     * update a post
     * @param Post $data
     */
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

    /**
     * delete a post
     * @param int $id
     */
    public function deletePost($id)
    {

        $db = $this->db->dbLaunch();
        $req = $db->prepare('DELETE FROM post WHERE id = :id  ');
        $req->bindValue(':id', $id, PDO::PARAM_INT);
        $req->execute();
        $req->closeCursor();
    }

    /**
     * get a single post by its id
     * @param int $id
     * @return array
     */
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

    /**
     * get the last date of post
     * @return string
     */
    public function getLastDate()
    {
        $req = $this->db->dbLaunch()->query('SELECT lastDate FROM post ORDER BY lastDate DESC LIMIT 1');
        $req->execute();

        $date = $req->fetch();

        return $date['lastDate'];
    }

}
