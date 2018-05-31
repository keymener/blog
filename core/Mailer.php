<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace keymener\myblog\core;

use PHPMailer\PHPMailer\PHPMailer;

/**
 * Description of Mailer
 *
 * @author Keigo Matsunaga <keigo.matsunaga@gmail.com>
 */
class Mailer
{

    private $mail;
    private $email;
    private $myEmail;
    private $password;
    private $host;
    private $port;
    private $smtpSecure;
    private $smtpAuth;

    public function __construct(PHPMailer $mail, Email $email)
    {
        $this->mail = $mail;
        $this->email = $email;
        $config = parse_ini_file('./config/config.ini', true);
        $this->myEmail = $config['email']['myEmail'];
        $this->password = $config['email']['password'];
        $this->host = $config['email']['host'];
        $this->port = $config['email']['port'];
        $this->smtpSecure = $config['email']['smtpSecure'];
        $this->smtpAuth = $config['email']['smtpAuth'];
    }

    public function sendmail($name, $email, $content)
    {
        
        //build the Email isntance
        $this->email->setName($name);
        $this->email->setEmail($email);
        $this->email->setContent($content);


//Tell PHPMailer to use SMTP
        $this->mail->isSMTP();
//Enable SMTP debugging
// 0 = off (for production use)
// 1 = client messages
// 2 = client and server messages
        $this->mail->SMTPDebug = 0;
//Set the hostname of the mail server
        $this->mail->Host = $this->host;
// use
// $mail->Host = gethostbyname('smtp.gmail.com');
// if your network does not support SMTP over IPv6
//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
        $this->mail->Port = $this->port;
//Set the encryption system to use - ssl (deprecated) or tls
        $this->mail->SMTPSecure = $this->smtpSecure;
//Whether to use SMTP authentication
        $this->mail->SMTPAuth = $this->smtpAuth;
//Username to use for SMTP authentication - use full email address for gmail
        $this->mail->Username = $this->myEmail;
//Password to use for SMTP authentication
        $this->mail->Password = $this->password;
//Set who the message is to be sent from
        $this->mail->setFrom($this->myEmail, 'First Last');
//Set an alternative reply-to address
        $this->mail->addReplyTo($this->myEmail, 'First Last');
//Set who the message is to be sent to
        $this->mail->addAddress($this->myEmail, 'John Doe');
//Set the subject line
        $this->mail->Subject = 'Mail de Myblog';
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
        $this->mail->msgHTML($this->email->format());
//Replace the plain text body with one created manually
        $this->mail->AltBody = 'This is a plain-text message body';
//Attach an image file
//        $this->mail->addAttachment('images/phpmailer_mini.png');
//send the message, check for errors
        if (!$this->mail->send()) {
            return false;
        } else {
            return true;
        }
    }

}
