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

$qcode= $_POST['qcode'];

try {
  
require_once('db_con.php');
dbConnect();

// 編集対象の問い合わせの取得 (ケースAのみ)
if ($_SESSION['backflag'] == false) {
  $sql = 'SELECT * FROM dat_questions WHERE code=?';
  $stmt = $dbh->prepare($sql);
  $data[] = $qcode;
  $stmt->execute($data);

  $rec = $stmt->fetch(PDO::FETCH_ASSOC);
}

$dbh = null;

//var_dump($_SESSION['backflag']);

// 画面表示項目の編集
//   A)一覧画面から遷移した場合 (backflag==false)
//   B)確認画面から戻した場合 (backflag==true)
if ($_SESSION['backflag'] == false) {

  $dayEntry = $rec['dateEnt'];
  $content = $rec['content'];
  $client = $rec['org'];
  $cl_name = $rec['client'];  
  $staff = $rec['staff'];
  $status = $rec['status'];
  $dayAns = $rec['dateAns'];
  $answer = $rec['answer'];
  $dayClose = $rec['dateCls'];
  
} else {
  $qust = sanitize($_SESSION['modQust']);
  $qcode = $qust['qcode'];
  $dayEntry = $qust['dayEntry'];
  $content = $qust['content'];
  $client = $qust['client'];
  $cl_name = $qust['cl_name'];  
  $staff = $qust['staff'];
  $status = $qust['status'];
  $dayAns = $qust['dayAns'];
  $answer = $qust['answer'];
  $dayClose = $qust['dayClose'];

  $_SESSION['backflag'] = false;
}

$json = $_SESSION['staffAll'];

// 受付担当者名の表示
  // 管理者と担当者とで、表示する要素を切り替え
  if ($_SESSION['authority'] == 0) {
    $s0 = "show";
    $s1 = "hide";
  } else {
    $s0 = "hide";
    $s1 = "show";
  }

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
  <style>
    body {background-color: lightyellow}
    header {background-color: lightyellow}
    .show {display : block;}
    .hide {display : none;}
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
  <script>
    var json = '<?php echo $json; ?>';
    var staff = '<?php echo $staff ?>';
  </script>
  <script src="mod.js"></script>
</head>
<body>
<header>
  <h1>お問い合わせ編集</h1>
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
  <form method="post" action="mod_chk.php" autocomplete="off">
      <input type="hidden" name="qcode" value="<?php print $qcode; ?>">
    <h3><label for="dayEntry">受付日時　　: </label>
      <input id="dayEntry" type="text" name="dayEntry" size="25" value="<?php print $dayEntry; ?>">
      <input type="hidden" name="dayEntryold" value="<?php print $dayEntry; ?>"></h3>
    <h3><label for="content">内容　　　　: </label>
      <textarea name="content" cols="100" rows="2" maxlength="200"><?php print $content; ?></textarea>
      <input type="hidden" name="contentold" value="<?php print $content; ?>" cols="100" rows="2"></h3>
    <h3><label for="client">顧客社名　　: </label>
      <input type="text" name="client" size="30" maxlength="30" value="<?php print $client; ?>">
      <input type="hidden" name="clientold" value="<?php print $client; ?>"></h3>
    <h3><label for="cl_name">顧客担当者名: </label>
      <input type="text" name="cl_name" size="15" maxlength="15" value="<?php print $cl_name; ?>">
      <input type="hidden" name="cl_nameold" value="<?php print $cl_name; ?>"></h3>
    <div id="staff1" class="<?php echo $s0 ?>">
      <h3>受付担当者名: <?php print $staff;?></h3></div>
    <input type="hidden" name="staffold" value="<?php print $staff; ?>"></h3>
    <div id="staff2" class="<?php echo $s1 ?>">
      <h3><label for="staff">受付担当者名: </label>
      <select id="staff" name="staff">
      </select></h3></div>
    <h3><label for="status">対応状況　　: </label>
      <input type="radio" name="status" value="0" <?php echo ($status == '0' ? 'checked' : '') ?>>未着手
      <input type="radio" name="status" value="1" <?php echo ($status == '1' ? 'checked' : '') ?>>調査中
      <input type="radio" name="status" value="2" <?php echo ($status == '2' ? 'checked' : '') ?>>回答済
      <input type="radio" name="status" value="3" <?php echo ($status == '3' ? 'checked' : '') ?>>完了
      <input type="hidden" name="statusold" value="<?php print $status; ?>"></h3>
    </h3>
    <h3><label for="dayAns">回答日時　　:</label>
      <input id="dayAns" type="text" name="dayAns" size="25" value="<?php print $dayAns; ?>">
      <input type="hidden" name="dayAnsold"value="<?php print $dayAns; ?>"></h3>
    <h3><label for="answer">回答　　　　: </label>
      <textarea name="answer" cols="100" rows="5" maxlength="1000"><?php print $answer; ?></textarea>
      <input type="hidden" name="answerold" value="<?php print $answer; ?>"></h3>
    <br>
    <h3><label for="dayClose">完了日時　　: </label>
      <input id="dayClose" type="text" name="dayClose" size="25" value="<?php print $dayClose; ?>">
      <input type="hidden" name="dayCloseold" value="<?php print $dayClose; ?>"></h3>
    <input class="btnR" type="submit" value="　更　新　">
  </form>
  <br>
  <br>
</main>
<footer>
  <h6>copywright 2020-2020 Takeyama Yoshito</h6>
</footer>
</body>
</html>