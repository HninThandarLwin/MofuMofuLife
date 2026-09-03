<?php
require_once __DIR__ . '/../config/db_connection.php';
require_once './includes/SESSION.php';
 
/* =========================
   ペットデータ
========================= */
$pets = [ // id == pet type 
  ["type" => "hamster", "name" => "ハムスター", "cost" => 0, "img" => "images/pets/hamster/happy.gif", "msg" => "ほっぺがパンパン🌰"],
  ["type" => "yellow_chick", "name" => "ひよこ", "cost" => 100, "img" => "images/pets/yellow_chick/happy.gif", "msg" => "うまれたて🐣"],
  ["type" => "rabbit", "name" => "うさぎ", "cost" => 200, "img" => "images/pets/rabbit/happy.gif", "msg" => "にんじん🥕"],
  ["type" => "cat", "name" => "ねこ", "cost" => 300, "img" => "images/pets/cat/happy.gif", "msg" => "にゃ〜ん🐟"],
  ["type" => "dog", "name" => "いぬ", "cost" => 400, "img" => "images/pets/dog/happy.gif", "msg" => "おさんぽ🦴"],
  ["type" => "fox", "name" => "きつね", "cost" => 500, "img" => "images/pets/fox/happy.gif", "msg" => "こんこん🍂"],
  ["type" => "koala", "name" => "コアラ", "cost" => 600, "img" => "images/pets/koala/happy.gif", "msg" => "ユーカリ🌿"],
  ["type" => "otter", "name" => "カワウソ", "cost" => 700, "img" => "images/pets/otter/happy.gif", "msg" => "かいがら🐚"],
  ["type" => "capybara", "name" => "カピバラ", "cost" => 800, "img" => "images/pets/capybara/happy.gif", "msg" => "のんびり🍊"],
  ["type" => "panda", "name" => "パンダ", "cost" => 900, "img" => "images/pets/panda/happy.gif", "msg" => "たけ🎋"],
];

/* ==============================
  ペット情報   ペット詳細で使用！
============================== */
$petDetails = [
    'rabbit' => [
        'name' => 'うさぎ',
        'personality' => '明るくて、元気いっぱいの性格です。',
        'favorite' => 'にんじん',
        'favorite_icon' => '🥕',
        'description' => 'にんじんと遊ぶことが大好きなうさぎです。一緒にいると毎日を元気に過ごせます。',
        'message' => '今日も一緒にがんばろうね！'
    ],

    'hamster' => [
        'name' => 'ハムスター',
        'personality' => '好奇心が強く、少し食いしん坊です。',
        'favorite' => 'ひまわりの種',
        'favorite_icon' => '🌻',
        'description' => '小さくて元気なハムスターです。タスクを達成すると、とても喜びます。',
        'message' => '少しずつ進めれば大丈夫だよ！'
    ],

    'chick' => [
        'name' => 'ひよこ',
        'personality' => '甘えん坊で、いつも一緒にいたがります。',
        'favorite' => 'とうもろこし',
        'favorite_icon' => '🌽',
        'description' => 'かわいくて元気なひよこです。あなたと一緒に成長していきます。',
        'message' => '今日も楽しく過ごそうね！'
    ],

    'white_cat' => [
        'name' => '白猫',
        'personality' => '少しマイペースですが、やさしい性格です。',
        'favorite' => 'おさかな',
        'favorite_icon' => '🐟',
        'description' => 'のんびりすることが好きな白猫です。一緒にいると心が落ち着きます。',
        'message' => '無理しないで、ゆっくり進もうね。'
    ],

    'cat' => [
        'name' => 'ねこ',
        'personality' => 'やさしくて、かわいい性格です。',
        'favorite' => 'おいしいごはん',
        'favorite_icon' => '🍎',
        'description' => 'あなたと一緒に成長していく大切なペットです。',
        'message' => '今日も一緒にがんばろうね！'
    ],

    'shiba' => [
        'name' => '柴犬',
        'personality' => '元気で忠実な性格です。',
        'favorite' => 'お肉',
        'favorite_icon' => '🍖',
        'description' => 'いつもあなたを応援してくれる柴犬です。タスク達成を一緒に喜びます。',
        'message' => '今日のタスクも一緒にがんばろう！'
    ],

    'panda' => [
        'name' => 'パンダ',
        'personality' => 'おっとりしていて、やさしい性格です。',
        'favorite' => 'たけのこ',
        'favorite_icon' => '🎋',
        'description' => '竹が大好きで、のんびり過ごすのが好きなパンダです。一緒にいると癒やされます。',
        'message' => '一緒にがんばろうね！'
    ]
];

/* =========================
   pet data取得
========================= */
$userPetTypes = getUserPetType($pdo, $userId); //owned pets
$currentPet = getCurrentPetType($pdo, $userId);// selected pet
$userPoint = getUserPoints($pdo , $userId); //user`s point
$ownedPets = getUserPets($pdo, $userId);

$currentPetData = null;
foreach ($pets as $p) {
  if ($p["type"] === $currentPet) {
    $currentPetData = $p;
    $petName = $p["name"];
    break;
  }
}



?>