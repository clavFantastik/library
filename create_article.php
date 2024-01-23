<?php

include "lib/renderfunc.php";
include "lib/user_session.php";

if (isset($_REQUEST['title']) and (isset($_REQUEST['preview'])) and (isset($_REQUEST['content']))) {
	$title = $_REQUEST['title'];
	$preview = $_REQUEST['preview'];
	$content = $_REQUEST['content'];
	$choice = $_REQUEST['choice'];
	$wrapper = $_REQUEST['img'];
	$line = '0';
	$arr = count(explode(';',$choice));
	$count = 1;
	while ($count != $arr){
		$line .= ';0';
		$count += 1;
	}

	$db = getDataBase();
	$person = get_sess_log();
	$ps = $db->prepare("INSERT INTO articles (title,preview,content, created, by_who,variants, views, mov,voters,vov,img,users_chosen) VALUES ('$title','$preview','$content', NOW(), '$person', '$choice', 0, '$line','','','$wrapper','')");
	$ps->execute(array($_REQUEST['id']));
	$responceArr = $ps->fetch(PDO::FETCH_ASSOC);

	header("Location: /admin.php");
} else {

	$context=[
		'user_name' => get_sess_log()
	];

	$template = file_get_contents('templates/create_articlepage_tpl.html');
	$page_html = render($template, $context);

	echo $page_html;
}

?>