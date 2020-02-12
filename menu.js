$(function()  {
//// スタッフのセレクトボックスを生成
  // スタッフ情報のjsonを配列に変換
  var objarr = JSON.parse(json);
  
  //連想配列の配列を、accountの順にソート
  objarr.sort(function(a, b) {
    if (a.account > b.account) {
      return 1;
    } else {
      return -1;
    }
  });

  //セレクトボックスの選択肢を、一行づつ追加
  $.each(objarr, function(index, value) {
    var str = '<option value="';        
    str += value.name;        
    str += '">';                
    str += value.name;        
    str += '</option>';
    $('#staff').append(str); 

  }) 

})

jQuery.noConflict();   // $関数の割り当てを初期化

var $j = jQuery;       // 改めて変数を割り当てる

// $変数が$j変数になっている
$j(function() {  
//// 日付時刻の入力準備 (Datepickerを使用）
  $('#dayStart').datetimepicker({
    dateFormat: 'yy年mm月dd日',
    timeFormat: 'HH時mm分',
    hourGrid: 4,
    minuteGrid: 10,
  });  

  $('#dayEnd').datetimepicker({
    dateFormat: 'yy年mm月dd日',
    timeFormat: 'HH時mm分',
    hourGrid: 4,
    minuteGrid: 10,
  });  

}) 