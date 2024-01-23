<?php

include "lib/renderfunc.php";

if (isset($_REQUEST['res_of_vars']) and isset($_REQUEST['res_of_id']) and isset($_REQUEST['cur_user'])) {
	$vars_counter = $_REQUEST['res_of_vars'];
	$id = $_REQUEST['res_of_id'];
    $user = $_REQUEST['cur_user'];


    $db = getDataBase();
	$ps = $db->prepare('SELECT * FROM articles WHERE id = ?');
	$ps->execute(array($id));
	$responceArr = $ps->fetch(PDO::FETCH_ASSOC);
    $mov = $responceArr['mov'];
    $voters = $responceArr['voters'];
    $voters_arr = explode(';', $voters);
    $check = 0;

    foreach($voters_arr as $vote){
        if ($vote == $user) $check = 1;

    }
    
	if ($check == 0){
        $arr = explode(';', $mov);
        $arr[$vars_counter] = strval(intval($arr[$vars_counter]) + 1);
        $line = $arr[0];
        
        
        $count = 1;
        while ($count != count($arr)){
            $line .= ';' . $arr[$count];
            $count += 1;
        }
        $line2 = '';
        $line3 = '';
        if($voters_arr[0] == ''){
            
            $line2 .= strval($user) . ';';
            $line3 .= strval($vars_counter) . ';';

        }
        else {
            $vov = $responceArr['vov'];
            $line2 .= $voters.strval($user) . ";";
            $line3 .= $vov.strval($vars_counter) . ";";

        }


        $ps = $db->prepare("UPDATE articles SET mov = '$line',voters = '$line2',vov = '$line3' WHERE id = $id");
        $ps->execute();
    
        header("Location: /article.php?id=$id");
    }else{
        $choice = $responceArr['vov'];
        $choice_arr = explode(';', $choice);
        $arr = explode(';', $responceArr['voters']);
        $u_i = 0;
        foreach($arr as $el){
            if ($el == $user){
                break;
            }
            $u_i += 1;
        }

        if ($choice_arr[$u_i] == $vars_counter){
            $arr = explode(';', $mov);
            $arr[$vars_counter] = strval(intval($arr[$vars_counter]) - 1);
            $line = $arr[0];
            $vov = $responceArr['vov'];


            $vov_arr = explode(';', $vov);
            $count = 1;
            while ($count != count($arr)){
                $line .= ';' . $arr[$count];
                $count += 1;
            }
            $line2 = '';
            $line3 = '';
            unset($voters_arr[$u_i]);
            unset($vov_arr[$u_i]);

            foreach ($voters_arr as $vote){
                if ($t != '') $line2 .= $vote . ';';
            }


            foreach ($vov_arr as $v){
                if ($t != '') $line3 .= $v . ';';
            }

            
            $ps = $db->prepare("UPDATE articles SET mov = '$line',voters = '$line2',vov = '$line3' WHERE id = $id");
            $ps->execute();
        
            header("Location: /article.php?id=$id");


        }else{
            header("Location: /article.php?id=$id");
        }
    }

} 

?>