$(function()  {
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
});