<?php

class Baza
{
    const server = "localhost";
    const username = "WebDiP2019x113";
    const password = "admin_HKGP";
    const db_name = "WebDiP2019x113";
    private static $conn = null;

    static function connect()
    {
        self::$conn = new mysqli(self::server, self::username, self::password, self::db_name);
        if (self::$conn->connect_error) {
            die("Connection failed: " . self::$conn->connect_error);
        }
        self::$conn->set_charset("utf8");
    }

    static function select($query)
    {
        if (self::$conn == null) {
            die("Niste spojeni na bazu!");
        }

        $result = self::$conn->query($query);

        if ($result->num_rows > 0) {
            return $result;
        } else {
            return null;
        }
    }

    static function query($query)
    {
        if (self::$conn == null) {
            die("Niste spojeni na bazu!");
            return false;
        }

        self::$conn->query($query);
        return true;
    }

    static function disconnect()
    {
        self::$conn->close();
    }
}