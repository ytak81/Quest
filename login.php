<!DOCTYPE html>
<html lang="jp">
<head>
  <meta charset="utf-8">
  <title>お問い合わせ管理</title>
  <link rel="stylesheet" type="text/css" href="cascade.css">
</head>
<body>
<header>
  <h1>お問い合わせ管理　ログイン</h1>
  <br>
  <p class="msg">お問い合わせ管理へようこそ！</p>
</header>
<main class="maina">
  <form method="post" action="login_chk.php">
    <h3><label for="account">アカウント:</label>
    <input id="text1" type="text" name="account" value="<?php print $self; ?>"></h3>
    <br>
    <h3><label for="password">パスワード:</label>
    <input id="text2" type="password" name="password" col="20"></h3>
  <br>
    <input class="btnR" type="submit" value="ログイン">
  </form>
</main>
<footer>
  <h6>copywright 2020-2020 Takeyama Yoshito</h6>
</footer>
</body>
</html>