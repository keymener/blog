<?php

namespace keymener\myblog\controller;

/**
 * controller pour post
 *
 * @author keyme
 */
class postController {

    public static function add() {

        $post = [
            'title' => 'bonjour',
            'chapeau' => 'ceci est un test',
            'content' => 'Lorem ipsum dolor sit amet',
            'lastDate' => '2018-04-18 10:05:10',
            'published' => true,
            'adminUser' => 1
        ];

        $mypost = new \keymener\myblog\model\Post($post);
        $manager = new \keymener\myblog\model\PostManager();
        $manager->setPost($mypost);
    }

}
