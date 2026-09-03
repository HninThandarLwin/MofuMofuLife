<?php
require_once __DIR__ . '/../config/db_connection.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

try {
    $create_user = "INSERT INTO users (name, email, password) VALUES (:name, :email, :password)";

    $raw_pws = filter_input(INPUT_POST, "password");
    $check_pws = filter_input(INPUT_POST, "checkPassword");
    $name = filter_input(INPUT_POST, "u_name");
    $email = filter_input(INPUT_POST, "email");

    if ($raw_pws != $check_pws) {
        $_SESSION['checkPwsError'] = "パスワードが一致しません！";
        header("Location: register.php");
        exit;
    }

    if (!$raw_pws || !$name || !$email) {
        $_SESSION['registerError'] = "全部入力してください！";
        header('Location: ./register.php');
        exit;
    }
    $pws = password_hash($raw_pws, PASSWORD_DEFAULT);

    $stmt = null;
    $stmt = $pdo->prepare($create_user);
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->bindParam(':password', $pws, PDO::PARAM_STR);
    
    $is_success = $stmt->execute();
    
    if ($is_success) {
        if ($pdo->inTransaction()) {
            $pdo->commit();
        }
        $_SESSION['registerSuccess'] = "登録が完了しました！ログインしてください。";
        header("Location: ../login.php");
        exit;
    }
}catch(PDOException $e){
    $_SESSION['registerError'] = "新規登録失敗しました！メールがすでに登録されてます！";
    header('Location: ../login.php');
    exit;
}
?>