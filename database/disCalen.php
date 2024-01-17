<?php
require_once './query.php';

session_start();
$user_id = $_SESSION['user_id'];

// データベースからイベントデータを取得
$query = "SELECT * FROM events WHERE user_id = $user_id";
$events = executeQuery($query);

// JSONで出力
header('Content-Type: application/json');
echo json_encode($events);
?>