<?php
// DB接続などの共通処理を含むconfig.phpを作成することが一般的です。

// 仮のDB接続情報
$host = 'localhost';
$db = 'attendance_tool';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

// 休暇一覧の取得
$stmt = $pdo->query("SELECT * FROM vacations");
$vacations = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>休暇管理</title>
</head>
<body>
    <h2>休暇管理</h2>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>ユーザーID</th>
                <th>休暇の種類</th>
                <th>開始日</th>
                <th>終了日</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($vacations as $vacation): ?>
                <tr>
                    <td><?= $vacation['vacation_id'] ?></td>
                    <td><?= $vacation['user_id'] ?></td>
                    <td><?= $vacation['vacation_type'] ?></td>
                    <td><?= $vacation['start_date'] ?></td>
                    <td><?= $vacation['end_date'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
