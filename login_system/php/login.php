<?php
// セッションを開始します
session_start();

// ログインボタンが押されたかどうかを確認します
if(isset($_POST["login"])) {
    // ユーザーが入力したユーザー名とパスワードを取得します
    $employee_mail = $_POST["employee_mail"];
    $password = $_POST["password"];

    // データベースへの接続情報を設定します
    $dsn = "mysql:host=localhost;dbname=attendance_tool";
    $user = "root";
    $pass = "";

    try {
        // PDOを使用してデータベースに接続します
        $dbh = new PDO($dsn, $user, $pass);

        // ユーザー名に一致するユーザーを検索するSQLを準備します
        $sql = "SELECT * FROM employees WHERE employee_mail = :employee_mail";
        $stmt = $dbh->prepare($sql);

        // SQLを実行します
        $stmt->execute(["employee_mail" => $employee_mail]);
        // 結果を取得します
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // ユーザーが存在し、パスワードが一致するかどうかを確認します
        if($user && password_verify($password, $user["password"])) {
            // ユーザー名をセッションに保存します
            $_SESSION["id"] = $user["id"];
            $_SESSION["employee_mail"] = $user["employee_mail"];
            $_SESSION["employee_name"] = $user["employee_name"];
            // ログイン成功ページにリダイレクトします
            header("Location: http://localhost/alterbooth-team3/attendance_tool/calendar/fullcalendar.html");
            exit;
        } else {
            // ログイン失敗ページにリダイレクトします
            header("Location: http://localhost/alterbooth-team3/login_system/view/failed.html");
        }
    } catch (PDOException $e) {
        // エラーメッセージを表示します
        echo "Error: " . $e->getMessage();
    }
}
?>