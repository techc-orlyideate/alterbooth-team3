<?php
$dsn = "mysql:host=localhost";
$user = "root";
$password = "";

try {
    $dbh = new PDO($dsn, $user, $password);

    $dbh->exec("CREATE DATABASE IF NOT EXISTS attendance_tool");

    echo "新しいデータベースattendance_toolを作成しました。";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
