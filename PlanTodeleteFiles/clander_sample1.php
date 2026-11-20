<?php
require_once './config/db_connection.php';
require_once './database/task_data.php';
require_once './includes/calendar.php';
require_once './includes/SESSION.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
$currentPage = 'calendar';

$prevYear = $year;
$prevMonth = $month - 1;

if ($prevMonth == 0) {
  $prevMonth = 12;
  $prevYear--;
}

$nextYear = $year;
$nextMonth = $month + 1;

if ($nextMonth == 13) {
  $nextMonth = 1;
  $nextYear++;
}



?>
<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="css/common.css">
  <link rel="stylesheet" href="css/calendar.css">
  <title>カレンダー — モフモフLife</title>
</head>

<body>
  <!-- sidebar -->
  <?php require_once './includes/nav.php'; ?>

  <main class="main">
    <section class="page">
      <div class="page-header">
        <h1 class="page-title">カレンダー</h1>

        <div class="cal-nav">

          <a href="calendar.php?year=<?= $prevYear ?>&month=<?= $prevMonth ?>">
            ‹
          </a>

          <span class="cal-month-label">
            <?= $year ?>年 <?= $month ?>月
          </span>

          <a href="calendar.php?year=<?= $nextYear ?>&month=<?= $nextMonth ?>">
            ›
          </a>

        </div>
        <form id="calendarForm" action="./includes/task_load.php" method="post">
          <input type="hidden" name="year" id="yearInput">
          <input type="hidden" name="month" id="monthInput">
        </form>
      </div>
      <div class="calendar-grid" id="calendarGrid"></div>
    </section>
  </main>

  <!-- モーダル -->
  <div id="eventModal" class="modal" style="display:none;">
    <div class="event-popup">
      <h2 id="modalHeader"></h2>

      <form action="./includes/task_create.php" method="POST">
        <input type="hidden" name="date" id="selectedDate">

        <span class="required">*required</span>
        <input type="text" name="title" placeholder="タイトル" required>

        <select name="type">
          <option value="schedule">スケジュール</option>
          <option value="todo">タスク</option>
        </select>

        <input type="datetime-local" name="start_time">

        <input type="datetime-local" name="end_time">

        <textarea name="description"></textarea>

        <button type="submit">追加</button>
        <button type="button" onclick="closeModal()">キャンセル</button>
      </form>
    </div>
  </div>

  <div class="toast" id="toast"></div>
  <script src="js/calendar.js"></script>
</body>

</html>