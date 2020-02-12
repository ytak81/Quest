<meta charset="utf-8">
<?php
session_start();
session_regenerate_id(true);
if (isset($_SESSION['login']) == false) {
  print 'ログインされていません。<br>';
  print '<a href="login.php">ログイン画面へ</a>';
  exit();
} else {
  $message = '新しいスタッフを登録します。';
}

$account = $_SESSION['account'];

?>
<!DOCTYPE html>
<html lang="jp">
<head>
  <meta charset="utf-8">
  <title>お問い合わせ管理</title>
  <link rel="stylesheet" type="text/css" href="cascade.css">
  <style type="text/css">
    header {
      background-color: skyblue;
    }
  </style>
</head>
<body>
<header>
  <h1>スタッフ追加</h1>
  <nav>
    <div><form method="post" action="menu.php">
      <input id="hbtn1" type="submit" value="メニューに戻る">
    </form></div>
    <div>　　　</div>
    <div><form method="post" action="logout.php">
      <input id="hbtn2" type="submit" value="ログアウト">
    </form></div>
  </nav>
  <p class="msg"><?php echo($message); ?></p>
</header>
<main class="maina">
  <h3>アカウント: <?php echo($account); ?></h3>
  <form method="post" action="staff_chk.php">
    <input type="hidden" name="flag" value="0">
    <input type="hidden" name="account" value="<?php echo($account); ?>">
  <br>
    <h3><label for="i1">名前　　　:</label>
    <input id="i1" type="text" name="name" maxlength="15"></h3>
  <br>
    <h3><label for="i2">パスワード:</label>
    <input id="i2" type="password" name="password" maxlength="16"></h3>
  <br>
    <h3><label for="i3">権限　　　:</label>
    <input id="i3" type="radio" name="authority" value="1" >管理者
    <input id="i3" type="radio" name="authority" value="0" checked = "checked">担当者</h3>
  <br>
    <input class="btnR" type="submit" value="　追　加　">
  </form>
</main>
<footer>
  <h6>copywright 2020-2020 Takeyama Yoshito</h6>
</footer>
</body>
</html>