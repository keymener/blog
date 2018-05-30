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
    private $myEmail;
    private $password;
    private $host;
    private $port;
    private $smtpSecure;
    private $smtpAuth;

    public function __construct(PHPMailer $mail)
    {
        $this->mail = $mail;
        $config = parse_ini_file('./config/config.ini', true);
        $this->myEmail = $config['email']['myEmail'];
        $this->password = $config['email']['password'];
        $this->host = $config['email']['host'];
        $this->port = $config['email']['port'];
        $this->smtpSecure = $config['email']['smtpSecure'];
        $this->smtpAuth = $config['email']['smtpAuth'];
    }

    public function sendmail($name, $userEmail, $message)
    {


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
        $this->mail->Subject = 'PHPMailer GMail SMTP test';
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
        $this->mail->msgHTML('<b>nom:</b> '.$name.'</br><b>email :</b>' .$userEmail.'</br><b>message:</b> '. $message);
//Replace the plain text body with one created manually
        $this->mail->AltBody = 'This is a plain-text message body';
//Attach an image file
//        $this->mail->addAttachment('images/phpmailer_mini.png');
//send the message, check for errors
        if (!$this->mail->send()) {
            echo "Mailer Error: " . $this->mail->ErrorInfo;
        } else {
            echo "Message sent!";
//Section 2: IMAP
//Uncomment these to save your message in the 'Sent Mail' folder.
#if (save_mail($mail)) {
#    echo "Message saved!";
#}
        }
    }

}
