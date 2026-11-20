<?php

require_once './database/data_loading.php';
require_once './database/data_update.php';
require_once './database/pet_system.php';
require_once './includes/pet_info.php';
require_once './includes/SESSION.php';

$currentPage = 'pet_detail';
var_dump($_SERVER['REQUEST_METHOD']);
var_dump($_POST);
?>

<form method="POST">
    <input type="hidden" name="petType" value="hamster">
    <button type="submit">TEST</button>
</form>