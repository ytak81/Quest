$(function() {

//// 標準ファイル名の初期設定
  // 現在日時をファイル名の末尾に追加
  filename += dateToStr24HPad0(new Date(), 'YYYYMMDDhhmmss');
    
  // ダイアログの初期設定
  $("#mydialog").dialog({
    autoOpen: false,  // 自動的に開かないように設定
    width: 500,       // 横幅のサイズを設定
    modal: true,      // モーダルダイアログにする
    buttons: {        // ボタン名 : 処理 を設定
      "ＯＫ": function() {
        if ($("#inputId").val() != '') {
           filename = $("#inputId").val(); //モーダルウインドウより入力したファイル名を設定
        }
        downloadCSV(json2,filename);  
        displayMessage("保存しました。（ ファイル名："
          + filename
          + ".csv"
          + " ）");
        $(this).dialog("close");
      },
      "キャンセル": function() {
        displayMessage("キャンセルしました。");
        $(this).dialog("close");
      }
    }
  });
 
  $("#btn_action").click(function(){
    // ダイアログの呼び出し処理
    $("#mydialog").dialog("open");
  });

}) 

// ダイアログの処理メッセージを表示
function displayMessage(str) {
  $("#info").html(str)
}

//// ダウンロードファイルをcsv形式で作成

function downloadCSV(json2,filename)  {

  // 問い合わせのリスト（json形式）を配列に変換
  var objarr2 = JSON.parse(json2);
 
  //連想配列の配列を、codeの逆順にソート
  objarr2.sort(function(a, b) {
    if (a.code < b.code) {
      return 1;
    } else {
      return -1;
    }
  });

//  var csv = "受付日時,受付担当者名,対応状況,顧客会社名,顧客担当者名,内容,回答日時,回答,完了日時,コード（お問い合わせ番号）"
  var csv = "受付日時,受付担当者名,対応状況,顧客会社名,顧客担当者名,内容,回答日時,完了日時,コード（お問い合わせ番号）"
  csv += rtcode;

  //一行ごとに文字列化
  $.each(objarr2, function(index, value) {
    csv += value.dateEnt;        
    csv += ',';        
    csv += value.staff;        
    csv += ',';        
    switch (value.status) {
      case 0:
        csv += '未着手';
        break;
      case 1:
        csv += '調査中';
        break;
      case 2:
        csv += '回答済';
        break;
      case 3:
        csv += '完了';
        break;
    }       
    csv += ',';        
    csv += value.org;        
    csv += ',';        
    csv += value.client;        
    csv += ',';        
    csv += value.content;        
    csv += ',';        
    csv += value.dateAns;        
    csv += ',';        
//    csv += value.answer;        
//    csv += ',';        
    csv += value.dateCls;        
    csv += ',';
    csv += value.code;        
    csv += rtcode;  
  }) 

////csv変換
  //出力ファイル名
  var exportedFilenmae = (filename  || 'export') + '.csv';

  //BLOBに変換
  var blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });

  if (navigator.msSaveBlob) { // for IE 10+
      navigator.msSaveBlob(blob, exportedFilenmae);
  } else {
      //anchorを生成してclickイベントを呼び出す。
      var link = document.createElement("a");
      if (link.download !== undefined) {
          var url = URL.createObjectURL(blob);
          link.setAttribute("href", url);
          link.setAttribute("download", exportedFilenmae);
          link.style.visibility = 'hidden';
          document.body.appendChild(link);
          link.click();
          document.body.removeChild(link);
      }
  }
}

//// 日付を任意の文字列にフォーマットする自作関数
function dateToStr24HPad0(date, format) {
      
    if (!format) {
        // デフォルト値
        format = 'YYYY/MM/DD hh:mm:ss'
    }
    
    // フォーマット文字列内のキーワードを日付に置換する
    format = format.replace(/YYYY/g, date.getFullYear());
    format = format.replace(/MM/g, ('0' + (date.getMonth() + 1)).slice(-2));
    format = format.replace(/DD/g, ('0' + date.getDate()).slice(-2));
    format = format.replace(/hh/g, ('0' + date.getHours()).slice(-2));
    format = format.replace(/mm/g, ('0' + date.getMinutes()).slice(-2));
    format = format.replace(/ss/g, ('0' + date.getSeconds()).slice(-2));
    
    return format;
}

//// 参考URL：
// https://www.sejuku.net/blog/23064