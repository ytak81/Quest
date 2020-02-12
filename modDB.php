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
  $post = sanitize($_SESSION['modQust']);

  require_once('db_con.php');
  dbConnect();

  // lock
  dbLock('dat_questions');

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
//dump($data);
  $stmt->execute($data);

  // unlock
  dbUnlock();   

  $dbh = null;

  print '問い合わせを更新しました。<br>';
  print '<a href="menu.php">メニュー画面に戻る</a>';
  
}

catch (Exception $e) {
  dberror($e);
  exit();
}
?>