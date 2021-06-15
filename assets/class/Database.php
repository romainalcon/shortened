<?php

class Database
{

    /**
     * @var PDO
     */
    private static PDO $instance;

    public static function getInstance(): PDO
    {
        if (is_null(self::$instance)) {
            $config = include ($_SERVER['DOCUMENT_ROOT'] . "/config.php");
            self::$instance = new PDO("mysql:dbname={$config['dbname']};host={$config['dbhost']};charset=utf8", $config['dbuser'], $config['dbpass']);
        }
        return self::$instance;
    }

}