<?php
require_once './query.php';

$store_id = 1;

// データベースからイベントデータを取得
$query = "SELECT * FROM events WHERE store_id = $store_id";
$events = executeQuery($query);

// イベントのタイトルをユーザーIDからユーザー名に置き換える
foreach ($events as &$event) {
    $user_id = $event['user_id'];
    $query = "SELECT username FROM users WHERE user_id = $user_id";
    $result = executeQuery($query);
    $username = $result[0]['username'];
    $event['title'] = $username;
}


// JSONで出力
header('Content-Type: application/json');
echo json_encode($events);
?>