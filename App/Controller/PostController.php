<?php

    class PostController{
        public function index($params){

            try{
                $params = (int)$params;
                $post = Post::selectById($params);
                $commentCount = Comment::countAll($params);
                
                $viewPost = file_get_contents('App/View/Post.html');
                $viewPost = str_replace("{{post_id}}", $post->id, $viewPost);
                $viewPost = str_replace("{{postTitle}}", $post->title, $viewPost);
                $viewPost = str_replace("{{postContent}}", $post->content, $viewPost);
                $viewPost = str_replace("{{commentCount}}", ($commentCount == 1 ? "1 comentário" : "$commentCount comentários"), $viewPost);
                
                $comments = null;
                if($commentCount > 0){
                    $comments = Comment::selectAll($params);
                    ob_start();
                        foreach($comments as $comment){
                            echo "<div class=\"comment\">";
                            echo "<p><b>$comment->username: </b>$comment->message</p>";
                            echo "<a href=\"?page=post&post_id=$post->id&op=deleteComment&comment_id=$comment->id\"><img src=\"src/thrash-can.svg\"></a><br>";   
                            echo "</div>";                             
                        }
                        $obOutput = ob_get_contents();
                    ob_end_clean();
                    
                    $comments = $obOutput;
                } 
                $viewPost = str_replace("{{commentWrapper}}", $comments, $viewPost);
                echo $viewPost;
            } catch(Exception $e){
                echo $e->getMessage();
            }
        }

        public function insertComment(){
            try{
                Comment::insert($_POST);
                echo '<script>alert("Comentário feito com sucesso.");</script>';
                echo '<script>location.href="?page=post&post_id='. $_POST['postId']. '";</script>';
            }catch(Exception $e){
                echo '<script>alert("'. $e->getMessage(). '")</script>';
                echo '<script>location.href="?page=post&post_id='. $_POST['postId']. '";</script>';
            }
        }

        public function deleteComment($params){
            try{
                Comment::delete($params);
                echo '<script>alert("Comentário excluído com sucesso.");</script>';
                echo '<script>location.href="?page=post&post_id='. $_GET['post_id']. '";</script>';
            }catch(Exception $e){
                echo '<script>alert("'. $e->getMessage(). '")</script>';
                echo '<script>location.href="?page=post&post_id='. $_GET['post_id']. '";</script>';
            }
        }
    }