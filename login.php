<?php

include "lib/renderfunc.php";
include "lib/user_session.php";
$db = getDataBase();

if ($_REQUEST['login'] != '' and $_REQUEST['password'] != '') {
	
	$check=0;
	$user_login = $_REQUEST['login'];
	$user_password = $_REQUEST['password'];
	$request = $db->prepare("SELECT * FROM users");
	$request->execute();
	$arr = $request->fetchAll();
	
	foreach ($arr as $el){
		if ($el['login'] == $user_login and $el['password'] == $user_password) $check=1;
		else if ($el['login'] == $user_login and $el['password'] != $user_password) $check=2;
	}	
	

	if ($check == 1){	
        if(status() != 2) set_id($user_login);

        us_sess($user_login, $user_password);  
		header("Location: /admin.php");
	}else{
		$template = file_get_contents('templates/login.html');
		if ($check==2){
			$context = [
				'ans' => '<span style="margin-right:5px"
				uk-icon="warning"></span> Неправильный пароль'
			  ];
		}else {
			$context = [
				'ans' => '<span style="margin-right:5px"
				uk-icon="warning"></span> Проверьте верность данных'
			  ];
		}
		

		echo render($template, $context);
	}
	
	
 
} else {

	$template = file_get_contents('templates/login.html');
	$context = [
		'ans' => ''
	  ];

	echo render($template, $context);
}

?>