<?php
    class AdminController{
        public function index(){
            $admin = file_get_contents('App/View/Admin.html');
            $posts = Post::selectAll("");
            
            ob_start();
                foreach($posts as $post){
                    echo "<tr><td> $post->id</td>";
                    echo "<td> $post->title</td>";
                    echo "<td> $post->content</td>";
                    echo "<td> <a href=\"?page=admin&op=delete&post_id=$post->id\">&nbsp x</a></td>";
                    echo "<td> <a href=\"?page=admin&op=editpost&post_id=$post->id\">&nbsp x</a></td></tr>";
                }
                
                $obOutput = ob_get_contents();
            ob_end_clean();
            
            echo str_replace('{{postTable}}', $obOutput, $admin);

        }

        public function newPost(){
            $createPost = file_get_contents('App/View/CreatePost.html');
            if(isset($_GET['r'])){
                $createPost = str_replace('{{pageReturn}}', $_GET['r'], $createPost);
            } else {
                $createPost = str_replace('{{pageReturn}}', '', $createPost);
            }
            echo $createPost;
        }

        public function editPost($params){
            $post = Post::selectById((int)$params);
            $editPost = file_get_contents('App/View/EditPost.html');

            $id = $post->id;
            $title = $post->title;
            $content = $post->content;

            $editPost = str_replace('{{post_id}}', $id, $editPost);
            $editPost = str_replace('{{postTitle}}', $title, $editPost);
            $editPost = str_replace('{{postContent}}', $content, $editPost);
            echo $editPost;
        }

        public function insert(){
            try{
                Post::insert($_POST);
                echo '<script>alert("Publicação inserida com sucesso.");</script>';
                if(isset($_POST['pageReturn'])){
                    echo '<script>location.href="?page=home";</script>';
                } else {
                    echo '<script>location.href="?page=admin&op=index";</script>';
                }
            }catch(Exception $e){
                echo '<script>alert("' . $e->getMessage() . '")</script>';
                if(isset($_POST['pageReturn'])){
                    echo '<script>location.href="?page=admin&op=newPost&r=h";</script>';
                } else {
                    echo '<script>location.href="?page=admin&op=newPost";</script>';
                }
            }    
        }

        public function update(){
            try{
                Post::update($_POST);
                echo '<script>alert("Publicação atualizada com sucesso.");</script>';
                echo '<script>location.href="?page=admin&op=index";</script>';
            }catch(Exception $e){
                echo '<script>alert("'. $e->getMessage(). '")</script>';
                echo '<script>location.href="?page=admin&op=editPost&post_id='. $_POST['post_id']. '";</script>';
            }
        }

        public function delete($params){
            try{
                // var_dump($params);
                Post::delete($params);
                echo '<script>alert("Publicação excluída com sucesso.");</script>';
                echo '<script>location.href="?page=admin&op=index";</script>';
            }catch(Exception $e){
                echo '<script>alert("'. $e->getMessage(). '")</script>';
                echo '<script>location.href="?page=admin&op=index";</script>';
            }
        }

    }