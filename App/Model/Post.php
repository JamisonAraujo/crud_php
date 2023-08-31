<?php 

    class Post {
        public static function selectAll($order){
            $con = Connection::getConn();
            
            $sql = "SELECT * FROM post ORDER BY ID $order";
            $sql = $con->prepare($sql);
            // $sql->bindParam(':order', $order);
            $sql->execute();
            $result = array();
            

            while($row = $sql->fetchObject('post')){
                $result[] = $row;
            }

            if(!$result){
                throw new Exception("Não existem postagens no momento");
            }

            return $result;
        }

        public static function selectById($id){
            $con = Connection::getConn();

            $sql = "SELECT * FROM post WHERE id = :id";
            $sql = $con->prepare($sql);
            $sql->bindValue(":id", $id);
            $sql->execute();
            $result = $sql->fetchObject('post');
            
            if(!$result){
                throw new Exception("Postagem não encontrada");
            }

            return $result;
        }

        public static function insert($postData){
            if(empty($postData['postTitle']) or empty($postData['postContent'])){
                throw new Exception("O título e o conteúdo não podem ser vazios");
            }

            $conn = Connection::getConn();
            $sql = 'INSERT INTO post (title, content) VALUES (:title, :content)';
            $sql = $conn->prepare($sql);
            $sql->bindValue(':title', $postData['postTitle']);
            $sql->bindValue(':content', $postData['postContent']);
            $sql->execute();
        }

        public static function delete($id){
            $conn = Connection::getConn();
            $sql = 'DELETE FROM post WHERE id = :id';
            $sql = $conn->prepare($sql);
            $sql->bindValue(':id', $id);
            $sql->execute();
        }

        public static function update($postData){
            if(empty($postData['postTitle']) or empty($postData['postContent'])){
                throw new Exception("O título e o conteúdo não podem ser vazios");
            }
            $conn = Connection::getConn();
            $sql = 'UPDATE post SET title = :title, content = :content WHERE id = :id';
            $sql = $conn->prepare($sql);
            $sql->bindValue(':title', $postData['postTitle']);
            $sql->bindValue(':content', $postData['postContent']);
            $sql->bindValue(':id', $postData['postId']);
            $sql->execute();
        }
    }