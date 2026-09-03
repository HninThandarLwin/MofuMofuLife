<?php
require_once __DIR__ . '/../config/db_connection.php';
require_once __DIR__ . '/../database/data_loading.php';
require_once __DIR__ . '/../database/data_update.php';
require_once __DIR__ . '/../includes/SESSION.php';

$levelUpPoint = 100;
$maxLevel = 30;
$currentPet = getCurrentPetType($pdo, $userId);

$showLevelUpPopup = false;
$showEvolve = false;

$currentLevel = 0;
$nextLevel = 0;
$userPoint = 0;

//check if level-up-available was clicked
if ( $_SERVER['REQUEST_METHOD'] === 'POST' &&
    isset($_POST['show_level_up_popup'])
) {
    $_SESSION[
        'level_up_popup_shown-for-' . $currentPet
    ] = false;

    header('Location: ../pet_detail.php');
    exit;
}
//create session if not exist
if (!isset($_SESSION['level_up_popup_shown-for-'. "$currentPet"])) {
    $_SESSION['level_up_popup_shown-for-'. "$currentPet"] = false;
}

/* =========================================================
   Get current pet
========================================================= */

$pet = getCurrentPet($pdo, $userId);// all data from currentPet

if ($pet) {

    $userPoint = getUserPoints( $pdo, $userId);
    $currentLevel = getPetLevel($pdo, $pet['type'], $userId);
    $nextLevel = $currentLevel + 1;

    /* =====================================================
       Check whether popup should appear
    ===================================================== */
    if (
        $_SESSION['level_up_popup_shown-for-'. "$currentPet"] === false &&
        $userPoint >= $levelUpPoint &&
        $currentLevel < $maxLevel
    ) { 
        $showLevelUpPopup = true;
        
        $_SESSION['level_up_popup_shown-for-'. "$currentPet"] = true;
    }

    /* =====================================================
        when clicked level-up
    ===================================================== */

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['level_up'])) {
        if($nextLevel == 10){
            $pt = 150;
        }elseif($nextLevel == 20){
            $pt = 200;
        }elseif($nextLevel == 30){
            $pt = 300;
        }else{
            $pt = 100;
        }
        updatePetLevel($pdo, $pet['id'], $userId, $pt);
        header('Location: ../pet_detail.php');
        exit;
    }

}


// echo '<pre>';
// var_dump([
//     'currentPet' => $currentPet,
//     'userPoint' => $userPoint,
//     'currentLevel' => $currentLevel,
//     'nextLevel' => $nextLevel,
//     'session' => $_SESSION['level_up_popup_shown-for-' . $currentPet] ?? 'NOT SET',
//     'showLevelUpPopup' => $showLevelUpPopup,
// ]);
// echo '</pre>';
?>




