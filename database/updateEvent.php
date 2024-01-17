<?php
require_once 'query.php';

// POSTリクエストからデータを取得
$data = json_decode(file_get_contents('php://input'), true);
$eventId = $data['id'];
$start = $data['start'];
$end = $data['end'];

// データベースを更新
$query = "UPDATE events SET start = '$start', end = '$end' WHERE id = $eventId";
executeQuery($query);
?>