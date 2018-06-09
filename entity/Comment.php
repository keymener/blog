<?php



namespace keymener\myblog\entity;

/**
 * Comment entity
 *
 * @author keymener
 */
class Comment
{

    private $id;
    private $content;
    private $dateTime;
    private $published = false;
    private $postId;
    private $userId = null;
    private $author;

    public function hydrate($data)
    {
        foreach ($data as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (method_exists(__CLASS__, $method)) {
                $this->$method($value);
            }
        }
    }

    public function getAuthor()
    {
        return $this->author;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function getDateTime()
    {
        return $this->dateTime;
    }

    public function getPublished()
    {
        return $this->published;
    }

    public function getPostId()
    {
        return $this->postId;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function setId($id)
    {
        $this->id = (int) $id;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    public function setDateTime($dateTime)
    {
        $this->dateTime = $dateTime;
    }

    public function setPublished($published)
    {
        $this->published = (bool) $published;
    }

    public function setPostId($postId)
    {
        $this->postId = (int) $postId;
    }

    public function setUserId($userId)
    {
        $this->userId = (int) $userId;
    }

    public function setAuthor($author)
    {
        $this->author = $author;
    }

}
