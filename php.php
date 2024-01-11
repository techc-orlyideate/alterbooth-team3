<?php
$servername = "localhost";
$username = "ユーザー名";
$password = "パスワード";
$dbname = "データベース名";

// データベースへの接続
$conn = new mysqli($servername, $username, $password, $dbname);

// 接続エラーの確認
if ($conn->connect_error) {
    die("データベースへの接続に失敗しました: " . $conn->connect_error);
}
?>
<?php
// フォームが送信された場合
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $employee_id = $_POST["employee_id"];
    $check_in_time = $_POST["check_in_time"];
    $check_out_time = $_POST["check_out_time"];

    // データベースの更新クエリを実行
    $sql = "UPDATE attendance SET check_in_time = '$check_in_time', check_out_time = '$check_out_time' WHERE employee_id = $employee_id";

    if ($conn->query($sql) === TRUE) {
        echo "出退勤データが更新されました。";
    } else {
        echo "エラー: " . $conn->error;
    }
}

// 従業員の一覧を取得
$sql = "SELECT employee_id, employee_name FROM employees";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // 従業員の一覧を表示するフォーム
    echo "<form method='post' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "'>";
    echo "従業員を選択: <select name='employee_id'>";
    while ($row = $result->fetch_assoc()) {
        echo "<option value='" . $row["employee_id"] . "'>" . $row["employee_name"] . "</option>";
    }
    echo "</select><br>";
    echo "出勤時間: <input type='text' name='check_in_time'><br>";
    echo "退勤時間: <input type='text' name='check_out_time'><br>";
    echo "<input type='submit' value='更新'>";
    echo "</form>";
} else {
    echo "従業員が見つかりませんでした。";
}

$conn->close();
?>

</body>
</html>
