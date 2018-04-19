<?php

require 'vendor/autoload.php';




try {
   
    $posts = new \keymener\myblog\controller\PostController();
    $posts->getAllPosts();
    
    
    
    
   
} catch (Exception $exc) {
    echo $exc->getMessage();
}
