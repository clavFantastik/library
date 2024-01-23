<?php

include "lib/renderfunc.php";
include "lib/format_mysql_date.php";
include "lib/user_session.php";

$db = getDataBase();
$person = get_sess_log();

if ($person == ''){
  header("Location: /login.php");
}

if(isset($_REQUEST['search']) and $_REQUEST['vue'] == 1){
  $ps = $db->prepare("SELECT * FROM articles WHERE title LIKE :search OR content LIKE :search ORDER BY views DESC");
  $search = '%' . $_REQUEST['search'] . '%';
  $ps->bindParam(':search', $search);
}
else if (isset($_REQUEST['vue'])){
  if ($_REQUEST['vue'] == 0) $ps = $db->prepare("SELECT * FROM articles ORDER BY views DESC");
  else $ps = $db->prepare('SELECT * FROM articles ORDER BY created DESC');

}else if(isset($_REQUEST['search']) and  $_REQUEST['vue']==0){
  $ps = $db->prepare("SELECT * FROM articles WHERE title LIKE :search OR content LIKE :search ORDER BY created DESC");
  $search = '%' . $_REQUEST['search'] . '%';
  $ps->bindParam(':search', $search);
}
else $ps = $db->prepare('SELECT * FROM articles ORDER BY created DESC');

$ps->execute();
$responceArr = $ps->fetchall();
$articles_html = '';
$template = file_get_contents('templates/part/article_tpl.html');


foreach($responceArr as $article){
  if (isset($_REQUEST['inout'])){
    if ($article['id'] == $_REQUEST['inout']) $inout='assets/img/in.png';
    else $inout='assets/img/out.png';

  }else $inout='assets/img/out.png';
  
  
  $context = [
    'title' => $article['title'],
    'preview' => mb_strcut($article['preview'],0,200) . '</strong></i>...',
    'created' => format_mysql_date($article['created']),
    'id' => $article['id'],
    'views' => $article['views'],
    'by_who' =>$article['by_who'],
    'img' => $article['img'],
    'by' => get_sess_log(),
    'inout' => $inout
  ];
  $articles_html .= render($template, $context);
}

$search_text = '';
if (isset($_REQUEST['search'])) {
  $search_text = $_REQUEST['search'];
}

$template = file_get_contents('templates/mainpage_tpl.html');
if (isset($_REQUEST['vue'])){
  if ($_REQUEST['vue']==0){
    $context = [
      'articles' => $articles_html,
      'search' => $search_text,
      'user_name'=>get_sess_log(),
      'sort' => "1"
    ];
  }else{
    $context = [
      'articles' => $articles_html,
      'search' => $search_text,
      'user_name'=>get_sess_log(),
      'sort' => "0"
    ];
  }

}else{
  $context = [
    'articles' => $articles_html,
    'search' => $search_text,
    'user_name'=>get_sess_log(),
    'sort' => "0"
  ];
}

$page_html = render($template, $context);

echo $page_html;

?>