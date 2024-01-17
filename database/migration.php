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
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

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

    // projectsテーブルの作成
    $pdo->exec('
        CREATE TABLE IF NOT EXISTS projects (
            project_id INT AUTO_INCREMENT PRIMARY KEY,
            project_name VARCHAR(255) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )
    ');

    // timecardsテーブルの作成
    $pdo->exec('
        CREATE TABLE IF NOT EXISTS timecards (
            timecard_id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT,
            project_id INT,
            date DATE,
            start_time TIME,
            end_time TIME,
            description TEXT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES users (user_id),
            FOREIGN KEY (project_id) REFERENCES projects (project_id)
        )
    ');

    // vacationsテーブルの作成
    $pdo->exec('
        CREATE TABLE IF NOT EXISTS vacations (
            vacation_id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT,
            vacation_type VARCHAR(255) NOT NULL,
            start_date DATE,
            end_date DATE,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES users (user_id)
        )
    ');

    // eventsテーブルの作成
    $pdo->exec('
        CREATE TABLE IF NOT EXISTS events (
            event_id INT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(255) NOT NULL,
            start DATETIME NOT NULL,
            end DATETIME,
            all_day BOOLEAN DEFAULT FALSE,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )
    ');

    echo "テーブルが作成されました。\n";
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>