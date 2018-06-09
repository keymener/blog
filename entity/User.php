<?php

namespace keymener\myblog\entity;

/**
 * User entity
 *
 * @author keymener
 */
class User
{

    protected $id;
    protected $lastname;
    protected $firstname;
    protected $login;
    protected $password;
    protected $email;


    public function hydrate(array $data)
    {
        if (isset($data)) {
            foreach ($data as $key => $value) {
                $method = 'set' . ucfirst($key);

                if (method_exists(__CLASS__, $method)) {
                    $this->$method($value);
                }
            }
        }
    }
    
 
    public function getId()
    {
        return $this->id;
    }

    public function getLastname()
    {
        return $this->lastname;
    }

    public function getFirstname()
    {
        return $this->firstname;
    }

    public function getLogin()
    {
        return $this->login;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getEmail()
    {
        return $this->email;
    }

    protected function setId($id)
    {
        $id = (int) $id;
        $this->id = $id;
    }

    protected function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }

    protected function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    protected function setLogin($login)
    {
        $this->login = $login;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    protected function setEmail($email)
    {
        $this->email = $email;
    }
}
