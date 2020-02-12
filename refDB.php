<meta charset="utf-8">
<?php
session_start();
session_regenerate_id(true);
if (isset($_SESSION['login']) == false) {
  print 'ログインされていません。<br>';
  print '<a href="login.html">ログイン画面へ</a>';
  exit();
}
require_once('common.php');

try {
  $dsn = 'mysql:dbname=company;host=localhost;charset=utf8';
  $user = 'root';
  $password = 'root';

  $dbh = new PDO($dsn,$user,$password);
  $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

  $sql = 'SELECT * FROM dat_questions WHERE 1';
  $stmt = $dbh->prepare($sql);
  $stmt->execute();
  $dbh = null;

  // JSONファイルに書き出し
  $json = '[';

  $rec = $stmt->fetch(PDO::FETCH_ASSOC);
  while ($rec == true) {
    if ($json != '[')  {
      $json .= ',';      
    }
    $json .= '{"code":';
    $json .= $rec['code'];
    $json .= ',"dateEnt":"';
    $json .= substr($rec['dateEnt'],7,10);
    $json .= '","content":"';
    $json .= $rec['content'];
    $json .= '","org":"';
    $json .= $rec['org'];  
    $json .= '","client":"';
    $json .= $rec['client'];
    $json .= '","staff":"';
    $json .= $rec['staff'];
    $json .= '","status":';
    $json .= $rec['status'];
    $json .= ',"dateAns":"';
    $json .= substr($rec['dateAns'],7,10);
    $json .= '","dateCls":"';
    $json .= substr($rec['dateCls'],7,10);  
    $json .= '"}';
  
    $rec = $stmt->fetch(PDO::FETCH_ASSOC);
  }
  $json .= ']';

  // $jsonをセッションデータに書き出し
  $_SESSION['QUEST'] = $json;

  // list.htmlを読み出し
  header('Location:list.html'); 

}

catch (Exception $e) {
  dberror($e);
  exit();
}
?>