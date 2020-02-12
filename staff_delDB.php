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
  require_once('db_con.php');
  dbConnect();

  // lock
  dbLock('mst_staff');

  $sql = 'DELETE FROM mst_staff WHERE account=?';
  $stmt = $dbh->prepare($sql);
  $data[] = $_SESSION['account'];
//var_dump($data);
  $stmt->execute($data);

  // unlock
  dbUnlock();   

  $dbh = null;

  print 'スタッフを削除しました。<br>';
  print '<a href="menu.php">メニュー画面に戻る</a>';
  
}

catch (Exception $e) {
  dberror($e);
  exit();
}
?>