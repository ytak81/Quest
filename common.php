<?php
/*
function login_chk($flagMsg) {
  session_start();
  session_regenerate_id(true);
  if (isset($_SESSION['login']) == false) {
    print 'ログインされていません。<br>';
    print '<a href="login.html">ログイン画面へ</a>';
    exit();
  } else {
    if ($flagMsg==true) {
      $message = $_SESSION['staff_name'].'さんログイン中。';
    }
  }
} 
*/

function dberror($e) {
  // 発生した例外の情報をファイルに出力
    $messages = "";
    $messages .= $e->getFile(); //例外の発生したファイル名を取得
    $messages = "  ";
    $messages .= $e->getLine(); //例外の発生した行数を取得
    $messages = "  ";
    $messages .= $e->getCode(); //例外の発生したコードを取得
    $messages = "  ";
    $messages .= $e->getMessage(); //発生した例外についてのメッセージを取得
    error_log($messages, 3, __DIR__ . "/exceptions.log");

    print 'ただいま障害により大変ご迷惑をお掛けしております。';
    exit();
}

function sanitize($before) {
  foreach ($before as $key => $value) {
    $after[$key] = htmlspecialchars($value,ENT_QUOTES,'UTF-8');
  }
  return $after;
}

function dump($expression){
  echo "<pre>";
  var_dump($expression);
  echo "</pre>";
  exit;
}

?>