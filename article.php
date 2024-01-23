<?php

include "lib/renderfunc.php";
include "lib/format_mysql_date.php";
include "lib/user_session.php";

$db = getDataBase();

$ps = $db->prepare('SELECT * FROM articles WHERE id=?');
$ps->execute(array($_REQUEST['id']));
$responceArr = $ps->fetch(PDO::FETCH_ASSOC);
$exact = $_REQUEST['id']; 
$view = $responceArr['views'];
$viewed = $view + view_page($exact);
$template = file_get_contents('templates/articlepage_tpl.html');
$created_date = format_mysql_date($responceArr['created']);
	
$person = get_sess_log();
$pass = get_sess_pass();

if ($person == ''){
	header("Location: /login.php");
}

$viewer = $db->prepare("UPDATE articles SET views = '$viewed' WHERE id = $exact");
$viewer->execute();

$ps2 = $db->prepare("SELECT * FROM comments WHERE id_of_vote = '$exact' ORDER BY created DESC");
$ps2->execute();
$responceArr3 = $ps2->fetchAll();

$articles_html = '';
$template2 = file_get_contents('templates/part/comment.html');

foreach($responceArr3 as $article){

	$context = [
	'user_name' => $article['by_who'],
	'text' => $article['text'],
	'created' => format_mysql_date($article['created'])
	
	];
	$articles_html .= render($template2, $context);
}

if ($articles_html=='') $articles_html='<br/>Никто еще не комментировал, будь первым!';
if (isset($_REQUEST['comm'])){
	$comm = $_REQUEST['comm'];
	$ps5 = $db->prepare("INSERT INTO comments (created,by_who, text, id_of_vote) VALUES (NOW(), '$person', '$comm', '$exact')");
	$ps5->execute();

	header("Location: /article.php?id=$exact");
}

if ($responceArr['variants'] == '') $vaity = 'rer';
else $vaity = $responceArr['variants'];

$context = [
	'title' => $responceArr['title'],
	'created' => $created_date,
	'content' => $responceArr['content'],
	'user_name' => $person,
	'comments' => $articles_html,
	'variants' => $vaity,
	'by' => $responceArr['by_who'],
	'mov' => $responceArr['mov'],
	'id' => $responceArr['id'],
	'img' => $responceArr['img']
];

$page_html = render($template, $context);

echo $page_html;

?>