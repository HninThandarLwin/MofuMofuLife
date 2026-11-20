<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 「ログアウトする」ボタンが押された場合
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // セッションの中身をすべて削除
    $_SESSION = [];

    // セッションを完全に終了
    session_destroy();

    // ログイン画面へ移動
    header('Location: login.php?logout=success');
    exit;
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/logout.css">
    <title>ログアウト — モフモフLife</title>
</head>

<body>

    <main class="logout-page">
        <div class="logout-card">
            <div class="pet-icon">🐾</div>
            <h1>ログアウト</h1>
            <p>
                モフモフLifeから<br>
                ログアウトしますか？
            </p>

            <div class="logout-buttons">
                <a href="javascript:history.back()" class="cancel-button">
                    キャンセル
                </a>
                <form method="POST" action="logout.php">
                    <button type="submit" class="logout-button">
                        ログアウトする
                    </button>
                </form>
            </div>
        </div>
    </main>
</body>

</html>