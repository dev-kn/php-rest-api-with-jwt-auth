<?php

require_once __DIR__ . "/../config/Constants.php";

class Database
{
    public static function getConnection()
    {
        $db_conn = new mysqli(
            Constants::DB["HOSTNAME"] . ':' . Constants::DB["PORT"],
            Constants::DB["USERNAME"],
            Constants::DB["PASSWORD"],
            Constants::DB["DATABASE"]
        );

        if ($db_conn->connect_error) {
            die("Connection failed: " . $db_conn->connect_error);
        }

        return $db_conn;
    }
}
