<?php

//// データベースへの接続
//
function dbConnect() {
  global $dsn,$dbname,$user,$password,$dbh;

// データベース名（初期値：company）
//$dsn = 'mysql:dbname=company;host=localhost;charset=utf8';
//$dbname = 'company';
  $dbname = 'company';

// アカウント（初期値：root）・・・使用する環境に合わせて設定してください。
//$user = 'root';
  $user = 'root';

// パスワード（初期値：root）・・・使用する環境に合わせて設定してください。
//$password = 'root'; 
  $password = 'root';



//// 以下の記述は、変更しないでください（変更すると、一切動作しません）。
//
// DB接続
  $dsn = 'mysql:dbname='.$dbname.';host=localhost;charset=utf8';
  $dbh = new PDO($dsn,$user,$password);
  $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
}

?>