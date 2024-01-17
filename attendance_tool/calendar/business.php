<?php
// 自動で読み込み
require '../../vendor/autoload.php';

// .envファイルを使用するための準備
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../..');
$dotenv->load();

// データベース接続情報
$host = $_ENV["HOST"];
$db = $_ENV["DB"];
$user = $_ENV["USER"];
$pass = '';
$charset = 'utf8mb4';

// PDOインスタンスを作成
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$opt = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
$pdo = new PDO($dsn, $user, $pass, $opt);

// usersテーブルからusernameを取得
$sql = "SELECT username FROM users WHERE username != 'root'";
$stmt = $pdo->query($sql);
$usernames = $stmt->fetchAll(PDO::FETCH_COLUMN);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar/index.global.min.js'></script>
	<script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.10.0/locales-all.min.js'></script>

	<script>
        document.addEventListener('DOMContentLoaded', function() {
            const calendarEl = document.getElementById('calendar')
            const calendar = new FullCalendar.Calendar(calendarEl, {
                contentHeight: 900,
				headerToolbar: {
					left: 'prev, next, today',
					center: 'title',
					right: 'dayGridMonth,timeGridWeek,timeGridDay'
				},
				initialView: 'dayGridMonth',
				locale: "ja",
                events: '../../database/disShift.php',
				editable: true,
                droppable: true, // 外部イベントのドロップを許可
                drop: function(info) {
                    // ドロップされたイベントの情報を取得し、カレンダーにイベントを追加
                    const title = info.draggedEl.textContent
                    const date = new Date(info.dateStr)
					const year = date.getFullYear()
					const month = ("00" + (date.getMonth() + 1)).slice(-2)
					const day = ("00" + date.getDate()).slice(-2)
					const hour = ("00" + date.getHours()).slice(-2)
					const minute = ("00" + date.getMinutes()).slice(-2)
					const dateTime = `${year}-${month}-${day}T${hour}:${minute}`

                    // POSTリクエスト
                    fetch('../../database/addShift.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({ title: title, start: dateTime})
                    })

                    location.reload()
                },
				eventResize: function(info) {
					// イベントの時間が調整されたときの処理
					const eventId = info.event.id
					const start = toJST(info.event.start)
					const end = info.event.end ? toJST(info.event.end) : null

					// POSTリクエスト
					fetch('../../database/updateEvent.php', {
						method: 'POST',
						headers: {
							'Content-Type': 'application/json'
						},
						body: JSON.stringify({ id: eventId, start: start, end: end })
					})
				},
				eventDrop: function(info) {
					// イベントがドラッグ&ドロップされたときの処理
					const eventId = info.event.id
					const start = toJST(info.event.start)
					const end = info.event.end ? toJST(info.event.end) : null

					// POSTリクエスト
					fetch('../../database/updateEvent.php', {
						method: 'POST',
						headers: {
							'Content-Type': 'application/json'
						},
						body: JSON.stringify({ id: eventId, start: start, end: end })
					})
				},
				eventClick: function(info) {
					// 削除の確認
					if (confirm('このイベントを削除しますか？')) {
						// イベントの削除
						info.event.remove()

						// サーバーにPOSTリクエストを送信
						fetch('../../database/deleteEvent.php', {
							method: 'POST',
							headers: {
								'Content-Type': 'application/json'
							},
							body: JSON.stringify({ id: info.event.id }) // イベントIDを送信
						})
					}
				}
            })
            calendar.render()
            // 外部イベントをドラッグ可能にする
            new FullCalendar.Draggable(document.getElementById('external-events'), {
                itemSelector: '.fc-event',
                eventData: function(eventEl) {
                    return { title: eventEl.textContent }
                }
            })
        })

        // 日付と時間をJSTに変換
		function toJST(date) {
			const year = date.getFullYear()
			const month = ("00" + (date.getMonth() + 1)).slice(-2)
			const day = ("00" + date.getDate()).slice(-2)
			const hour = ("00" + date.getHours()).slice(-2)
			const minute = ("00" + date.getMinutes()).slice(-2)
			return `${year}-${month}-${day}T${hour}:${minute}`
		}
    </script>
    <style>
        /* サイドパネルとカレンダーのスタイルを設定 */
        #external-events {
            width: 200px;
            padding: 10px;
            float: left;
            margin-right: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.15);
        }
        #calendar {
            margin-left: 220px;
        }
    </style>
    <title>シフトカレンダー</title>
</head>
<body>
    <div id='external-events'>
        <h4>ドラッグ可能なイベント</h4>
        <?php foreach ($usernames as $username): ?>
            <div class='fc-event'><?php echo htmlspecialchars($username, ENT_QUOTES, 'UTF-8'); ?></div>
        <?php endforeach; ?>
    </div>

    <div id='calendar'></div>
</body>
</html>