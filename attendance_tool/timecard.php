<?php
// 自動でライブラリ読み込み
require './vendor/autoload.php';

// .envを使用する
Dotenv\Dotenv::createImmutable(__DIR__)->load();

$host = $_ENV["HOST"];
$db = $_ENV["DB"]; // データベース名を指定
$user = $_ENV["USER"];
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

// タイムカード一覧の取得
$stmt = $pdo->query("SELECT * FROM timecards");
$timecards = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>タイムカード管理</title>
</head>
<body>
    <h2>タイムカード管理</h2>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>ユーザーID</th>
                <th>プロジェクトID</th>
                <th>日付</th>
                <th>出勤時間</th>
                <th>退勤時間</th>
                <th>作業内容</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($timecards as $timecard): ?>
                <tr>
                    <td><?= $timecard['timecard_id'] ?></td>
                    <td><?= $timecard['user_id'] ?></td>
                    <td><?= $timecard['project_id'] ?></td>
                    <td><?= $timecard['date'] ?></td>
                    <td><?= $timecard['start_time'] ?></td>
                    <td><?= $timecard['end_time'] ?></td>
                    <td><?= $timecard['description'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
