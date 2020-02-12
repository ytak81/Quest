<?php
session_start();
session_regenerate_id(true);
if (isset($_SESSION['login']) == false) {
  print 'ログインされていません。<br>';
  print '<a href="login.php">ログイン画面へ</a>';
  exit();
}

require_once('common.php');

$post = sanitize($_POST);
$account = $_POST['account'];

if (mb_strlen($account) == 0) {
  $message = '';
  print 'アカウントが未入力です。<br>';
  print '<a href="menu.php">メニュー画面へ</a>';
  exit();
}

$rec = false;

try {
  require_once('db_con.php');
  dbConnect();

  $sql = 'SELECT name,password,authority FROM mst_staff WHERE account=?';
  $stmt = $dbh->prepare($sql);
  $data[] = $account;

  $stmt->execute($data);
  
  $rec = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($rec) {
    // 更新・削除処理へ
    $_SESSION['account'] = $account;
    $_SESSION['name'] = $rec['name'];
    $_SESSION['password'] = $rec['password'];
    $_SESSION['auth2'] = $rec['authority'];
    header('Location:staff_mod.php');

  } else {
    // 追加処理へ
    $_SESSION['account'] = $account;
    header('Location:staff_add.php');
  }
}

catch (Exception $e) {
  dberror($e);
  exit();
}
?>