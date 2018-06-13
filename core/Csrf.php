<?php



namespace keymener\myblog\core;

/**
 * protect form from csrf
 *
 * @author Keigo Matsunaga <keigo.matsunaga@gmail.com>
 */
class Csrf
{
    /**
     * put the random token into session and return it
     * @param int $length
     * @return string
     */
    public function sessionRandom(int $length): string
    {
        $random = md5(random_bytes($length));
        $_SESSION['token'] = $random;
        return $random;
    }
}
