<?php
require_once './query.php';

// データベースからイベントデータを取得
$query = "SELECT * FROM events";
$events = executeQuery($query);

// JSONで出力
header('Content-Type: application/json');
echo json_encode($events);
?>