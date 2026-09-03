<?php
require_once './config/db_connection.php';
require_once './database/data_loading.php';
require_once './database/data_update.php';
require_once './includes/pet_info.php';
require_once './includes/SESSION.php';

//pet_data.php でSESSIONスタートしてる
$currentPage = 'shop';

/* =========================
   購入 / 選択処理
========================= */
if (isset($_POST["petType"])) {

  $petType = $_POST["petType"];
  $cost = (int)$_POST["cost"];

  try {
    if (in_array($petType, $userPetTypes)) {
      setCurrentPet($pdo, $userId, $petType);
      $currentPet = $petType;

      $_SESSION['toast'] = "ペットを変更しました🐾";
    } else {
      if ($userPoint >= $cost) {
        $userPoint -= $cost;
        updateUserPoints($pdo, $userId, $userPoint);
        addOwnedPets($pdo, $userId, $petType); //void method
        $userPetIds = getUserPetType($pdo, $userId);
        setCurrentPet($pdo, $userId, $petType);
        $currentPet = $petType;
        $_SESSION['toast'] = "購入しました！🎉";
      } else {
        $_SESSION['toast'] = "ポイントが足りません💦";
      }
    }
    header("Location: shop.php");
    exit;
  } catch (Exception $e) {
    $pdo->rollBack();
    echo ("dbError " . $e);
    die("Connection failed: " . $e->getMessage());
  }
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/common.css">
  <link rel="stylesheet" href="css/petshop.css">
  <title>ペットショップ — モフモフLife</title>
</head>

<body>
  <!-- sidebar -->
  <?php require_once './includes/nav.php'; ?>

  <!-- main -->
  <main class="main">

    <section class="page">

      <div class="page-header">
        <h1 class="page-title">ペットショップ</h1>
      </div>

      <p class="shop-desc">ポイントをためて好きなペットを選ぼう！</p>

      <!-- 🔥 商店 -->
      <div class="shop-grid">

        <?php foreach ($pets as $pet):
          $isOwned = in_array($pet["type"], $userPetTypes);
          $isSelected = $pet["type"] == $currentPet;
        ?>

          <div class="pet-card <?= !$isOwned ? 'lock' : '' ?> <?= $isSelected ? 'selected' : '' ?>">

            <img src="<?= $pet["img"] ?>" width="100">

            <p><?= $pet["name"] ?></p>

            <p>
              <?php if ($isSelected): ?>
                ✓ 選択中
              <?php elseif ($isOwned): ?>
                所持
              <?php else: ?>
                <?= $pet["cost"] ?> pt
              <?php endif; ?>
            </p>

            <form method="POST">
              <input type="hidden" name="petType" value="<?= $pet["type"] ?>">
              <input type="hidden" name="cost" value="<?= $pet["cost"] ?>">
              <?php if ($isSelected): ?>
                <button class="shop-action-btn selected" disabled>選択中</button>

              <?php elseif ($isOwned): ?>
                <button class="shop-action-btn owned">選択</button>

              <?php else: ?>
                <button class="shop-action-btn buy">購入</button>
              <?php endif; ?>
            </form>
          </div>
        <?php endforeach; ?>
      </div>
    </section>
  </main>

  <!-- トースト -->
  <?php if (isset($toast)): ?>
    <script>
      alert("<?= $toast ?>");
    </script>
  <?php endif; ?>

</body>

</html>