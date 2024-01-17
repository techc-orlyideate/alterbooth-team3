<?php
require_once 'query.php';

$store_id = 1;

// POSTリクエストからイベントデータを取得
$data = json_decode(file_get_contents('php://input'), true);
$title = $data['title'];
$start = $data['start'];
// 変数titleと一致するusernameを持つユーザーのIDを取得
$query = "SELECT user_id FROM users WHERE username = '$title';";
$result = executeQuery($query);
$user_id = $result[0]['user_id'];

$title = "シフト";

// DBにイベントデータを保存
$query = "INSERT INTO events (user_id, store_id, title, start, end) VALUES ('$user_id', '$store_id', '$title', '$start', '$start');";
executeQuery($query);
?>