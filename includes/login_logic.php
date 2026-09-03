<?php
require_once __DIR__ . '/../config/db_connection.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
try {
    $sql_user = "SELECT * FROM users WHERE email = :email";
    
    $u_email = filter_input(INPUT_POST, "email") ;
    $password = $_POST['password'];

    $stmt = null;
    $stmt = $pdo->prepare($sql_user);
    $stmt->bindParam(':email', $u_email, PDO::PARAM_STR);
    
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        $_SESSION['emailError'] = "メールが見つかりません";
        header("Location: ../login.php");
        exit;        
    }else if(password_verify($password, $user["password"])){
        // login success
        $_SESSION['user_id'] = $user['id'];
        header('Location: ../index.php');
        exit;
    }else {
        $_SESSION['passwordError'] = "パスワードが間違っています";
        header("Location: ../login.php");
        exit;
    }

} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

?>
