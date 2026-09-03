<?php

/*************************************
        GET DATA
**************************************/

//タスク・スケジュールをデータベースにに記入
function addTasks( PDO $pdo, int $userId, string $title,
    string $type, string $description, ?string $start, ?string $end
): bool {
    $stmt = $pdo->prepare("
        INSERT INTO tasks
        (user_id, title, type, description, start_time, end_time)
        VALUES
        (:user_id, :title, :type, :description, :start_time, :end_time)
    ");
    $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
    $stmt->bindValue(':title', $title);
    $stmt->bindValue(':type', $type);
    $stmt->bindValue(':description', $description);
    $stmt->bindValue(':start_time', $start);
    $stmt->bindValue(':end_time', $end);
    return $stmt->execute();
}

function getAllTasks(PDO $pdo, int $userId): array{
    $stmt = $pdo->prepare("SELECT * FROM tasks WHERE user_id = :user_id"); 
    $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $stmt->execute();
return (array)$stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getAll(PDO $pdo, string $type, int $userId): array{
    $stmt = $pdo->prepare("SELECT * FROM tasks WHERE type = :type AND user_id = :user_id"); 
    $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $stmt->bindParam(':type', $type, PDO::PARAM_STR);
    $stmt->execute();
    return (array)$stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getAllPending(PDO $pdo, int $userId): array{
    $stmt = $pdo->prepare("SELECT * FROM tasks WHERE status = 'pending' AND user_id = :user_id"); 
    $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $stmt->execute();
    return (array)$stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getPending(PDO $pdo, string $type, int $userId): array{
    $stmt = $pdo->prepare("SELECT * FROM tasks WHERE type = :type AND status = 'pending' AND user_id = :user_id"); 
    $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $stmt->bindParam(':type', $type, PDO::PARAM_STR);
    $stmt->execute();
    return (array)$stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getTaskByMonth(PDO $pdo, int $userId,int $year, int $month): array{
    $stmt = $pdo->prepare("
        SELECT *
        FROM tasks
        WHERE user_id = :user_id
            AND YEAR(start_time) = :year
            AND MONTH(start_time) = :month
        ORDER BY start_time
    ");
    $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $stmt->bindValue(':year', $year);
    $stmt->bindValue(':month', $month);
    $stmt->execute();
    return (array)$stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getTaskById(PDO $pdo, int $taskId): array{
    $stmt = $pdo->prepare("
            SELECT *
            FROM tasks
            WHERE id = :taskId
        ");
    $stmt->bindParam(':taskId', $taskId, PDO::PARAM_INT);    
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

/*************************************
        UPDATE DATA
**************************************/
// commit
function updateTask(PDO $pdo, int $taskId,
    string $title, string $type,
    string $description, 
    ?string $start_time, ?string $end_time
): bool  {
    $stmt = $pdo->prepare("
        UPDATE tasks
        SET
            title = :title,
            type = :type,
            description = :description,
            start_time = :start_time,
            end_time = :end_time
        WHERE id = :taskId
    ");

    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':type', $type);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':start_time', $start_time);
    $stmt->bindParam(':end_time', $end_time);
    $stmt->bindParam(':taskId', $taskId, PDO::PARAM_INT);

    return $stmt->execute();
}

function updateRewardStatus(PDO $pdo, int $taskId){
    $stmt = $pdo->prepare("
        UPDATE tasks
        SET rewarded = true
        WHERE id = :task_id
    ");
    $stmt->bindParam(':task_id', $taskId, PDO::PARAM_INT);
    $stmt->execute();
    //will commit in rewardTask()
}

function updateTaskStatus(PDO $pdo, int $taskId){
    $stmt = $pdo->prepare("
        UPDATE tasks
        SET status = 'completed'
        WHERE id = :task_id
    ");
    $stmt->bindParam(':task_id', $taskId, PDO::PARAM_INT);
    $stmt->execute();
    //will commit in rewardTask()
}

function deleteTask(PDO $pdo, int $taskId){
    $stmt = $pdo->prepare("
        DELETE FROM tasks
        WHERE id = :task_id
    ");
    $stmt->bindParam(':task_id', $taskId, PDO::PARAM_INT);
    $stmt->execute();
    $pdo->commit();
}

function updateTodoEndTime(PDO $pdo, int $taskId)
{
    $stmt = $pdo->prepare("
        UPDATE tasks
        SET end_time = NOW()
        WHERE id = :task_id
          AND type = 'todo'
    ");

    $stmt->bindValue(':task_id', $taskId, PDO::PARAM_INT);
    $stmt->execute();
}
?>