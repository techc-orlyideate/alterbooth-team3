<?php
// セッションを開始
session_start();

// ログインボタンが押されたかどうかを確認
if(isset($_POST["login"])) {
    // ユーザーが入力したユーザー名とパスワードを取得
    $email = $_POST["email"];
    $password = $_POST["password"];

    // データベースへの接続情報を設定
    $dsn = "mysql:host=localhost;dbname=attendance_tool";
    $user = "root";
    $pass = "";

    try {
        // PDOを使用してデータベースに接続
        $dbh = new PDO($dsn, $user, $pass);

        // ユーザー名に一致するユーザーを検索するSQLを準備
        $sql = "SELECT user_id, email, password FROM users WHERE email = :email";
        $stmt = $dbh->prepare($sql);

        // SQLを実行
        $stmt->execute(["email" => $email]);
        // 結果を取得
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // ユーザーが存在し、パスワードが一致するかどうかを確認
        if($email = "root" && password_verify($password, $user["password"])) {
            header("Location: http://localhost/alterbooth-team3/attendance_tool/calendar/business.html");
            exit;
        } elseif($user && password_verify($password, $user["password"])) {
            // ユーザー名をセッションに保存
            $_SESSION["user_id"] = $user["user_id"];
            // ログイン成功ページにリダイレクト
            header("Location: http://localhost/alterbooth-team3/attendance_tool/calendar/business.html");
            exit;
        } else {
            // ログイン失敗ページにリダイレクト
            header("Location: http://localhost/alterbooth-team3/login_system/view/failed.html");
        }
    } catch (PDOException $e) {
        // エラーメッセージを表示
        echo "Error: " . $e->getMessage();
    }
}
?>