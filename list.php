<meta charset="utf-8">
<?php
session_start();
session_regenerate_id(true);
if (isset($_SESSION['login']) == false) {
  print 'ログインされていません。<br>';
  print '<a href="login.php">ログイン画面へ</a>';
  exit();
} else {
  $message = $_SESSION['staff_name'].'さんログイン中。';
}

// 更新画面へ情報を渡す　・・・【重要！】消さないこと
$_SESSION['backflag'] = false;

// 問い合わせ情報の取得
$json2 = $_SESSION['QUEST'];

// 受付担当者名の表示
  // 管理者と担当者とで、表示するメニューを切り替え
  if ($_SESSION['authority'] == 0) {
    $d1 = "hide";
  } else {
    $d1 = "show";
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
      background-color: white;
    }
    .show {display : block;}
    .hide {display : none;}
  </style>
  <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
  <script>
    var json2 = '<?php echo $json2; ?>';
  </script>
  <script src="list.js"></script>
</head>
<body>
<header>
  <h1>お問い合わせ一覧</h1>
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
  <form id="postMod" method="post" action="mod.php">
    <input type="hidden" name="backflag" value="false">
  </form>
</header>
<main class="mainb">
  <div class="<?php echo $d1 ?>" style="background-color: yellow;">
    <form method="post" action="download.php">
      <input type="submit" value="ダウンロード画面へ">
    </form>
    <h3>このボタンをクリックすると、下記に表示された問い合わせをcsvファイルにダウンロードします。</h3>
  </div>
  <table>
    <tr>
      <th width="80px">受付日</th>
      <th width="50px">ｽﾀｯﾌ</th>
      <th width="80px">状況</th>
      <th width="100px">顧客会社</th>
      <th width="50px">担当者</th>
      <th width="150px">内容</th>
      <th width="80px">回答日</th>
      <th width="80px">完了日</th>
      <th width="50px" class="hidden">code</th>
    </tr>
  </table>
</main>
<footer>
  <h6>copywright 2020-2020 Takeyama Yoshito</h6>
</footer>
</body>
</html>