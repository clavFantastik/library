<?php

include "lib/renderfunc.php";
include "lib/format_mysql_date.php";
include "lib/user_session.php";

$db = getDataBase();
$person = get_sess_log();
$pass = get_sess_pass();

if ($person == ''){
  header("Location: /login.php");
}

$privileges = $db->prepare("SELECT login FROM users WHERE privilege = '1'");
$privileges->execute();
$privileges_check = $privileges->fetchall(PDO::FETCH_ASSOC);

if (in_array(array('login' => $person), $privileges_check)){

if(isset($_REQUEST['search'])){
    $ps = $db->prepare("SELECT * FROM articles WHERE by_who = 'admin' AND (title LIKE :search OR content LIKE :search ) ORDER BY created DESC");
    $search = '%' . $_REQUEST['search'] . '%';
    $ps->bindParam(':search', $search);
  }
  else $ps = $db->prepare("SELECT * FROM articles WHERE by_who = 'admin' ORDER BY created DESC ");
  $ps->execute();

  $responceArr = $ps->fetchall();

  $articles_html = '';
  $template = file_get_contents('templates/part/article_manage_tpl.html');


  foreach($responceArr as $article){
    $context = [
      'title' => $article['title'],
      'preview' => mb_strcut($article['preview'], 0, 200).'</strong></i></li></blockquote>...',
      'created' => format_mysql_date($article['created']),
      'id' => $article['id'],
      'img' => $article['img']
    ];
    $articles_html .= render($template, $context);
  }


  $search_text = '';
  if (isset($_REQUEST['search'])) {
    $search_text = $_REQUEST['search'];
  }


  $template = file_get_contents('templates/admin_mainpage_tpl.html');
  $context = [
    'articles' => $articles_html,
    'search' => $search_text,
    'user_name' => $person
  ];
  $page_html = render($template, $context);

  echo $page_html;

}else{

  if(isset($_REQUEST['search'])){
  $ps = $db->prepare("SELECT * FROM articles WHERE users_chosen != '' AND (title LIKE :search OR content LIKE :search ) ORDER BY created DESC");
  $search = '%' . $_REQUEST['search'] . '%';
  $ps->bindParam(':search', $search);
  }
  else $ps = $db->prepare("SELECT * FROM articles WHERE users_chosen != '' ORDER BY created DESC");
  $ps->execute();
  

  $responceArr = $ps->fetchall();
  $articles_html = '';
  $template = file_get_contents('templates/part/article_user_page.html');

  foreach ($responceArr as $article){
      $arr = explode(';', $article['users_chosen']);
      for ($i = 0; $i < count($arr); $i++){
          if ($arr[$i] == $person){

            $context = [
              'title' => $article['title'],
              'preview' => mb_strcut($article['preview'],0,200).'</strong></i></li></blockquote>...',
              'created' => format_mysql_date($article['created']),
              'id' => $article['id'],
              'img' => $article['img'],
              'views' => $article['views']
            ];
            $articles_html .= render($template, $context);
          }
      }    
  }

  $search_text = '';
  if (isset($_REQUEST['search'])) {
    $search_text = $_REQUEST['search'];
  }

  $template = file_get_contents('templates/user_page.html');
  $context = [
    'articles' => $articles_html,
    'search' => $search_text,
    'user_name' => $person
  ];
  $page_html = render($template, $context);

  echo $page_html;
}

?>