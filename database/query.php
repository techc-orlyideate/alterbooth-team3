<?php
// 自動でライブラリ読み込み
require '../vendor/autoload.php';

// PDOを使って、SQLのクエリーを引数に渡すだけで、クエリーを実行してくれる関数を作成
function executeQuery($query) {
    // .envを使用する
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
    $dotenv->load();

    $host = $_ENV["HOST"];
    $db = $_ENV["DB"];
    $user = $_ENV["USER"];
    $pass = '';

    try {
        // PDOインスタンスを生成
        $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
        // クエリを実行
        $stmt = $pdo->prepare($query);
        $stmt->execute();

        if (stripos($query, 'SELECT') === 0) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    } catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
    }
}
?>