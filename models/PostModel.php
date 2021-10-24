<?php

require_once __DIR__."/../util/Database.php";
require_once __DIR__."/../entities/Post.php";


class PostModel{

    private $db_conn;

    public function __construct()
    {
        $this->db_conn = Database::getConnection();
    }

    public function create($post){

        $insert_sql = "INSERT INTO `post`(`category`, `title`, `body`, `author`) ".
        "VALUES ('".$post->getCategory()."','".$post->getTitle()."','".$post->getBody()."','".$post->getAuthor()."')";
    
        if ($this->db_conn->query($insert_sql) === true) {
          return true;
        } else {
          echo "Error: " . $insert_sql . "<br>" . $this->db_conn->error;
          return false;
        }
        
    }

    public function update($post){

      $update_sql = "UPDATE `post` SET `category`='" . $post->getCategory() . "',`title`='" . $post->getTitle() . "',`body`='" . $post->getBody() . "',`author`='" . $post->getAuthor() . "' WHERE `id`=" . $post->getId();
        
      if ($this->db_conn->query($update_sql) === true) {
        return true;
      } else {
        echo "Error: " . $update_sql . "<br>" . $this->db_conn->error;
        return false;
      }
    }

    public function delete($post){

        $delete_sql = "DELETE FROM `post` WHERE `id`=".$post->getId();
    
        if ($this->db_conn->query($delete_sql) === true) {
          return true;
        } else {
          echo "Error: " . $delete_sql . "<br>" . $this->db_conn->error;
          return false;
        }
        
    }

    public function findAll(){

        $select_sql = "SELECT * FROM `post`";
        $result = $this->db_conn->query($select_sql);

        if ($result->num_rows > 0) {
            $posts = [];
            while($row = $result->fetch_assoc()) {
              array_push($posts,(new Post($row["id"],$row["category"],$row["title"],$row["body"],$row["author"],$row["create_at"]))->toAssoc());
            }
            return $posts;
      
          } else {
            return new Post();
          }
        
    }

    public function findById($id){

        $select_sql = "SELECT * FROM `post` WHERE `id` = ".$id;
        $result = $this->db_conn->query($select_sql);

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            return new Post($row["id"],$row["category"],$row["title"],$row["body"],$row["author"],$row["create_at"]);
      
          } else {
            return new Post();
          }
        
    }

    public function findByTitle($title){

        $select_sql = "SELECT * FROM `post` WHERE `title` like '%" . $title . "%'";
        $result = $this->db_conn->query($select_sql);

        if ($result->num_rows > 0) {
          $posts = [];
          while($row = $result->fetch_assoc()) {
            array_push($posts,(new Post($row["id"],$row["category"],$row["title"],$row["body"],$row["author"],$row["create_at"]))->toAssoc());
          }
          return $posts;

          } else {
            return null;
          }

    }

}

