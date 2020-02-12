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

  $post = sanitize($_POST);
  $flag = $post['flag'];
  $account = $post['account'];
  $name = $post['name'];
  $pass = $post['password'];
  $authority = $post['authority'];

  if ($name == null) {
    $error_message = '名前が入力されていません。';
    $_SESSION['message'] = $error_message;
    print $error_message.'<br>';
    if ($flag == 0) {
      print '<a href="staff_add.php">スタッフ登録画面に戻る</a>';
    } else {
      print '<a href="staff_mod.php">スタッフ更新／削除画面に戻る</a>';
    }
    exit();
  }
  
  if ($pass == null) {
    $error_message = 'パスワードが入力されていません。';
    $_SESSION['message'] = $error_message;
    print $error_message.'<br>';
    if ($flag == 0) {
      print '<a href="staff_add.php">スタッフ登録画面に戻る</a>';
    } else {
      print '<a href="staff_mod.php">スタッフ更新／削除画面に戻る</a>';
    }
    exit();
  }

  $_SESSION['account'] = $account;
  $_SESSION['name'] = $name;
  $_SESSION['password'] = $pass;
  $_SESSION['auth2'] = $authority;

if ($flag == 0) {
  header('Location:staff_addDB.php');
} else {
  header('Location:staff_modDB.php');
}

?>