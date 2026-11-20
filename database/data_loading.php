<?php

/*************************************
for user data
**************************************/
function getUserPoints(PDO $pdo, int $userId): int{
    $stmt = $pdo->prepare("
    SELECT point
    FROM users
    WHERE id = :id 
    ");
    $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
    $stmt->execute();
    $userPoint = $stmt->fetchColumn();
    return (int)$userPoint;
}

function updateUserPoints(PDO $pdo, int $userId, int $updatePoint)
{
    $stmt = $pdo->prepare("
    UPDATE users
    SET point = :point
    WHERE id = :user_id
    ");
    $stmt->bindParam(':point', $updatePoint, PDO::PARAM_INT);
    $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $stmt->execute();
}

/*************************************
for pet data
**************************************/
function getUserPetType(PDO $pdo, int $userId): array{
    $stmt = $pdo->prepare("
        SELECT type
        FROM pets
        WHERE user_id = :user_id
    ");
    $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_COLUMN);
}

function getUserPets(PDO $pdo, int $userId): array{
    $stmt = $pdo->prepare("
        SELECT *
        FROM pets
        WHERE user_id = :user_id
    ");
    $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getCurrentPetType(PDO $pdo, int $userId): string
{
    $stmt = $pdo->prepare("
    SELECT type
    FROM pets
    WHERE user_id = :user_id
    AND is_selected = 1
    ");
    $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $stmt->execute();
    return (string)$stmt->fetchColumn();
}

function getCurrentPet(PDO $pdo, int $userId): array
{
    $stmt = $pdo->prepare("
    SELECT *
    FROM pets
    WHERE user_id = :user_id
    AND is_selected = 1
    ");
    $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function setCurrentPet(PDO $pdo, int $userId, string $petType){
    //setting false to all pet
    $stmt = $pdo->prepare("
    UPDATE pets
    SET is_selected = FALSE
    WHERE user_id = :user_id
    ");
    $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $stmt->execute();
    //set true for current pet
    $stmt = $pdo->prepare("
    UPDATE pets
    SET is_selected = TRUE
    WHERE user_id = :user_id
    AND type = :petType
    ");
    $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $stmt->bindParam(':petType', $petType, PDO::PARAM_STR);
    $stmt->execute();
    $pdo->commit();
}

function getPetHp(PDO $pdo, string $type, int $userId): int{
    $stmt = $pdo->prepare("
        SELECT hp
        FROM pets
        WHERE user_id = :user_id
        AND type = :type
    ");
    $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $stmt->bindParam(':type', $type, PDO::PARAM_STR);
    $stmt->execute();

    return (int)$stmt->fetchColumn();
}

function getPetLevel(PDO $pdo, string $pet_type, int $userId): int{
    $stmt = $pdo->prepare("
        SELECT level
        FROM pets
        WHERE user_id = :user_id
        AND type = :type
    ");
    $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $stmt->bindParam(':type', $pet_type, PDO::PARAM_STR);
    $stmt->execute();

    return (int)$stmt->fetchColumn();
}

function getLastHpUpdate  (PDO $pdo, string $type, int $userId): string{
    $stmt = $pdo->prepare("
        SELECT last_hp_update  
        FROM pets
        WHERE user_id = :user_id
        AND type = :type
    ");
    $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $stmt->bindParam(':type', $type, PDO::PARAM_STR);
    $stmt->execute();

    return (string)$stmt->fetchColumn();
}

// function getPetImage(string $type, int $hp): string{
//     if ($hp < 30) {
//         $mood = 'angry';
//     } else {
//         $mood = 'happy';
//     }
//     return "images/pets/$type/$mood.gif";
// }

function getPetImage(string $type, int $hp, int $lv,): string{
    if($type === "otter" ||
        $type === "fox" ||
        $type === "panda" ||
        $type === "hamster"
    ){
        if ($lv < 10) {
            $img = 'baby';
        } else if($lv < 20) {
            $img = 'child';
        }else {
            $img = 'adult';
        }
    }else {
    if ($hp < 30) {
            $img = 'angry';
        } else {
            $img = 'happy';
        }
    }
    return "images/pets/$type/$img.gif";
}

function getAdoptDate(PDO $pdo, string $type, int $userId): string{
    $stmt = $pdo->prepare("
        SELECT adopt_date
        FROM pets
        WHERE user_id = :user_id
        AND type = :type
    ");
    $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $stmt->bindParam(':type', $type, PDO::PARAM_STR);
    $stmt->execute();

    return (string)$stmt->fetchColumn();
}

function getTogetherDays(PDO $pdo, string $type, int $userId): int{
    $adoptDate = new DateTime(getAdoptDate($pdo, $type, $userId));
    $today = new DateTime();

    return $adoptDate->diff($today)->days;
}


