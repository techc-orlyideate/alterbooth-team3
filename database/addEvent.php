<?php
require_once 'query.php';

session_start();
$user_id = $_SESSION['user_id'];

// POSTリクエストからイベントデータを取得
$data = json_decode(file_get_contents('php://input'), true);
$title = $data['title'];
$start = $data['start'];
$end = $data['end'];

// DBにイベントデータを保存
$query = "INSERT INTO events (user_id, title, start, end) VALUES ('$user_id', '$title', '$start', '$end');";
executeQuery($query)
?>