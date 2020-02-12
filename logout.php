<?php
session_start();
$_SESSION = array();
if (isset($_COOKIE[session_name()]) == true) {
  setcookie(session_name(),'',time()-42000,'/');
} 
session_destroy();
?>
<!DOCTYPE html>
<html lang="jp">
<head>
  <meta charset="utf-8">
  <title>お問い合わせ管理</title>
  <link rel="stylesheet" type="text/css" href="login.css">
</head>
<body>
ログアウトしました。<br>
<br>
<a href="login.php">ログイン画面へ</a>
</body>
</html>