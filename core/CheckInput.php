<?php

namespace keymener\myblog\core;

/**
 * Check form input
 *
 * @author Keigo Matsunaga <keigo.matsunaga@gmail.com>
 */
class CheckInput
{

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
