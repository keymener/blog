<?php


namespace keymener\myblog\core;

/**
 * Return Json for flash message alerts
 *
 * @package keymener\myblog\core
 */
class JsonResponse
{

    public function getResponse($content)
    {

        header('Content-Type: application/json');
        echo json_encode($content);
        die;
    }
}