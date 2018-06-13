<?php

namespace keymener\myblog\core;

/**
 * Check form input
 *
 * @author Keigo Matsunaga <keigo.matsunaga@gmail.com>
 */
class CheckInput
{
/**
 * check the input format to be like an email
 * @param type $email
 * @return bool
 */
    public function checkEmail($email) : bool
    {
        $subject = $email;
        $pattern = '#^[^@\s]+@[^@\s]+\.[^@\s]+$#';

        if (preg_match($pattern, $subject)) {
            return true;
        } else {
            return false;
        }
    }
    
    public function checkLenth($string, int $size): bool
    {
        if(strlen($string) <= $size && strlen($string) > 1){
            return true;
        }else
        {
            return false;
        }
    }
   

}
