<?php
require_once '../config/db_connection.php';
require_once '../includes/SESSION.php';
/** @var int $userId */
require_once '../database/task_data.php';

$title = filter_input(INPUT_POST, "title");
$type = filter_input(INPUT_POST, "type");
$description = filter_input(INPUT_POST, "description");
$start_time = filter_input(INPUT_POST, "start_time");
$end_time = filter_input(INPUT_POST, "end_time");
$date = filter_input(INPUT_POST, "date");

if(empty($start_time) || empty($end_time)){
    $start_time = null;
    $end_time = null;
}

if ($type === "todo") {
    // Save the creation date
    $start_time = date('Y-m-d H:i:s');
    $end_time = null;
} else {
    if ($start_time) {
        $start_time = "$date $start_time:00";
    }

    if ($end_time) {
        $end_time = "$date $end_time:00";
    }
}

try {
    $pdo->beginTransaction();
    $is_success = addTasks($pdo, $userId, $title, $type, $description, $start_time, $end_time);
    if ($is_success) {
        $pdo->commit();
        header("Location: ../index.php");
        exit;
    }
} catch (PDOException $e) {
    $pdo->rollBack();
    echo ("dbError " . $e);
    die("Connection failed: " . $e->getMessage());
}