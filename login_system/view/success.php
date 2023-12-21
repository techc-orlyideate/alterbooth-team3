<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン成功</title>
</head>
<body>
    <h1>ログインしました</h1>
    <?php
    session_start();
    echo "ユーザー名：" . $_SESSION["employee_name"] . "<br>メールアドレス：" . $_SESSION["employee_mail"];
    ?>
</body>
</html>