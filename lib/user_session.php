<?php

function view_page($id){
    if(in_array($id, $_SESSION["view"])){
        return 0; 
    }else{
        array_push($_SESSION["view"], $id);
        return 1;
    }
}


function set_id($id){
    session_id($id);
    
}


session_start();
    
function status(){
    return session_status();
}


function us_sess($log, $pass) {
    
    $_SESSION["login"] = $log;
    $_SESSION["password"] = $pass;
    $_SESSION['view'] = [0];
    
}

function get_sess_log(){
    return $_SESSION["login"];
}


function get_sess_pass(){
    return $_SESSION["password"];
}

function destroy_sess(){
    session_destroy();
    
}
    
?>