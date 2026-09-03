<?php

function updatePetHp(PDO $pdo, int $petId, int $hp){
    $stmt = $pdo->prepare("
        UPDATE pets
        SET hp = :hp
        WHERE id = :pet_id
    ");

    $stmt->bindParam(':hp', $hp, PDO::PARAM_INT);
    $stmt->bindParam(':pet_id', $petId, PDO::PARAM_INT);
    $stmt->execute();
}

function updateLastHpUpdate(PDO $pdo, int $petId){
    $stmt = $pdo->prepare("
        UPDATE pets
        SET last_hp_update = NOW()
        WHERE id = :pet_id
    ");

    $stmt->bindParam(':pet_id', $petId, PDO::PARAM_INT);
    $stmt->execute();
}

function addOwnedPets(PDO $pdo, int $userId, string $petType){
    $stmt = $pdo->prepare("
        INSERT INTO pets (user_id, type) VALUES 
        (:user_id, :petType);
    ");
    $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $stmt->bindParam(':petType', $petType, PDO::PARAM_STR);
    $stmt->execute();
    $pdo->commit();
}

function pointExchange(PDO $pdo, int $userId, int $hp): bool{
    $pt = (int)($hp * 2);
    try {
        reduceUserPoints($pdo, $userId, $pt);
        // Increase pet HP (maximum 100)
        $stmt = $pdo->prepare("
            UPDATE pets
            SET hp = LEAST(100, hp + :hp)
            WHERE user_id = :user_id
            AND is_selected = TRUE;
        ");
        $stmt->bindParam(':hp', $hp, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        $pdo->commit();
        return true;
    } catch (PDOException $e) {
        $pdo->rollBack();
        throw $e;
    }
}

//no commit here as in case caller function fails rollback can also effect this point deduction
function reduceUserPoints(Pdo $pdo, int $userId, int $pt): bool{
    try {
        // Subtract user points
        $stmt = $pdo->prepare("
            UPDATE users
            SET point = point - :pt
            WHERE id = :user_id
            AND point >= :pt
        ");
        $stmt->bindParam(':pt', $pt, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return true;
    }catch (PDOException $e) {
        throw $e;
    }
}

function taskRewardPt(PDO $pdo, int $userId, int $rewardPt){
    $stmt = $pdo->prepare("
        UPDATE users
        SET point = point + :rewardPt
        WHERE id = :user_id
    ");
    $stmt->bindParam(':rewardPt', $rewardPt, PDO::PARAM_INT);
    $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $stmt->execute();
    //will commit in rewardTask()
}

function rewardTask(PDO $pdo, int $taskId, int $userId){
    $task = getTaskbyId($pdo, $taskId);
    // print_r($task);
    if(!$task['rewarded']){
        if($task['type'] === "schedule"){
            taskRewardPt($pdo, $userId, 15);
        }else if($task['type'] === "todo"){
            taskRewardPt($pdo, $userId, 10);
        }
        updateRewardStatus($pdo, $taskId);
        updateTaskStatus($pdo, $taskId);
        updateTodoEndTime($pdo, $taskId);
        $pdo->commit();
    }

}

function updatePetLevel(PDO $pdo, int $petId, int $userId, int $pt): void
{
    try{
        reduceUserPoints($pdo, $userId, $pt);
        $stmt = $pdo->prepare("
            UPDATE pets
            SET level = level + 1
            WHERE id = :pet_id
        ");
        $stmt->bindParam(':pet_id', $petId, PDO::PARAM_INT);
        $stmt->execute();
        $pdo->commit();
    } catch (PDOException $e) {
        $pdo->rollBack();
        throw $e;
    }
}