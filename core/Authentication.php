<?php



namespace keymener\myblog\core;

/**
 * password encryption and check functions
 *
 * @author keymener
 */
class Authentication
{

    /**
     * compare if password matches
     * @param type $username
     * @param type $password
     * @return boolean
     */
    public function checkPassword($userPassword, $basePassword): bool
    {

        if (password_verify($userPassword, $basePassword)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * return encrypted password
     * @param string $password
     * @return string
     */
    public function encrypt(string $password) : string
    {
        $encryptedPassword = password_hash($password, PASSWORD_DEFAULT);
        return $encryptedPassword;
    }

    public function logout()
    {
        session_destroy();
    }
}
