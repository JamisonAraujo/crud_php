<?php

    class Core {
        public function start($urlGet){

            if(isset($urlGet['page'])){
                $controller = ucfirst($urlGet['page'].'Controller');
            } else {
                $controller = 'HomeController';
            }

            if(isset($urlGet['op'])){
                $action = $urlGet['op'];
            } else{
                $action = 'index';
            }

            if(isset($urlGet['post_id'])){
                $postId = $urlGet['post_id'];
            } else{
                $postId = null;
            }
            
            if(!class_exists($controller)){
                $controller = 'ErrorController';
            }
            
            if(isset($urlGet['comment_id'])){
                $commentId = $urlGet['comment_id'];
                call_user_func_array(array(new $controller, $action), array($commentId));
            } else{
                call_user_func_array(array(new $controller, $action), array($postId));
            }
            
        }
    }