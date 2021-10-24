<?php

require_once __DIR__ . "/../util/Database.php";
require_once __DIR__ . "/../entities/User.php";


class UserModel
{

    private $db_conn;

    public function __construct()
    {
        $this->db_conn = Database::getConnection();
    }

    public function create($user)
    {
        $insert_sql = "INSERT INTO `user`(`username`, `password`, `role`) " .
            "VALUES ('" . $user->getUsername() . "','" . $user->getPassword() . "','" . $user->getRole() . "')";

        if ($this->db_conn->query($insert_sql) === true) {
            return true;
        } else {
            echo "Error: " . $insert_sql . "<br>" . $this->db_conn->error;
            return false;
        }
    }

    public function update($user)
    {
        $update_sql = "UPDATE `user` SET `username`='" . $user->getUsername() . "',`password`='" . $user->getPassword() . "',`role`='" . $user->getRole() . "' WHERE `id`=" . $user->getId();

        if ($this->db_conn->query($update_sql) === true) {
            return true;
        } else {
            echo "Error: " . $update_sql . "<br>" . $this->db_conn->error;
            return false;
        }
    }

    public function delete($user)
    {
        $delete_sql = "DELETE FROM `user` WHERE `id`=" . $user->getId();

        if ($this->db_conn->query($delete_sql) === true) {
            return true;
        } else {
            echo "Error: " . $delete_sql . "<br>" . $this->db_conn->error;
            return false;
        }

    }

    public function findAll()
    {
        $select_sql = "SELECT * FROM `user`";
        $result = $this->db_conn->query($select_sql);

        if ($result->num_rows > 0) {
            $users = [];
            while ($row = $result->fetch_assoc()) {
                array_push($users, (new User($row["id"], $row["username"], $row["password"], $row["role"]))->toAssoc());
            }
            return $users;

        } else {
            return new User();
        }
    }

    public function findById($id)
    {
        $select_sql = "SELECT * FROM `user` WHERE `id` = " . $id;
        $result = $this->db_conn->query($select_sql);

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            return new User($row["id"], $row["username"], $row["password"], $row["role"]);

        } else {
            return new User();
        }
    }

    public function findByUsernameAndPassword($username, $password)
    {
        $select_sql = "SELECT * FROM `user` WHERE  `username`='" . $username . "' AND `password`='" . $password . "'";
        $result = $this->db_conn->query($select_sql);

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            return new User($row["id"], $row["username"], $row["password"], $row["role"]);

        } else {
            return new User();
        }
    }

}

