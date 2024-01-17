<?php
require_once 'query.php';

// POSTリクエストからイベントデータを取得
$data = json_decode(file_get_contents('php://input'), true);
$title = $data['title'];
$start = $data['start'];
$end = $data['end'];

// DBにイベントデータを保存
$query = "INSERT INTO events (title, start, end) VALUES ('$title', '$start', '$end');";
executeQuery($query)
?>