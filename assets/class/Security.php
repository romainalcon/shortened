<?php

class Security
{

    private static int $rank;

    public static function isLogged(): bool
    {
        session_commit();
        session_start();
        $id = $_SESSION['uid'] ?? "";
        $token = $_SESSION['token'] ?? "";
        include_once $_SERVER['DOCUMENT_ROOT'] . '/assets/class/Database.php';
        $db = Database::getInstance();
        $statement = $db->prepare("SELECT username, password, rank FROM admin WHERE id = ?");
        $statement->execute([$id]);
        if ($statement->rowCount() != 1) return false;
        $result = $statement->fetch();
        self::$rank = $result['rank'];
        return password_verify($result['username'].$result['password'], $token);
    }

    public static function getRank(): int
    {
        return self::$rank;
    }

}