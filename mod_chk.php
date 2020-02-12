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

$error_message = "";
$_SESSION['backflag'] = false;

  $post = sanitize($_POST);

  $dayEntry = $post['dayEntry'];
  $content = $post['content'];
  $client = $post['client'];
  $cl_name = $post['cl_name'];  
  $staff = $post['staff'];
  $status = $post['status'];
  $dayAns = $post['dayAns'];
  $answer = $post['answer'];
  $dayClose = $post['dayClose'];

  if (mb_strlen($dayEntry) == 0) {
    $error_message = '受付日時が未入力です。';
    mod_chk_back($error_message);
  }
  if (mb_strlen($content) == 0) {
    $error_message = '内容が未入力です。';
    mod_chk_back($error_message);
  } else {
    $content = str_replace(array("\r\n","\n","\r"), '', $content);
  // 送信された情報を、次の画面へ引き継ぎ
    $post['content'] = $content;
    $_SESSION['modQust'] = $post;
  }
  if (mb_strlen($client) == 0) {
    $error_message = '顧客社名が未入力です。';
    mod_chk_back($error_message);
  }
  if (mb_strlen($cl_name) == 0) {
    $error_message = '顧客担当者名が未入力です。';
    mod_chk_back($error_message);
  }
  if ($status < 2 && mb_strlen($dayAns) != 0) {
    $error_message = '回答日時が入力済にもかかわらず、対応状況が「調査中」以前になっています。';
    mod_chk_back($error_message);
  }
  if ($status > 1 && mb_strlen($dayAns) == 0) {
    $error_message = '対応状況が「回答済」以降にもかかわらず、回答日時が未入力です。';
    mod_chk_back($error_message);
  }
  if (mb_strlen($dayAns) != 0 && $dayAns < $dayEntry) {
    $error_message = '回答日時が受付日時より古くなっています。';
    mod_chk_back($error_message);
  }
  if (mb_strlen($answer) != 0 && mb_strlen($dayAns) == 0) {
    $error_message = '回答が入力済にもかかわらず、回答日時が未入力です。';
    mod_chk_back($error_message);
  }
  if (mb_strlen($answer) == 0 && mb_strlen($dayAns) != 0) {
    $error_message = '回答日時が入力済にもかかわらず、回答が未入力です。';
    mod_chk_back($error_message);
  }
  if ($status == '3' && mb_strlen($dayClose) == 0) {
    $error_message = '対応状況が完了にもかかわらず、完了日が未入力です。';
    mod_chk_back($error_message);
  }
  if ($status != '3' && mb_strlen($dayClose) != 0) {
    $error_message = '完了日時が入力済にもかかわらず、対応状況が「完了」以外です。';
    mod_chk_back($error_message);
  }
  if (mb_strlen($dayClose) != 0 && $dayClose < $dayAns) {
    $error_message = '完了日時が回答日時より古くなっています。';
    mod_chk_back($error_message);
  }

  print '以下の情報にて再登録します。よろしければ「編集OK」をクリックしてください。訂正したい場合は
  「お問い合わせ編集画面に戻る」をクリックしてください。<br>';
  print '<br>';

  $dayEntryOld = $post['dayEntryold'];
  $contentOld = $post['contentold'];
  $clientOld = $post['clientold'];
  $cl_nameOld = $post['cl_nameold'];  
  $staffOld = $post['staffold'];
  $statusOld = $post['statusold'];
  $dayAnsOld = $post['dayAnsold'];
  $answerOld = $post['answerold'];
  $dayCloseOld = $post['dayCloseold'];

  if ($dayEntry != $dayEntryOld) {
    print '受付日時:'.$dayEntry.'<br>';
  }
  if ($content != $contentOld) {
    print '内容:'.$content.'<br>';
  }
  if ($client != $clientOld) {
    print '顧客社名:'.$client.'<br>';
  }
  if ($cl_name != $cl_nameOld) {
    print '顧客担当者名:'.$cl_name.'<br>';
  }
  if ($staff != $staffOld) {
    print '受付担当者名:'.$staff.'<br>';
  }
  if ($status != $statusOld) {
    print '対応状況:'.$status.'<br>';
  }
  if ($dayAns != $dayAnsOld) {
    print '回答日:'.$dayAns.'<br>';
  }
  if ($answer != $answerOld) {
    print '回答:'.$answer.'<br>';
  }
  if ($dayClose != $dayCloseOld) {
    print '完了日:'.$dayClose.'<br>';
  }
  print '<br>';

  print '<a href="modDB.php">編集OK</a><br><br>';
  $error_message = '訂正が必要な箇所を発見した場合は、下のボタンをクリックします。';
  mod_chk_back($error_message);

  function mod_chk_back($msg) {
    $_SESSION['backflag'] = true;
    $_SESSION['message'] = $msg;
    print $msg.'<br>';
    print '<form method="post" action="mod.html"><input type="submit" value="お問い合わせ編集画面に戻る"></form>';
    exit();  
  }
?>