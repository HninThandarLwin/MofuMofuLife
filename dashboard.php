<?php
require_once './config/db_connection.php';
require_once './database/task_data.php';
require_once './database/data_update.php';
require_once './includes/SESSION.php';

$currentPage = 'dash';
///  page current task request type ///
$type = filter_input(INPUT_POST, "type");
if ($type !== null) {
    $_SESSION['dashboard_type'] = $type;
} else {
    $type = $_SESSION['dashboard_type'] ?? 'all';
}

// Save checkbox state
if (isset($_POST['status'])) {
    $_SESSION['dashboard_status'] = true;
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['dashboard_status'] = false;
}
$status = $_SESSION['dashboard_status'] ?? false;

// Load tasks
if ($status) {
    if ($type === "all") {
        $allTasks = getAllPending($pdo, $userId);
    } else {
        $allTasks = getPending($pdo, $type, $userId);
    }
} else {
    if ($type === "all") {
        $allTasks = getAllTasks($pdo, $userId);
    } else {
        $allTasks = getAll($pdo, $type, $userId);
    }
}

/// delete form ///
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    if ($action === 'delete') {
        $taskId = filter_input(INPUT_POST, 'task_id', FILTER_VALIDATE_INT);
        if ($taskId) {
            deleteTask($pdo, $taskId);
        }
        header("Location: dashboard.php");
        exit;
    }
}

//// task status update ///
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    if ($action === 'complete') {
        $taskId = filter_input(INPUT_POST, 'task_id', FILTER_VALIDATE_INT);
        if ($taskId) {
            rewardTask($pdo, $taskId, $userId);
        }
        header("Location: dashboard.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ダッシュボード | モフモフLife</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/Dashboard.css">
</head>

<body>
    <!-- Sidebar -->
    <?php require_once './includes/nav.php'; ?>

    <main class="main">

        <section class="page">
            <!-- Header -->
            <div class="page-header">
                <div>
                    <h1 class="page-title">ダッシュボード</h1>

                </div>
                <div class="today-date" id="todayLabel"></div>
            </div>
            <!-- Summary -->
            <form action="dashboard.php" method="POST" class="dashboard-summary">
                <!-- All items -->
                <button type="submit" class="summary-card" name="type" value="all">
                    <div class="card-icon">📦</div>
                    <h3>全て</h3>
                </button>
                <!-- Schedule -->
                <button type="submit" class="summary-card" name="type" value="schedule">
                    <div class="card-icon">📅</div>
                    <h3>スケジュール</h3>
                </button>
                <!-- Task -->
                <button type="submit" class="summary-card" name="type" value="todo">
                    <div class="card-icon">✅</div>
                    <h3>タスク</h3>
                </button>

            </form>
        </section>
        <form action="dashboard.php" method="POST">
            <label>
                <input
                    type="checkbox"
                    name="status"
                    onchange="this.form.submit()"
                    <?= $status ? 'checked' : '' ?>>
                未完了のみ表示
            </label>
        </form>

        <?php if (isset($allTasks) && !empty($allTasks)): ?>
            <div class="dashboard-scroll">
                <table class="table table-hover mt-5 form-control-lg">
                    <thead class="table-light text-secondary">
                        <tr>
                            <th>タスク番号</th>
                            <th>タスク名</th>
                            <th>タイプ</th>
                            <th>説明</th>
                            <th>スタート</th>
                            <th>エンド</th>
                            <th>完了</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $count = 1; ?>
                        <?php foreach ($allTasks as $task): ?>
                            <tr>
                                <td><?= $count ?></td>
                                <td><?= htmlspecialchars($task["title"]) ?></td>
                                <td><?= $task["type"] ?></td>
                                <td><?= htmlspecialchars($task["description"]) ?></td>
                                <td><?= $task["start_time"] ?></td>
                                <td><?= $task["end_time"] ?></td>
                                <td>
                                    <?php if ($task["status"] == "pending") { ?>
                                        <form method="POST" action="dashboard.php">
                                            <input type="hidden" name="action" value="complete">
                                            <input type="hidden" name="task_id" value="<?= $task['id'] ?>">
                                            <button type="submit"
                                                class="complete-btn"
                                                onclick="return confirm('完了にしますか？');">
                                                🕒 未完了
                                            </button>
                                        </form>
                                    <?php } else { ?>
                                        <span class="complete-btn completed">
                                            ✓ 完了済み
                                        </span>
                                    <?php } ?>
                                </td>
                                <!-- Three Dot -->
                                <?php if ($task['status'] !== 'completed'): ?>
                                    <td>
                                        <div class="dropdown">
                                            <button class="action-btn" type="button" data-bs-toggle="dropdown">
                                                ⋮
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <button
                                                        type="button"
                                                        class="dropdown-item editBtn"
                                                        data-id="<?= $task['id'] ?>"
                                                        data-title="<?= htmlspecialchars($task['title']) ?>"
                                                        data-type="<?= $task['type'] ?>"
                                                        data-description="<?= htmlspecialchars($task['description']) ?>"
                                                        data-start="<?= $task['start_time'] ?>"
                                                        data-end="<?= $task['end_time'] ?>">
                                                        ✏️ 編集
                                                    </button>
                                                    <form method="POST" action="dashboard.php" onsubmit="return confirm('削除しますか？');">
                                                        <input type="hidden" name="action" value="delete">
                                                        <input type="hidden" name="task_id" value="<?= $task['id'] ?>">
                                                        <button type="submit" class="dropdown-item text-danger">
                                                            🗑 削除
                                                        </button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                <?php endif; ?>
                            </tr>
                            <?php $count++; ?>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
        <!-- Edit Modal -->
        <div class="modal fade" id="editModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <form action="./includes/task_update.php" method="POST">
                        <div class="modal-header">
                            <h4 class="modal-title"> タスクを編集 </h4> <button type="button" class="btn-close" data-bs-dismiss="modal"> </button>
                        </div>
                        <div class="modal-body">

                            <input type="hidden" name="id"
                                id="editId">
                            <!-- Task Name -->
                            <div class="mb-3">
                                <label class="form-label"> タスク名 </label>
                                <input type="text" class="form-control" id="editTitle" name="title" required>
                            </div>
                            <!-- Type -->
                            <div class="mb-3">
                                <label class="form-label"> タイプ </label>
                                <select class="form-select" id="editType" name="type" onchange="toggleTimeFields()"> //add by yamin to change edit button
                                    <option value="schedule">スケジュール</option>
                                    <option value="todo">タスク</option>
                                </select>
                            </div>
                            <!-- Description -->
                            <div class="mb-3">
                                <label class="form-label"> 説明 </label>
                                <textarea class="form-control" id="editDescription" name="description" rows="3"> </textarea>
                            </div>
                            <!-- Start -->
                            <div id="timeFields">
                                <div class="mb-3">
                                    <label class="form-label"> スタート日時 </label>
                                    <input type="datetime-local" class="form-control" id="editStart" name="start_time">
                                </div>
                                <!-- End -->
                                <div class="mb-3">
                                    <label class="form-label"> エンド日時 </label>
                                    <input type="datetime-local" class="form-control" id="editEnd" name="end_time">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                    キャンセル
                                </button> 
                                <button class="btn btn-warning" type="submit">
                                    保存する 
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/dashboard.js"></script>
</body>
</body>

</html>