<?php


namespace keymener\myblog\core;

/**
 * represents an email
 *
 * @author keymener
 */
class Email
{
    private $name;
    private $email;
    private $content;

    /**
     * format the content of the email
     * @return string
     */
    public function format()
    {
        return '<b>Nom et Prénom:</b> ' . $this->name . '<br />'
                . '<b>Email :</b> ' . $this->email . '<br />'
                . '<b>Message:</b><p>' . $this->content . '</p>';
    }


    public function setName($name)
    {
        $this->name = htmlentities($name);
    }

    public function setEmail($email)
    {
        $this->email = htmlentities($email);
    }

    public function setContent($content)
    {
        $this->content = htmlentities($content);
    }



}
