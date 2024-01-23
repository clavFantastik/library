<?php

include "lib/renderfunc.php";
$db = getDataBase();

if (isset($_REQUEST['id']) or (isset($_REQUEST['u_c']))) {
    $id = $_REQUEST['id'];
	$u_c = $_REQUEST['user_name'];
    $ps = $db->prepare("SELECT * FROM articles WHERE id = $id");
    $ps->execute();
    $mass_check = 0;

    $responceArr = $ps->fetch(PDO::FETCH_ASSOC);
    $ch = explode(';', $responceArr['users_chosen']);
    
    
    $u_i=0;

    for ($i=0;$i<count($ch);$i++){
        if ($ch[$i]==$u_c) $u_i=$i;
    }
    unset($ch[$u_i]);
    $arr = '';
    for ($i = 0; $i <= count($ch); $i++){
        if ($ch[$i] != '') $arr .= $ch[$i] . ';';
    }
            
    $ps = $db->prepare("UPDATE articles SET users_chosen = '$arr' WHERE id = $id");
    $ps->execute();
    header("Location: /admin.php");
    
    }
    
?>