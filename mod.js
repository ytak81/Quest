$(function()  {
//// セレクトボックスの選択肢を表示
  // 名前のはいった配列を取得
  var objarr = JSON.parse(json);
 
  //連想配列の配列を、accountの順にソート
  objarr.sort(function(a, b) {
    if (a.account > b.account) {
      return 1;
    } else {
      return -1;
    }
  });

  //一行ごとにhtml化
  $.each(objarr, function(index, value) {
    var str = '<option value="';        
    str += value.name;        
    str += '"';   
    if (value.name == staff) {
        str += ' selected';
    }       
    str += '>';        
    str += value.name;        
    str += '</option>';
    $('#staff').append(str); 
  
  }) 

    // 日付時刻の入力準備 (Datepickerを使用）
  
    $('#dayEntry').datetimepicker({
      dateFormat: 'yy年mm月dd日',
      timeFormat: 'HH時mm分',
      hourGrid: 4,
      minuteGrid: 10,
    });  
  
    $('#dayAns').datetimepicker({
      dateFormat: 'yy年mm月dd日',
      timeFormat: 'HH時mm分',
      hourGrid: 4,
      minuteGrid: 10,
    });  
  
    $('#dayClose').datetimepicker({
      dateFormat: 'yy年mm月dd日',
      timeFormat: 'HH時mm分',
      hourGrid: 4,
      minuteGrid: 10,
    });  
}) 