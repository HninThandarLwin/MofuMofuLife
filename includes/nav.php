<?php
require_once './database/data_loading.php';
require_once './database/pet_system.php';
require_once './includes/pet_info.php';
require_once './includes/SESSION.php';

if (empty($petName) || $petName == null) {
  $hasPet = false;
} else {
  $hasPet = true;
}

if ($hasPet) {
  $navHp = getPetHp($pdo, $currentPet, $userId);
  $navLv = getPetLevel($pdo, $currentPet, $userId);
  $navImg = getPetImage($currentPet, $navHp, $navLv);
}

?>

<aside class="sidebar">
  <div class="sidebar-logo">
    <span class="logo-icon">🐾</span>
    <span class="logo-text">モフモフLife</span>
  </div>

  <div class="sidebar-points">
    <div class="points-label">⭐ ポイント</div>
    <div class="points-value" id="pointDisplay">
      <?= $userPoint ?> pt
    </div>
  </div>

  <?php if ($hasPet): ?>
    <div class="sidebar-pet">
        <img id="petImage"
            src="<?= $navImg ?>"
            alt="ペット"
            class="pet-img" />

        <div class="pet-info">
            <div class="pet-name" id="petName">
                <?= $petName ?>
            </div>
            <div class="pet-msg" id="petMessage">
                タスクをこなして育ててね！
            </div>
        </div>
    </div>
<?php endif; ?>

<!-- Pet detail popup -->
<?php if (!$hasPet && $currentPage !== 'shop'): ?>
    <form id="buyPetPopUp">
        <p>ペット詳細でペット飼ってください。</p>

        <button type="button"
            onclick="location.href='./shop.php'">
            ペットショップ
        </button>

        <button type="button"
            onclick="document.getElementById('buyPetPopUp').style.display='none'">
            あとで
        </button>
    </form>
<?php endif; ?>

  <nav class="sidebar-nav">
    <button class="nav-btn <?= $currentPage === 'dash' ? 'active' : '' ?>"
      onclick="location.href='dashboard.php'">
      📋 ダッシュボード
    </button>

    <button class="nav-btn <?= $currentPage === 'calendar' ? 'active' : '' ?>"
      onclick="location.href='index.php'">
      📅 カレンダー
    </button>

    <button class="nav-btn <?= $currentPage === 'shop' ? 'active' : '' ?>"
      onclick="location.href='shop.php'">
      🏪 ペットショップ
    </button>

    <?php if ($hasPet): ?>
      <button class="nav-btn <?= $currentPage === 'pet-detail' ? 'active' : '' ?>"
        onclick="location.href='pet_detail.php'">
        🐾 ペット詳細
      </button>
    <?php endif; ?>

    <button class="nav-btn logout-btn"
      onclick="location.href='logout.php'">
      <img src="images/logout.jpg" class="nav-icon" alt="ログアウト" />
      ログアウト
    </button>
  </nav>


</aside>

</form>