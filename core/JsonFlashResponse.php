<?php


namespace keymener\myblog\core;

/**
 * Return Json for flash message alerts
 *
 * @package keymener\myblog\core
 */
class JsonFlashResponse
{

    public function getResponse(string $status, string $message)
    {
        header('Content-Type: application/json');
        echo json_encode([
            'status' => $status,
            'message' => $message
        ]);
    }
}