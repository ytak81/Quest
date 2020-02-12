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
    print '<a href="login.html">ログイン画面に戻る</a>';
    exit();
  }
  if ($pass == null) {
    $error_message = 'パスワードが入力されていません。';
    $_SESSION['message'] = $error_message;
    print $error_message.'<br>';
    print '<a href="login.html">ログイン画面に戻る</a>';
    exit();
  }

  $dsn = 'mysql:dbname=company;host=localhost;charset=utf8';
  $user = 'root';
  $password = 'root';

  $dbh = new PDO($dsn,$user,$password);
  $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

  $sql = 'SELECT name FROM mst_staff WHERE account=? AND password=?';
  $stmt = $dbh->prepare($sql);
  $data[] = $account;
  $data[] = $pass;
//dump($data);
  $stmt->execute($data);

  $dbh = null;

  $rec = $stmt->fetch(PDO::FETCH_ASSOC);

  $_SESSION['account'] = $account;
  if ($rec == true) {
    $_SESSION['login'] = 1;
    $_SESSION['staff_name'] = $rec['name'];
    header('Location:menu.html');
    exit();
  } else {
    $error_message = 'アカウントかパスワードが間違っています。';
    $_SESSION['message'] = $error_message;
    print $error_message.'<br>';
    print '<a href="login.html">ログイン画面に戻る</a>';
  }
}

catch (Exception $e) {
  dberror($e);
  exit();
}
?>