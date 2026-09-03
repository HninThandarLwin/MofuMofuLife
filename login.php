<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$emailError = $_SESSION['emailError'] ?? "";
$passwordError = $_SESSION['passwordError'] ?? "";

$registerError = $_SESSION['registerError'] ?? "";
$checkPwsError = $_SESSION['checkPwsError'] ?? "";
$hasRegisterError = !empty($registerError);
$registerSuccess = $_SESSION['registerSuccess'] ?? "";


// clear after reading
unset($_SESSION['emailError']);
unset($_SESSION['passwordError']);
unset($_SESSION['registerError']);
unset($_SESSION['checkPwsError']);
unset($_SESSION['registerSuccess']);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>モフモフLife</title>
    <link rel="stylesheet" href="./css/style.css">
    <script src="./js/script.js" defer></script>
</head>
<body>

<div class="container">

    <div class="login-card">

        <div class="logo">🐾</div>
        <h1>モフモフLife</h1>
        <p class="subtitle">ペットと一緒に予定を管理しよう</p>

        <p class="error" id="loginError"><?= $registerSuccess ?></p>
        <div class="tab-area">
            <button id="loginTab" class="tab-btn active" onclick="showLogin()">
                ログイン
            </button>

            <button id="signupTab" class="tab-btn" onclick="showSignup()">
                新規登録
            </button>
        </div>

        <!-- Login -->
        <form id="loginForm" action="./includes/login_logic.php" method="post" novalidate>

            <p class="success" id="registerSuccess"><?= $registerSuccess ?></p>
            <label>メールアドレス</label>
            <input type="email" name="email" id="loginEmail">
            <p class="error" id="emailError"><?= $emailError ?></p>

            <label>パスワード</label>
            <input type="password" name="password" id="loginPassword">
            <p class="error" id="passwordError"><?= $passwordError ?></p>

            <button class="main-btn">
                ログイン
            </button>

        </form>

        <!-- Signup -->
        <form id="signupForm" style="display:none;" action="./includes/register.php" method="post" novalidate>

            <p class="error" id="registerError"><?= $registerError ?></p>
            <label>ユーザー名</label>
            <input type="text" name="u_name" id="signupName">

            <label>メールアドレス</label>
            <input type="email" name="email" id="signupEmail">

            <label>パスワード</label>
            <input type="password" name="password" id="signupPassword">

            <p class="error" id="checkPwsError"><?= $checkPwsError ?></p>
            <label>パスワード確認</label>
            <input type="password" name="checkPassword" id="checkPassword">

            <button class="main-btn" >
                新規登録
            </button>

        </form>

    </div>

</div>
<script>
    const hasRegisterError = <?= json_encode($hasRegisterError) ?>;
</script>
</body>
</html>