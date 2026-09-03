<?php
require_once '../config/db_connection.php';
require_once '../database/task_data.php';

$taskId = filter_input(INPUT_POST, "id");
$title = filter_input(INPUT_POST, "title");
$type = filter_input(INPUT_POST, "type");
$description = filter_input(INPUT_POST, "description");
$start_time = filter_input(INPUT_POST, "start_time");
$end_time = filter_input(INPUT_POST, "end_time");

if ($type === "todo") {
    $end_time = null;
}else{
print_r($start_time);
print_r($end_time);
}

try{
    $is_success = updateTask($pdo, $taskId, $title, $type, $description, $start_time, $end_time);
    if ($is_success) {
        $pdo->commit();
        header("Location: ../dashboard.php");
        exit;
    }
}catch (PDOException $e){
    $pdo->rollBack();
    echo ("dbError " . $e);
    die("Connection failed: " . $e->getMessage());
}
?>