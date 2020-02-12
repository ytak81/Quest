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

$post = sanitize($_POST);
$_SESSION['account'] = $post['account2'];

  print '以下のスタッフを削除します。よろしいですか？<br>';
  print 'アカウント：';
  print $post['account2'];
  print '<br>';
  print '名前：';
  print $post['name2'];
  print '<br><br>';
  print '<a href="menu.php">キャンセル</a><br>';
  print '<br>';
  print '<a href="staff_delDB.php">削除</a>';

?>