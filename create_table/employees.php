<?php
$dsn = "mysql:host=localhost;dbname=attendance_tool";
$user = "root";
$password = "";

try {
    $dbh = new PDO($dsn, $user, $password);

    $dbh->exec("CREATE TABLE IF NOT EXISTS employees (
        id INT AUTO_INCREMENT PRIMARY KEY,
        employee_name VARCHAR(50) NOT NULL,
        employee_mail VARCHAR(50) NOT NULL,
        password VARCHAR(255) NOT NULL
    )");

    echo "データベースattendance_toolにemployeesテーブルを作成しました。";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>