<?php
require_once './config/db_connection.php';
require_once './includes/task_data.php';

$currentPage = 'task';

try {
  $allTasks = getAllTasks($pdo);
  // print_r($allTasks);
} catch (PDOException $e) {
  $pdo->rollBack();
  echo ("dbError " . $e);
  die("Connection failed: " . $e->getMessage());
}

?>
<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="css/common.css">
  <link rel="stylesheet" href="css/task.css">

  <title>タスク — モフモフLife</title>
</head>

<body>

  <!-- sidebar -->
  <?php require_once './includes/nav.php'; ?>

  <main class="main">
    <section class="page">
      <div class="page-header">
        <h1 class="page-title">今日のタスク</h1>
        <div class="today-date" id="todayLabel"></div>
      </div>
      <div class="task-columns">
        <div class="task-col">
          <div class="col-header">
            <span class="col-dot dot-todo"></span>
            やること <span class="col-count" id="todoCount">0</span>
          </div>
          <ul class="task-list" id="todoList"></ul>
          <p class="empty-msg" id="emptyTodo">タスクを追加しよう！</p>
        </div>
        <div class="task-col">
          <div class="col-header">
            <span class="col-dot dot-done"></span>
            完了 <span class="col-count" id="doneCount">0</span>
          </div>
          <ul class="task-list" id="doneList"></ul>
          <p class="empty-msg" id="emptyDone">まだ完了したタスクがないよ</p>
        </div>
        <div>
          <h3>All Tasks</h3>
          <table class="table table-hover mt-5 form-control-lg">
            <thead class="table-light text-secondary">
              <tr>
                <th>タスク番号</th>
                <th>タスク名</th>
                <th>タイプ</th>
                <th>説明</th>
                <th>スタート</th>
                <th>エンド</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($allTasks as $task): ?>
              <tr>
                <th><?= $task["id"] ?></th>
                <th><?= $task["title"] ?></th>
                <th><?= $task["type"] ?></th>
                <th><?= $task["description"] ?></th>
                <th><?= $task["start_time"] ?></th>
                <th><?= $task["end_time"] ?></th>
              </tr>
              <?php endforeach ?>
            </tbody>
          </table>
        </div>
      </div>
    </section>
  </main>
  <div class="toast" id="toast"></div>
  <script src="js/common.js"></script>
  <script src="js/task.js"></script>
</body>

</html>