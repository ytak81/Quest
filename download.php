<meta charset="utf-8">
<?php
session_start();
session_regenerate_id(true);
if (isset($_SESSION['login']) == false) {
  print 'ログインされていません。<br>';
  print '<a href="login.php">ログイン画面へ</a>';
  exit();
}

$json2 = $_SESSION['QUEST'];

?>
<!DOCTYPE html>
<html lang="jp">
<head>
  <meta charset="utf-8">
  <title>お問い合わせ管理</title>
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>
<!-- jQuery UI -->
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
  integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU="
  crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
  <script src="sample.js"></script>
  <script>
    var json2 = '<?php echo $json2; ?>';
  </script>
  <script src="fl_con.js"></script>
  <script src="download.js"></script>
</head>
<body>
  <!--ダイアログを呼び出すボタン-->
  <button id="btn_action">ダウンロード</button>
  <!--通知メッセージを表示-->
  <div id="info"></div>
  
  <!--ダイアログの内容-->
  <div id="mydialog" title="ファイル名の指定">
    ダウンロード先のファイル名を指定してください。<br />
    （拡張子の入力は不要）<br />
    <table>
      <tr>
        <th>ファイル名</th>
        <td><input type="text" id="inputId" size="30" maxlength="30"></td>
      </tr>   
    </table>
  </div>
  <!--入力可能なダイアログ END-->
  
  <br>
  <a href="list.php">一覧画面に戻る</a>
</body>
</html>