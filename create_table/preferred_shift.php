<?php
$dsn = "mysql:host=localhost;dbname=attendance_tool";
$user = "root";
$password = "";

try {
    $dbh = new PDO($dsn, $user, $password);

    $dbh->exec("CREATE TABLE IF NOT EXISTS shift_requests (
        id INT AUTO_INCREMENT PRIMARY KEY,
        desired_shift DATETIME NOT NULL
    )");

    echo "データベースattendance_toolにshift_requestsテーブルを作成しました。";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>