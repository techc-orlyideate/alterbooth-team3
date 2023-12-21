<?php

$dsn = "mysql:host=localhost;dbname=attendance_tool";
$user = "root";
$password = "";

try {
    $dbh = new PDO($dsn, $user, $password);

    $dbh->exec("CREATE TABLE IF NOT EXISTS shift (
        id INT AUTO_INCREMENT PRIMARY KEY,
        kakutei_shit datetime NOT NULL
    )");

    echo "作成しました。";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>