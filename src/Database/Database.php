<?php

declare(strict_types=1);

namespace App\Database;

use PDO;

final class Database
{
    private static ?PDO $pdo = null;

    public static function getConnection(): PDO
    {
        if (self::$pdo === null) {
            $dsn = env('DATABASE_DSN', 'mysql:host=localhost;dbname=overconda;charset=utf8mb4');
            $user = env('DATABASE_USER', '');
            $pass = env('DATABASE_PASSWORD', '');
            self::$pdo = new PDO($dsn, $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
        }
        return self::$pdo;
    }

    public static function reset(): void
    {
        self::$pdo = null;
    }
}
