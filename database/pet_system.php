<?php

function reduceHPbyTime(PDO $pdo, int $userId): void{
    $pets = getUserPets($pdo, $userId);
  // print_r($pets);
    foreach ($pets as $pet) {

        $lastUpdate = new DateTime($pet['last_hp_update']);
        $now = new DateTime();

        $hours = floor(
            ($now->getTimestamp() - $lastUpdate->getTimestamp()) / 3600
        );

        // Less than one hour
        if ($hours <= 0) {
            continue;
        }

        // 2 HP per hour
        $damage = $hours * 2;

        $newHp = max(0, $pet['hp'] - $damage);

        updatePetHp($pdo, $pet['id'], $newHp);
        updateLastHpUpdate($pdo, $pet['id']);
    }
}

