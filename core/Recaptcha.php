<?php

namespace keymener\myblog\core;

/*
 * Uses recpatcha api from google
 */


class Recaptcha
{


    public function recaptcha($response, $remoteip)
    {
        //get the secret from the ini file
        $secret = parse_ini_file('../config/recaptcha.ini');

        if (!isset($secret['secret'])) {

            throw new \Exception('there is an error into the config file of recaptcha',
                500);
        }


        $api_url = "https://www.google.com/recaptcha/api/siteverify?secret="
            . $secret['secret']
            . "&response=" . $response
            . "&remoteip=" . $remoteip;

        //Send the compilated url to google and get the json response
        $decode = json_decode(file_get_contents($api_url), true);

        if ($decode['success'] == true) {
            return true;
        } elseif($decode['error-codes'][0] !== 'missing-input-response') {

            throw new \Exception('reCaptcha: '.$decode['error-codes'][0], 500);

        }else{
            return false;
        }
    }

}