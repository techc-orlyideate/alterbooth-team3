<?php

// 自動で読み込み
require '../vendor/autoload.php';

// .envファイルを使用するための準備
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

$host = $_ENV["HOST"];
$db = $_ENV["DB"];
$user = $_ENV["USER"];
$pass = '';

try {
    // データベースに接続
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // データベースが存在しない場合、新たに作成
    if ($e->getCode() == 1049) {
        $pdo = new PDO("mysql:host=$host;", $user, $pass);
        $pdo->exec("CREATE DATABASE `$db`;USE `$db`;");
    } else {
        die("Error: " . $e->getMessage());
    }
}

try {
    // usersテーブルの作成
    $pdo->exec('
        CREATE TABLE IF NOT EXISTS users (
            user_id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(255) NOT NULL,
            password VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )
    ');

    // eventsテーブルの作成
    $pdo->exec('
        CREATE TABLE IF NOT EXISTS events (
            event_id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT,
            FOREIGN KEY (user_id) REFERENCES users (user_id),
            store_id INT,
            title VARCHAR(255) NOT NULL,
            start DATETIME NOT NULL,
            end DATETIME,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )
    ');

    // rootユーザーのレコードを挿入
    $pdo->exec("
        INSERT INTO users (username, password, email)
        VALUES ('root', 'root', 'root')
    ");

    echo "テーブルが作成されました。\n";
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>