<?php
require_once __DIR__ . '/includes/pet_level.php';
require_once './database/data_loading.php';
require_once './database/data_update.php';
require_once './database/pet_system.php';
require_once './includes/pet_info.php';
require_once './includes/SESSION.php';

$currentPage = 'pet_detail';

/* ==============================
   基本データ取得
============================== */
reduceHPbyTime($pdo, $userId);
$hpExchangeMessage = $_SESSION['hp_exchange_message'] ?? null;
$hpExchangeMessageType = $_SESSION['hp_exchange_message_type'] ?? null;

unset($_SESSION['hp_exchange_message']);
unset($_SESSION['hp_exchange_message_type']);

/* ==============================
   表示するペット変更
============================== */
if (
    $_SERVER['REQUEST_METHOD'] === 'POST' &&
    ($_POST['action'] ?? '') === 'select_pet'
) {
    $petType = $_POST['pet_type'] ?? '';
    $ownedPetTypes = array_column($ownedPets, 'type');

    if (in_array($petType, $ownedPetTypes, true)) {
        setCurrentPet($pdo, $userId, $petType);
        // $_SESSION['pet_message'] = 'ペットを変更しました🐾';
    }

    header('Location: pet_detail.php');
    exit;
}

/* ==============================
   表示用データ
============================== */
$currentHp = getPetHp($pdo, $currentPet, $userId);
$currentLevel = getPetLevel($pdo, $currentPet, $userId);

try {
    $togetherDays = getTogetherDays($pdo, $currentPet, $userId);
} catch (Throwable $e) {
    $togetherDays = 0;
}
$currentImage = getPetImage($currentPet, $currentHp, $currentLevel);

$detail = $petDetails[$currentPet] ?? [
    'name' => $petName ?? 'ペット',
    'personality' => 'やさしくて、かわいい性格です。',
    'favorite' => 'おいしいごはん',
    'favorite_icon' => '🍎',
    'description' => 'あなたと一緒に成長していく大切なペットです。',
    'message' => '今日も一緒にがんばろうね！'
];


/* ==============================
   HP交換
============================== */
if (
    $_SERVER['REQUEST_METHOD'] === 'POST'
    && ($_POST['action'] ?? '') === 'exchange_hp'
) {
    $Hp = (int)($_POST['exchange_point'] ?? 0);
    $userPoint = getUserPoints($pdo, $userId);
    $availablePt = $Hp * 2;

    if ($Hp < 1 || $Hp > 100) {
        $_SESSION['hp_exchange_message'] = "HPは1〜100の範囲で入力してください。";
        $_SESSION['hp_exchange_message_type'] = "error";
    } elseif ($availablePt > $userPoint) {
        $_SESSION['hp_exchange_message'] = "ポイントが不足しています。";
        $_SESSION['hp_exchange_message_type'] = "error";
    } else {
        $needHp = 100 - $currentHp;
        if ($needHp <= 0) {
            $_SESSION['hp_exchange_message'] = "HPはすでに最大です。";
            $_SESSION['hp_exchange_message_type'] = "error";
        } elseif ($Hp > $needHp) {
            $_SESSION['hp_exchange_message'] =
                "現在のHPでは最大 {$needHp} まで交換できます。";
            $_SESSION['hp_exchange_message_type'] = "error";
        } else {
            pointExchange($pdo, $userId, $Hp);
            $_SESSION['hp_exchange_message'] = "HPを{$Hp}回復しました🐾";
            $_SESSION['hp_exchange_message_type'] = "success";
        }
    }
    header("Location: pet_detail.php");
    exit;
}

?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0">
    <title>ペット詳細 — モフモフLife</title>
    <link rel="stylesheet" href="./css/common.css">
    <link rel="stylesheet" href="./css/pet_level.css">
    <link rel="stylesheet" href="./css/pet_detail.css">
</head>

