<?php

include "lib/renderfunc.php";
include "lib/user_session.php";

$db = getDataBase();

if ($_REQUEST['login'] != '' and $_REQUEST['password'] != '' and $_REQUEST['repassword'] != '' and $_REQUEST['repassword'] == $_REQUEST['password']) {
	$user_login = $_REQUEST['login'];
	$user_password = $_REQUEST['password'];
	$ps = $db->prepare("SELECT * FROM users");
	$ps->execute();
	$arr = $ps->fetchAll();
	$check = 1;
	foreach ($arr as $el){
		if ($el['login'] == $user_login) $check = 0;
	}
	
	if ($check == 1 and strlen($_REQUEST['password']) > 7){
		$ps = $db->prepare("INSERT INTO users (login,password,privilege) VALUES ('$user_login','$user_password','0')");
		$ps->execute();
		if(status() != 2) set_id($user_login);
        
        us_sess($user_login, $user_password);
		header('Location: /admin.php');

	}else if ($check == 0){
		$template = file_get_contents('templates/sign.html');
		$context = [
			'ans' => '<span style="margin-right:5px"
			uk-icon="warning"></span> Такой пользователь уже есть'
		  ];
		echo render($template, $context);

	}else if (strlen($_REQUEST['password'])<=7){
	    $template = file_get_contents('templates/sign.html');
		$context = [
			'ans' => '<span style="margin-right:5px"
			uk-icon="warning"></span> Пароль должен содержать не менее 8 символов, а также содержать символы верхнего и нижнего регистра и цифры'
		  ];
		echo render($template, $context);
	}

}else{
	$template = file_get_contents('templates/sign.html');
	$context = [
		'ans' => ''
	  ];
	echo render($template,$context);

}

?>