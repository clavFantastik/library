<?php

include "lib/renderfunc.php";
$db = getDataBase();

if (isset($_REQUEST['id']) or (isset($_REQUEST['u_c']))) {
    $id = $_REQUEST['id'];
	$u_c = $_REQUEST['u_c'];
    $ps = $db->prepare("SELECT * FROM articles WHERE id = $id");
    $ps->execute();
    $mass_check = 0;
    $responceArr = $ps->fetch(PDO::FETCH_ASSOC);
    $check = count(explode(';', $responceArr['users_chosen']));

    if ($check > 0){
        $users_chosen_arr = explode(';', $responceArr['users_chosen']);
        for ($i = 0; $i < count($users_chosen_arr); $i++){
            if ($users_chosen_arr[$i] == $u_c) {
                $mass_check = 1;
            }
        }

            if ($mass_check != 1){
                $arr = $responceArr['users_chosen'] . $u_c . ';';
                $ps = $db->prepare("UPDATE articles SET users_chosen = '$arr' WHERE id = $id");
    	        $ps->execute();
            }
            
        
        
    }else{
        $arr = $u_c . ';';
        $ps = $db->prepare("UPDATE articles SET users_chosen = '$arr' WHERE id = $id");
	    $ps->execute();
    }

  header("Location: /index.php?inout=$id");

} else header('Location: /index.php');

?>