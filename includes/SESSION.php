<?php
define('BASE_URL', '/AuraDev');
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: " . BASE_URL . "/login.php");
    exit;
}

$userId = $_SESSION['user_id'];

/*************************************
for shop.php
**************************************/
$toast = $_SESSION['toast'] ?? null;
unset($_SESSION['toast']);

?>