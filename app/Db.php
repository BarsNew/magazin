<?php

namespace App;

abstract class DB 
{
    static $db = false;

    static function connect() 
    {
        try {
            self::$db = new \PDO('mysql:dbname=' . DB_NAME . ';host=' . DB_HOST . ';', DB_USER, DB_PASSWORD);
        } catch (\PDOException $PDO_error) {
            die('DB ERROR: ' . $PDO_error->getMessage());
        }

        return self::$db;
    }

    static function query(
        $table, 
        $fields = '*',
        $where = '',
        $sort = ['', 'ASC']
    )
    {
        $sql = "SELECT " . $fields . " FROM `" . $table . "`";

        if (!empty($where)) $sql .= ' WHERE ' . $where;

        if (!empty($sort[0]) && !empty($sort[1])) {
            $sql .= ' ORDER BY ' . $sort[0] . ' ' . $sort[1];
        }

        $result = self::$db->query($sql);

        return $result->fetchAll();
    }
}