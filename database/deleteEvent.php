<?php
require_once 'query.php';

// POSTリクエストからイベントIDを取得
$data = json_decode(file_get_contents('php://input'), true);
$eventId = $data['id'];

// データベースからイベントを削除
$query = "DELETE FROM events WHERE id = $eventId";
executeQuery($query);
?>