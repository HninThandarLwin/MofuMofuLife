<?php
require_once './database/data_loading.php';
require_once './database/task_data.php';
require_once './includes/calendar.php';


$currentPage = 'calendar';
$week = ["日", "月", "火", "水", "木", "金", "土"];
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>モフモフLife</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/calendar.css">
    <link rel="stylesheet" href="css/Dashboard.css">

</head>

<body>

    <?php require_once './includes/nav.php'; ?>

    <main class="main">
        <section class="page">
            <div class="page-header">
                <h1 class="page-title">カレンダー</h1>
                <div class="cal-nav">
                    <form method="POST" action="index.php" style="display:inline;">
                        <input type="hidden" name="year" value="<?= $prevYear ?>">
                        <input type="hidden" name="month" value="<?= $prevMonth ?>">

                        <button class="cal-arrow" type="submit">
                            &#8249;
                        </button>
                    </form>
                    <span class="cal-month-label">
                        <?= $year ?>年 <?= $month ?>月
                    </span>
                    <form method="POST" action="index.php" style="display:inline;">
                        <input type="hidden" name="year" value="<?= $nextYear ?>">
                        <input type="hidden" name="month" value="<?= $nextMonth ?>">

                        <button class="cal-arrow" type="submit">
                            &#8250;
                        </button>
                    </form>
                </div>
            </div>

            <div class="calendar-grid">
                <?php foreach ($week as $i => $day) : ?>

                    <?php
                    $class = "cal-weekday";
                    if ($i == 0) $class .= " sun";
                    if ($i == 6) $class .= " sat";
                    ?>
                    <div class="<?= $class ?>"> <?= $day ?> </div>
                <?php endforeach; ?>

                <?php for ($i = 0; $i < $firstDay; $i++) : ?>
                    <div class="cal-day empty"></div>
                <?php endfor; ?>

                <?php for ($d = 1; $d <= $daysInMonth; $d++) : ?>
                    <?php
                    $date = sprintf("%04d-%02d-%02d", $year, $month, $d);
                    $isToday = ($date == date('Y-m-d'));
                    $dayTasks = $tasksByDate[$date] ?? [];
                    ?>
                    <div class="cal-day <?= $isToday ? 'today' : '' ?>"
                        onclick="selectDay('<?= $date ?>')">

                        <?php if ($isToday): ?>
                            <div class="today-star">⭐</div>
                        <?php endif; ?>

                        <div class="cal-day-num">
                            <?= $d ?>
                        </div>

                        <div class="cal-items">
                            <?php foreach ($dayTasks as $task): ?>
                                <div class="cal-item <?= $task['type'] == 'schedule' ? 'schedule' : 'task' ?>">
                                    <?= htmlspecialchars($task['title']) ?>
                                </div>
                            <?php endforeach; ?>
                        </div>

                    </div>
                <?php endfor; ?>
            </div>
        </section>
    </main>
    <!-- Add Task Modal -->
    <div class="modal fade" id="eventModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <form action="./includes/task_create.php" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title">タスクを追加</h5>
                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal">
                        </button>
                    </div>

                    <div class="modal-body">
                        <input type="hidden" id="selectedDate"
                            name="date">

                        <div class="mb-3">
                            <label class="form-label">日付</label>
                            <input
                                type="text"
                                class="form-control"
                                id="modalHeader"
                                readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">タイトル</label>
                            <input
                                type="text"
                                class="form-control"
                                name="title"
                                required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">タイプ</label>
                            <select
                                class="form-select"
                                id="taskType"
                                name="type"
                                onchange="toggleTimeFields()">

                                <option value="schedule">スケジュール</option>
                                <option value="todo">タスク</option>

                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">説明</label>
                            <textarea
                                class="form-control"
                                name="description"
                                rows="3"></textarea>
                        </div>
                        <div id="addTimeFields">
                            <div class="mb-3">
                                <label class="form-label">開始時間</label>
                                <input
                                    id="start_time"
                                    type="time"
                                    class="form-control"
                                    name="start_time">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">終了時間</label>
                                <input
                                    id="end_time"
                                    type="time"
                                    class="form-control"
                                    name="end_time">
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">
                            キャンセル
                        </button>
                        <button type="submit" class="btn btn-primary">
                            追加
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/calendar.js"></script>
</body>
</body>

</html>