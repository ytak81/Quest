<meta charset="utf-8">
<?php
require_once('common.php');

$error_message = "";
$rec = false;

try {
  session_start();

  $post = sanitize($_POST);
  $account = $post['account'];
  $pass = $post['password'];

  if ($account == null) {
    $error_message = 'アカウントが入力されていません。';
    $_SESSION['message'] = $error_message;
    print $error_message.'<br>';
    print '<a href="login.php">ログイン画面に戻る</a>';
    exit();
  }
  if ($pass == null) {
    $error_message = 'パスワードが入力されていません。';
    $_SESSION['message'] = $error_message;
    print $error_message.'<br>';
    print '<a href="login.php">ログイン画面に戻る</a>';
    exit();
  }
  
  $_SESSION['account'] = $account;

  require_once('db_con.php');
  dbConnect();

  $sql = 'SELECT name,authority FROM mst_staff WHERE account=? AND password=?';
  $stmt = $dbh->prepare($sql);
  $data[] = $account;
  $data[] = md5($pass);

  $stmt->execute($data);

  $dbh = null;

  $rec = $stmt->fetch(PDO::FETCH_ASSOC);
  
  if ($rec == true) {
    $_SESSION['login'] = 1;
    $_SESSION['account'] = $account;
    $_SESSION['staff_name'] = $rec['name'];
    $_SESSION['authority'] = $rec['authority'];
    header('Location:menu.php');
    exit();
  } else {
    $error_message = 'アカウントかパスワードが間違っています。';
    $_SESSION['message'] = $error_message;
    print $error_message.'<br>';
    print '<a href="login.php">ログイン画面に戻る</a>';
  }
}

catch (Exception $e) {
  dberror($e);
  exit();
}
?>