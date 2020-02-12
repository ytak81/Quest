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
  $post = sanitize($_SESSION['modQust']);

  $dsn = 'mysql:dbname=company;host=localhost;charset=utf8';
  $user = 'root';
  $password = 'root';

  $dbh = new PDO($dsn,$user,$password);
  $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

// lock
$sql = "LOCK TABLES dat_questions WRITE";
$stmt = $dbh->prepare($sql);
$stmt->execute($data);

  $sql = 'UPDATE dat_questions SET dateEnt=?,content=?,org=?,client=?,staff=?,status=?,dateAns=?,answer=?,dateCls=? WHERE code=?';
  $stmt = $dbh->prepare($sql);
  $data[] = $post['dayEntry'];
  $data[] = $post['content'];
  $data[] = $post['client'];
  $data[] = $post['cl_name'];  
  $data[] = $post['staff'];
  $data[] = $post['status'];
  $data[] = $post['dayAns'];
  $data[] = $post['answer'];
  $data[] = $post['dayClose'];
  $data[] = $post['qcode'];
//var_dump($data);
  $stmt->execute($data);

// unlock
$sql = "UNLOCK TABLES";
$stmt = $dbh->prepare($sql);
$stmt->execute($data);  

  $dbh = null;

  print '問い合わせを更新しました。<br>';
  print '<a href="menu.html">メニュー画面に戻る</a>';
  
}

catch (Exception $e) {
  dberror($e);
  exit();
}
?>