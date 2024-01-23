<?php

include "lib/renderfunc.php";
$db = getDataBase();
$ps = $db->prepare("DELETE FROM `articles` WHERE `id` = {$_REQUEST['id']}");
$ps->execute();

header('Location: /admin.php');

?>