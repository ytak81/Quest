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

// スタッフ名の取得
require_once('db_con.php');
dbConnect();

$sql = 'SELECT code,account,name FROM mst_staff WHERE 1';
$stmt = $dbh->prepare($sql);
$stmt->execute();

$json = '[';
while(true) {
  $rec = $stmt->fetch(PDO::FETCH_ASSOC);
  if ($rec == false) {
    break;
  }
  if ($json != '[')  {
    $json .= ',';      
  }
  $json .= '{"account":"';
  $json .= $rec['account'];
  $json .= '","name":"';
  $json .= $rec['name'];
/*  $json .= '","select":';
  if ($qcode == $rec['code'] ) {
    $json .= 1;
  } else {
    $json .= 0;    
  } */
  $json .= '"}';
}
$json .= ']';  

$_SESSION['staffAll'] = $json;

$dbh = null;

// 受付担当者名の表示
  // 管理者と担当者とで、表示するメニューを切り替え
  if ($_SESSION['authority'] == 0) {
    $s0 = "show";
    $s1 = "hide";
    $c_staff = "hide";
    $c_pw = "show";
  } else {
    $c_staff = "show";
    $c_pw = "hide";
    $s0 = "hide";
    $s1 = "show";
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
      background-color: #aabb00;
    }
    .show {
      display : block;
    }
    .hide {
      display : none;
    }
  </style>
    <!-- DatePicker  -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
      <!-- CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/themes/base/jquery-ui.min.css">
      <!-- Datepickerを日本語化する -->
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1/i18n/jquery.ui.datepicker-ja.min.js"></script>
  <!-- DatePicker end -->
  <!-- Adding a Timepicker to jQuery UI Datepicker  -->
    <script src="./jquery-ui-timepicker-addon.min.js"></script>
    <script src="./jquery-ui-timepicker-ja.js"></script>
    <link rel="stylesheet" href="./jquery-ui-timepicker-addon.min.css">
  <!-- Adding a Timepicker to jQuery UI Datepicker end -->
  <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
  <script>
    var json = '<?php echo $json; ?>';
  </script>
  <script src="menu.js"></script>
</head>
<body>
<header>
  <h1>お問い合わせ管理　メニュー</h1>
  <nav>
    <form method="post" action="logout.php">
      <input id="hbtn2" type="submit" value="ログアウト">
    </form>
  </nav>
  <p class="msg"><?php echo($message); ?></p>
</header>
<main class="maina">
  <h3><a href="add.php">新規登録</a></h3>
  <br>
  <h3>参照・編集</h3>
  <form method="post" action="refDB.php" autocomplete="off">
    <div id="staff1" class="<?php echo $s0 ?>">
      <h4>・スタッフ　: <?php print $_SESSION['staff_name'];?></h4></div>
    <input type="hidden" name="staff0" value="<?php print $_SESSION['staff_name']; ?>"></h4>
    <div id="staff2" class="<?php echo $s1 ?>">
      <h4>・スタッフ　: 
      <select id="staff" name="staff1">
        <option value="all" selected>全員</option>
      </select></h4></div>
    <h4>・受付日時　: 
      <input id="dayStart" type="text" name="dayStart" size="25">〜
      <input id="dayEnd" type="text" name="dayEnd" size="25"></h4>
    <h4>・状況　　　: 
      <input type="radio" name="status" value="9" checked = "checked">すべて
      <input type="radio" name="status" value="0">未着手
      <input type="radio" name="status" value="1">調査中
      <input type="radio" name="status" value="2">回答済
      <input type="radio" name="status" value="3">完了
    </h4>
    <h4>・内容　　　: 
      <input id="keyword" type="text" name="keyword" size="25"></h4>
    <input class="btnR" type="submit" value="　検　索　">
  </form>
  <br>
  <div id="staffMente" class="<?php echo $c_staff ?>">
    <h3>スタッフ登録</h3>
    <form method="post" action="staff_branch.php">
      <h4>・アカウント:
      <input id="txt1" type="text" name="account" maxlength="5"><span class="msg">※半角英数</span></h4>
      <input class="btnR" type="submit" value="スタッフ登録">
    </form></div>
  <br>
  <h3 class="<?php echo $c_pw ?>" ><a href="pw.php">パスワード変更</a></h3>
</main>
<footer>
  <h6>copywright 2020-2020 Takeyama Yoshito</h6>
</footer>
</body>
</html>