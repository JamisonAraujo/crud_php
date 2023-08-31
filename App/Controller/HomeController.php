<?php

    class HomeController{
        public function index(){

            try{
                $posts = Post::selectAll("DESC");

                echo "<h3><a href=\"?page=admin&op=newPost&r=h\">Criar nova postagem</a></h3>";

                foreach($posts as $post){
                    $commentCount = Comment::countAll($post->id);
                    
                    echo "<section>";
                        echo "<article>";
                            echo "<h2><a href=\"?page=post&post_id=$post->id\"> $post->title </a></h2>";
                            echo "<p>$post->content</p>";
                            if($commentCount == 1){
                                echo "<p class=\"commentCount\">1 comentário</p>";
                            } else{
                                echo "<p class=\"commentCount\">$commentCount Comentários</p>";

                            }
                        echo "</article>";
                    echo "</section>";
                }
            } catch(Exception $e){
                echo $e->getMessage();
            }
        }
        
    }