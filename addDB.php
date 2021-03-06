<meta charset="utf-8">
<?php
session_start();
session_regenerate_id(true);
if (isset($_SESSION['login']) == false) {
  print 'ログインされていません。<br>';
  print '<a href="login.php">ログイン画面へ</a>';
  exit();
}
require_once('common.php');

try {
  $post = sanitize($_SESSION['addQust']);

  require_once('db_con.php');
  dbConnect();

  // lock
  dbLock('dat_questions');

  $sql = 'INSERT INTO dat_questions (dateEnt,content,org,client,staff,status,dateAns,answer,dateCls) VALUES (?,?,?,?,?,?,?,?,?)';
  $stmt = $dbh->prepare($sql);
  foreach ($post as $key => $val) {
    $data[] = $val;
  }
//var_dump($data);
  $stmt->execute($data);

  // unlock
  dbUnlock();   

  $dbh = null;
  
  $_SESSION['backflag'] = false;

  print '問い合わせを追加しました。<br>';
  print '<a href="add.php">お問い合わせ登録画面に戻る</a>';
  
}

catch (Exception $e) {
  dberror($e);
  exit();
}
?>