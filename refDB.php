<meta charset="utf-8">
<?php
session_start();
session_regenerate_id(true);
if (isset($_SESSION['login']) == false) {
  print 'ログインされていません。<br>';
  print '<a href="login.php">ログイン画面へ</a>';
  exit();
}
require_once('common.php');

$post = sanitize($_POST);
if ($_SESSION['authority'] == 0) {
  $staff = $post['staff0'];
} else {
  $staff = $post['staff1'];
}
$dayStart = $post['dayStart'];
$dayEnd = $post['dayEnd'];
$status = $post['status'];
$keyword = $post['keyword'];

try {
  require_once('db_con.php');
  dbConnect();

  // 条件にかなうレコードだけを抽出
  //$sql = 'SELECT * FROM dat_questions WHERE 1';
  $sql = 'SELECT * FROM dat_questions';

//dump($staff);
  if ($staff != "all") {
    $sql .= ' WHERE staff = ?';
    $data[] = $staff;
  }  
  if ($dayStart != '') {
    if ($sql == 'SELECT * FROM dat_questions') {
      $sql .= ' WHERE dateEnt > ?';
    } else {
      $sql .= ' and dateEnt > ?';
    }    
    $data[] = $dayStart;
  }
  if ($dayEnd != '') {
    if ($sql == 'SELECT * FROM dat_questions') {
      $sql .= ' WHERE dateEnt < ?';
    } else {
      $sql .= ' and dateEnt < ?';
    }
    $data[] = $dayEnd;
  }
  if ($status != 9) {
    if ($sql == 'SELECT * FROM dat_questions') {
      $sql .= ' WHERE status = ?';
    } else {
      $sql .= ' and status = ?';
    }
    $data[] = $status;
  }
  if ($sql == 'SELECT * FROM dat_questions') {
    $sql .= ' WHERE 1';
  }

//dump($sql);
  $stmt = $dbh->prepare($sql);
  $stmt->execute($data);

  $dbh = null;

  // JSONファイルに書き出し
  $json = '[';

  $rec = $stmt->fetch(PDO::FETCH_ASSOC);

  while ($rec == true) {
    if ($keyword == '' || ($keyword != '' && false !== strpos($rec['content'], $keyword))) {
      // 文字列検索を行わない（＝keywordが空）場合 
      //または
      // 文字列検索がヒットする（＝「内容」にkeywordが含まれる）場合
      if ($json != '[') { 
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
//      $json .= ',"answer":"';
//      $json .= $rec['answer'];
      $json .= '","dateCls":"';
      $json .= substr($rec['dateCls'],7,10);  
      $json .= '"}';
    } 
    
    $rec = $stmt->fetch(PDO::FETCH_ASSOC);
  }
  $json .= ']';
//dump($json);

  // $jsonをセッションデータに書き出し
  $_SESSION['QUEST'] = $json;

  // list.htmlを読み出し
  header('Location:list.php'); 

}

catch (Exception $e) {
  dberror($e);
  exit();
}

?>