<?php
if(isset($_POST["register"])) {
    $employee_name = $_POST["employee_name"];
    $employee_mail = $_POST["employee_mail"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    $dsn = "mysql:host=localhost;dbname=attendance_tool";
    $user = "root";
    $pass = "";

    try {
        $dbh = new PDO($dsn, $user, $pass);

        // ユーザー名が既に存在するかどうかを確認
        $sql = "SELECT * FROM employees WHERE employee_mail = :employee_mail";
        $stmt = $dbh->prepare($sql);
        $stmt->execute(['employee_mail' => $employee_mail]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if($user) {
            echo "<h1>このメールアドレスは既に使用されています。</h1><br>";
        } else {
            $sql = "INSERT INTO employees (employee_name, employee_mail, password) VALUES (:employee_name, :employee_mail, :password)";
            $stmt = $dbh->prepare($sql);

            $params = array(':employee_name' => $employee_name, ':employee_mail' => $employee_mail, ':password' => $password);

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