<body>

    <?php require_once './includes/nav.php'; ?>

    <main class="main pet-detail-page">
        <!-- ヘッダー -->
        <header class="pet-detail-header">
            <!-- 左側：タイトル -->
            <div class="header-title-area">
                <h1>ペット詳細</h1>
            </div>
            <!-- 自分のペット -->
            <div class="header-right-area">
                <div class="mini-owned-pets-title">
                    自分のペット
                </div>
                <div class="mini-owned-pets-list">
                    <?php if (!empty($ownedPets)): ?>
                        <?php foreach ($ownedPets as $pet): ?>

                            <?php
                            $petType = $pet['type'];
                            $petHp = getPetHp($pdo, $petType, $userId);
                            $petImage = getPetImage($petType, $petHp, $currentLevel);

                            $petDisplayName =
                                $petDetails[$petType]['name'] ?? $petType;
                            $isCurrent = $petType === $currentPet;
                            ?>

                            <form method="POST" action="pet_detail.php" class="mini-pet-form">
                                <input type="hidden" name="action" value="select_pet">
                                <input type="hidden" name="pet_type"
                                    value="<?= htmlspecialchars(
                                                $petType,
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ) ?>">

                                <button type="submit" class="mini-pet-button 
                                    <?= $isCurrent ? 'selected' : '' ?>"
                                    title="<?= htmlspecialchars(
                                                $petDisplayName,
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ) ?>
                                ">
                                    <img src="<?= htmlspecialchars(
                                                    $petImage,
                                                    ENT_QUOTES,
                                                    'UTF-8'
                                                ) ?>"
                                        alt="<?= htmlspecialchars(
                                                    $petDisplayName,
                                                    ENT_QUOTES,
                                                    'UTF-8'
                                                ) ?>
                                    ">
                                </button>

                            </form>

                        <?php endforeach; ?>

                    <?php else: ?>

                        <span class="no-owned-pet"> ペットがいません</span>

                    <?php endif; ?>

                </div>
            </div>
        </header>
        <!-- メイン詳細 -->
        <section class="pet-detail-layout">
            <!-- 左側 -->
            <div class="pet-visual-column">
                <span class="pet-heart">♥</span>
                <div class="main-pet-image-area">
                    <img
                        src="<?= htmlspecialchars($currentImage, ENT_QUOTES, 'UTF-8') ?>"
                        alt="<?= htmlspecialchars($detail['name'], ENT_QUOTES, 'UTF-8') ?>"
                        class="main-pet-image">
                </div>

                <div class="daily-message-box">
                    <h2>💬 今日のメッセージ</h2>
                    <p> <?= htmlspecialchars($detail['message'], ENT_QUOTES, 'UTF-8') ?>
                        🐾
                    </p>
                </div>
            </div>
            <!-- 右側 -->
            <div class="pet-information-column">
                <div class="pet-name-row">
                    <div class="pet-name-title">
                        <span>🐾</span>
                        <h2> <?= htmlspecialchars($detail['name'], ENT_QUOTES, 'UTF-8') ?>
                        </h2>
                    </div>
                </div>
                <!-- ステータス -->
                <div class="pet-status-grid">
                    <div class="status-information-card">
                        <div class="status-information-level">
                            <span class="status-label"> ⭐ レベル</span>
                            <?php if ($userPoint >= $levelUpPoint && $currentLevel < 30): ?>
                                <form method="POST" action="./includes/pet_level.php">
                                    <input type="hidden"
                                        name="show_level_up_popup"
                                        value="1">

                                    <button
                                        type="submit"
                                        class="level-up-available">
                                        レベルアップ可能
                                    </button>
                                </form>
                            <?php endif; ?>
                        </div>
                        <strong> <?= (int) $currentLevel ?> </strong>
                    </div>

                    <div class="status-information-card">
                        <span class="status-label"> 🌱 HP </span>
                        <strong> <?= (int) $currentHp ?> </strong>
                    </div>

                    <div class="status-information-card">
                        <span class="status-label">
                            📅 一緒にいる日数
                        </span>
                        <strong> <?= (int) $togetherDays ?>日 </strong>
                    </div>
                </div>

                <div class="hp-exchange-card">
                    <div class="hp-header">
                        <h3>🌱 HP交換</h3>
                        <?php if ($hpExchangeMessage): ?>

                            <div id="hpMessage"
                                class="hp-message-<?= $hpExchangeMessageType ?>">
                                <?= htmlspecialchars($hpExchangeMessage, ENT_QUOTES, 'UTF-8') ?>
                            </div>

                            <script>
                                setTimeout(() => {
                                    const message = document.getElementById('hpMessage');

                                    if (message) {
                                        message.style.display = 'none';
                                    }
                                }, 60000);
                            </script>

                        <?php endif; ?>

                        <h4> 1HP = 2pt </h4>
                    </div>
                    <form action="pet_detail.php" method="POST">

                        <input type="hidden" name="action" value="exchange_hp">
                        <input type="number"
                            name="exchange_point"
                            class="hp-input"
                            min="1" max="100" step="1"
                            placeholder="HP数を入力(例：100Hp)">
                        <button type="submit" class="hp-exchange-btn">
                            Pt交換
                        </button>

                    </form>
                </div>
                <div class="information-grid">
                    <article class="information-card">
                        <h3>性格</h3>
                        <p> <?= htmlspecialchars(
                                $detail['personality'],
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>
                        </p>
                    </article>

                    <article class="information-card">

                        <h3>好きな食べ物</h3>

                        <div class="favorite-food">
                            <span class="food-icon">
                                <?= htmlspecialchars(
                                    $detail['favorite_icon'],
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>
                            </span>
                            <p> <?= htmlspecialchars(
                                    $detail['favorite'],
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>
                            </p>
                        </div>
                    </article>
                </div>

                <article class="description-card">
                    <h3>説明</h3>
                    <p> <?= htmlspecialchars(
                            $detail['description'],
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>
                    </p>
                </article>
            </div>
        </section>
    </main>


    <form id="levelUpModal" class="level-up-modal"
        style="<?= $showLevelUpPopup ? '' : 'display: none;' ?>"
        method="POST" action="./includes/pet_level.php"
        data-show="<?= $showLevelUpPopup ? 'true' : 'false' ?>"
        data-level="<?= $currentLevel ?>"
        data-next-level="<?= $nextLevel ?>">

        <div class="level-up-modal-content">
            <h2>SYSTEM</h2>
            <p class="level-up-message">
                <!-- js handles -->
            </p>
            <p class="level-up-question">
                <!-- js handles -->
            </p>
            <div class="level-up-info">
                <p>
                    現在レベル：
                    <strong>
                        Lv.<?= $currentLevel ?>
                    </strong>
                </p>
                <p>
                    次のレベル：
                    <strong>
                        Lv.<?= $nextLevel ?>
                    </strong>
                </p>
                <p>
                    必要ポイント：
                    <strong>
                        <?= $levelUpPoint ?> pt
                    </strong>
                </p>
            </div>
            <input type="hidden" name="pet_id" value="<?= $pet['id'] ?>">
            <div class="levelUpButtons">
                <button type="submit" name="level_up" id="levelUpButton" class="level-up-button">
                    <!-- js handles -->
                </button>
                <button type="button" id="levelUpCancel" class="level-up-button">
                    あとで
                </button>
            </div>

        </div>
    </form>
    <script src="./js/pet_level.js"></script>
</body>

</html>