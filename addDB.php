<meta charset="utf-8">
<?php
session_start();
session_regenerate_id(true);
if (isset($_SESSION['login']) == false) {
  print 'ログインされていません。<br>';
  print '<a href="login.html">ログイン画面へ</a>';
  exit();
}
require_once('common.php');

try {
  $post = sanitize($_SESSION['addQust']);

  $dsn = 'mysql:dbname=company;host=localhost;charset=utf8';
  $user = 'root';
  $password = 'root';

  $dbh = new PDO($dsn,$user,$password);
  $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

// lock
$sql = "LOCK TABLES dat_questions WRITE";
$stmt = $dbh->prepare($sql);
$stmt->execute($data);

  $sql = 'INSERT INTO dat_questions (dateEnt,content,org,client,staff,status,dateAns,answer,dateCls) VALUES (?,?,?,?,?,?,?,?,?)';
  $stmt = $dbh->prepare($sql);
  foreach ($post as $key => $val) {
    $data[] = $val;
  }
//var_dump($data);
  $stmt->execute($data);

// unlock
$sql = "UNLOCK TABLES";
$stmt = $dbh->prepare($sql);
$stmt->execute($data);  

  $dbh = null;
  
  $_SESSION['backflag'] = false;

  print '問い合わせを追加しました。<br>';
  print '<a href="add.html">お問い合わせ登録画面に戻る</a>';
  
}

catch (Exception $e) {
  dberror($e);
  exit();
}
?>