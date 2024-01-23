<?php

include "lib/renderfunc.php";
include "lib/user_session.php";

if (isset($_REQUEST['title']) or (isset($_REQUEST['preview'])) or (isset($_REQUEST['content']))) {
	$title = $_REQUEST['title'];
	$preview = $_REQUEST['preview'];
	$content = $_REQUEST['content'];
	$check = $_REQUEST['id'];
	$choice = $_REQUEST['choice'];
	$line = '0';
	$arr = count(explode(';', $choice));
	$count = 1;
	while ($count != $arr){
		$line .= ';0';
		$count += 1;
	}

	$db = getDataBase();
	$ps = $db->prepare("UPDATE articles SET title = '$title',preview = '$preview',content = '$content',variants = '$choice',mov = '$line' WHERE id = $check");
	$ps->execute();
	
	header('Location: /admin.php');
} else {

	$db = getDataBase();
	$ps = $db->prepare('SELECT * FROM articles WHERE id=?');
	$ps->execute(array($_REQUEST['id']));
	$responceArr = $ps->fetch(PDO::FETCH_ASSOC);
	$person = get_sess_log();
	$template = file_get_contents('templates/edit_articlepage_tpl.html');

	$context = [
		'title' => $responceArr['title'],
		'created' => $responceArr['created'],
		'preview' => $responceArr['preview'],
		'content' => $responceArr['content'],
		'user_name' => $person,
		'variants' => $responceArr['variants'],
		'img' => $responseArr['img']
	];

	$page_html = render($template, $context);

	echo $page_html;
}

?>