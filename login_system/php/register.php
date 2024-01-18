<?php

require '../../vendor/autoload.php';
// .envを使用する
Dotenv\Dotenv::createImmutable(__DIR__ . "/../..")->load();

if(isset($_POST["register"])) {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    $host=$_ENV['HOST'];
    $db = $_ENV["DB"];
    $user = $_ENV["USER"];
    $pass = $_ENV["PASS"];

    try {
        $dbh = new PDO("mysql:host=$host;dbname=$db", $user, $pass);

        // ユーザー名が既に存在するかどうかを確認
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $dbh->prepare($sql);
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if($user) {
            echo "<h1>このメールアドレスは既に使用されています。</h1><br>";
        } else {
            $sql = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
            $stmt = $dbh->prepare($sql);

            $params = array(':username' => $name, ':email' => $email, ':password' => $password);

            $stmt->execute($params);

            echo "<h1>登録が完了しました。</h1><br>";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>登録が完了</title>
</head>
<body>
    <a href="http://localhost/alterbooth-team3/login_system/view/login.html">ログイン画面</a><br>
    <a href="http://localhost/alterbooth-team3/login_system/view/register.html">ユーザー登録</a>
</body>
</html>