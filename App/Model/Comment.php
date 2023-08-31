<?php 

    class Comment {
        public static function selectAll(int $postId){
            $con = Connection::getConn();
            
            $sql = "SELECT * FROM comment WHERE post_id = $postId ORDER BY ID DESC";
            $sql = $con->prepare($sql);
            $sql->execute();
            $result = array();
            

            while($row = $sql->fetchObject('comment')){
                $result[] = $row;
            }

            return $result;
        }
        public static function countAll(int $postId){
            $con = Connection::getConn();
            
            $sql = "SELECT COUNT(*) FROM comment WHERE post_id = $postId";
            $sql = $con->prepare($sql);
            $sql->execute();
            $result = $sql->fetchColumn();

            return (int)$result;
        }

        public static function insert($commentData){
            if(empty($commentData['username']) or empty($commentData['message'])){
                throw new Exception("O nome e o comentário não podem ser vazios");
            }

            $commentData['postId'] = (int)$commentData['postId'];
            $con = Connection::getConn();
            $sql = "INSERT INTO comment (username, message, post_id) VALUES (:username, :message, :post_id)";
            $sql = $con->prepare($sql);
            $sql->bindParam(':username', $commentData['username']);
            $sql->bindParam(':message', $commentData['message']);
            $sql->bindParam(':post_id', $commentData['postId']);
            $sql->execute();
        }

        public static function delete(int $commentId){
            $con = Connection::getConn();
            $sql = "DELETE FROM comment WHERE id = $commentId";
            $sql = $con->prepare($sql);
            $sql->execute();
        }
        
    }