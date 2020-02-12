<meta charset="utf-8">
<?php
session_start();
session_regenerate_id(true);
if (isset($_SESSION['login']) == false) {
  print 'ログインされていません。<br>';
  print '<a href="login.php">ログイン画面へ</a>';
  exit();
} else {
  $account = $_SESSION['account'];
  $name = $_SESSION['staff_name'];
}
?>
<!DOCTYPE html>
<html lang="jp">
<head>
  <meta charset="utf-8">
  <title>お問い合わせ管理</title>
  <link rel="stylesheet" type="text/css" href="cascade.css">
  <style type="text/css">
    header{
      background-color: gold;
    }
  </style>
</head>
<body>
<header>
  <h1>パスワード変更</h1>
  <nav>
    <div><form method="post" action="menu.php">
      <input id="hbtn1" type="submit" value="メニューに戻る">
    </form></div>
  </nav>
  <p class="msg">パスワードを変更できます。</p>
</header>
<main class="maina">
  <form method="post" action="pw_chk.php">
    <h3>アカウント:　<?php print $account; ?></h3>
    <br>
    <h3>　名　前　:　<?php print $name; ?></h3>
    <br>
    <h3><label for="password">パスワード:</label>
    <input id="text2" type="password" name="password" col="20"　maxlength="16"></h3>
  <br>
    <input class="btnR" type="submit" value="　変　更　">
  </form>
</main>
<footer>
  <h6>copywright 2020-2020 Takeyama Yoshito</h6>
</footer>
</body>
</html>