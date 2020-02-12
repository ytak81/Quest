<?php

//// データベースの排他制御（ロック・アンロック）
//
function dbLock($table) {
  global $sql,$stmt,$dbh;

  // lock
  $sql = "LOCK TABLES ".$table." WRITE";
  $stmt = $dbh->prepare($sql);
  $stmt->execute();
}

function dbUnlock() {
  global $sql,$stmt,$dbh;

  // unlock
  $sql = "UNLOCK TABLES";
  $stmt = $dbh->prepare($sql);
  $stmt->execute();  
}

//// データベース障害発生時の処理
//
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

//// サ二タイズ
function sanitize($before) {
  foreach ($before as $key => $value) {
    $after[$key] = htmlspecialchars($value,ENT_QUOTES,'UTF-8');
  }
  return $after;
}

//// ダンプ表示
function dump($expression){
  echo "<pre>";
  var_dump($expression);
  echo "</pre>";
  exit;
}

?>