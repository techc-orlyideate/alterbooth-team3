<?php
require_once './query.php';

session_start();
$user_id = $_SESSION['user_id'];

// データベースからイベントデータを取得
$query = "SELECT * FROM events WHERE user_id = $user_id";
$events = executeQuery($query);

foreach ($events as &$event) {
    if ($event['store_id'] !== null) {
        $event['editable'] = false;
        $event['color'] = "rgb(196, 91, 83)";
    }
}

// JSONで出力
header('Content-Type: application/json');
echo json_encode($events);
?>