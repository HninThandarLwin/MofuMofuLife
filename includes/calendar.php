<?php
require_once './config/db_connection.php';
require_once './includes/SESSION.php';

$currentPage = 'calendar';

$year = filter_input(INPUT_POST,'year',FILTER_VALIDATE_INT);
$month = filter_input(INPUT_POST,'month',FILTER_VALIDATE_INT);

if(!$year){
    $year = date('Y');
}

if(!$month){
    $month = date('n');
}

$tasks = getTaskByMonth($pdo,$userId,$year,$month);
// print_r($year . $month);
// print_r($tasks);
$tasksByDate = [];

foreach($tasks as $task){

    $date = date('Y-m-d',strtotime($task['start_time']));

    $tasksByDate[$date][] = $task;

}

$firstDay = date('w',strtotime("$year-$month-01"));

$daysInMonth = date('t',strtotime("$year-$month-01"));
?>