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

$error_message = "";
$rec = false;

try {
  $post = sanitize($_POST);
  $pass = $post['password'];

  if ($pass == null) {
    $error_message = 'パスワードが入力されていません。';
    $_SESSION['message'] = $error_message;
    print $error_message.'<br>';
    print '<a href="pw.php">パスワード変更画面に戻る</a>';
    exit();
  }

  $account = $_SESSION['account'];

  require_once('db_con.php');
  dbConnect();

  // lock
  dbLock('mst_staff');

  $sql = 'UPDATE mst_staff SET password=? WHERE account=?';
  $stmt = $dbh->prepare($sql);
  $data[] = md5($pass);
  $data[] = $account;
  $stmt->execute($data);
/*  if ($stmt->execute($data)) {
    dump('update ok');
  } else {
    print_r($sql->errorInfo());
  }
*/
  // unlock
  dbUnlock();  

  $dbh = null;

  print 'パスワードが変更されました。';
  print '一旦ログアウトしてください。<br>';
  print '<a href="logout.php">ログアウトへ</a>';
  
}

catch (Exception $e) {
  dberror($e);
  exit();
}
?>