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

require_once('common.php');

try {
  
require_once('db_con.php');
dbConnect();

$sql = 'SELECT name FROM mst_staff WHERE 1';
$stmt = $dbh->prepare($sql);
$stmt->execute();

$lists = [];
while(true) {
  $rec = $stmt->fetch(PDO::FETCH_ASSOC);
  if ($rec == false) {
    break;
  }
  $lists[] = $rec['name'];
}

$dbh = null;

// 画面表示項目の編集
//   A)メニュー画面から遷移した場合 (backflag==false)
//   B)確認画面から戻した場合 (backflag==true)
if ($_SESSION['backflag'] == false) {

  $dayEntry = '';
  $content = '';
  $client = '';
  $cl_name = '';  

  $status = '0';  // 初期値は「未着手」
  $dayAns = '';
  $answer = '';
  $dayClose = '';
  
} else {
  $qust = sanitize($_SESSION['addQust']);
  $dayEntry = $qust['dayEntry'];
  $content = $qust['content'];
  $client = $qust['client'];
  $cl_name = $qust['cl_name'];  

  $status = $qust['status'];
  $dayAns = $qust['dayAns'];
  $answer = $qust['answer'];
  $dayClose = $qust['dayClose'];

  $_SESSION['backflag'] = false;
}
  //var_dump($status);
}

catch (Exception $e) {
  dberror($e);
  exit();
}

?>
<!DOCTYPE html>
<html lang="jp">
<head>
  <meta charset="utf-8">
  <title>お問い合わせ管理</title>
  <link rel="stylesheet" type="text/css" href="cascade.css">
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
  <script src="add.js"></script>
</head>
<body>
<header>
  <h1>お問い合わせ登録</h1>
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
<main class="mainb">
  <form method="post" action="add_chk.php" autocomplete="off">
    <h3><label for="dayEntry">受付日時　　: </label>
      <input id="dayEntry" type="text" name="dayEntry" size="25" value="<?php echo $dayEntry; ?>"></h3>
    <h3><label for="content">内容　　　　: </label>
      <textarea name="content" cols="100" rows="2" maxlength="180"><?php echo $content; ?></textarea></h3>
    <h3><label for="client">顧客社名　　: </label>
      <input type="text" name="client" size="30" maxlength="30" value="<?php echo $client; ?>"></h3>
    <h3><label for="cl_name">顧客担当者名: </label>
      <input type="text" name="cl_name" size="15" maxlength="15" value="<?php echo $cl_name; ?>"></h3>
    <h3 id="staff">受付担当者名: <?php print $_SESSION['staff_name'];?>
      <input type="hidden" name="staff_name" value="<?php echo $_SESSION['staff_name']; ?>"></h3>
    <h3><label for="status">対応状況　　: </label>
      <input type="radio" name="status" value="0" <?php echo ($status == "0" ? 'checked' : '') ?>>未着手
      <input type="radio" name="status" value="1" <?php echo ($status == "1" ? 'checked' : '') ?>>調査中
      <input type="radio" name="status" value="2" <?php echo ($status == "2" ? 'checked' : '') ?>>回答済
      <input type="radio" name="status" value="3" <?php echo ($status == "3" ? 'checked' : '') ?>>完了
    </h3>
    <h3><label for="dayAns">回答日時　　: </label>
      <input id="dayAns" type="text" name="dayAns" size="25" value="<?php echo $dayAns; ?>"></h3>
    <h3><label for="answer">回答　　　　: </label>
      <textarea name="answer" cols="100" rows="5" maxlength="1000"><?php echo $answer; ?></textarea></h3>
    <br>
    <h3><label for="dayClose">完了日時　　: </label>
      <input id="dayClose" type="text" name="dayClose" size="25" value="<?php echo $dayClose; ?>"></h3>
    <input class="btnR" type="submit" value="　登　録　">
  </form>
  <br>
  <br>
</main>
<footer>
  <h6>copywright 2020-2020 Takeyama Yoshito</h6>
</footer>
</body>
</html>