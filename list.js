$(function()  {

//// 問い合わせのリストを生成
  // 問い合わせ情報のjsonを配列に変換
  var objarr2 = JSON.parse(json2);
 
  //連想配列の配列を、codeの逆順にソート
  objarr2.sort(function(a, b) {
    if (a.code < b.code) {
      return 1;
    } else {
      return -1;
    }
  });

  //一行ごとにhtml化
  $.each(objarr2, function(index, value) {
    var str = '<tr class="';        
    switch (value.status) {
      case 0:
        str += 'bgred';
        break;
      case 1:
        str += 'bgwhite';
        break;
      case 2:
        str += 'bgylgrn';
        break;
      case 3:
        str += 'bgwine';
        break;
    }       
    str += '"><td>';        
    str += value.dateEnt;        
    str += '</td><td>';        
    str += value.staff;        
    str += '</td><td>';        
    switch (value.status) {
      case 0:
        str += '未着手';
        break;
      case 1:
        str += '調査中';
        break;
      case 2:
        str += '回答済';
        break;
      case 3:
        str += '完了';
        break;
    }       
    str += '</td><td>';        
    str += value.org;        
    str += '</td><td>';        
    str += value.client;        
    str += '</td><td>';        
    str += value.content;        
    str += '</td><td>';        
    str += value.dateAns;        
    str += '</td><td>';        
    str += value.dateCls;        
    str += '</td><td class="hidden">';
    str += value.code;        
    str += '</td></tr>';

    $('table').append(str); 
  
  }) 
 
//// 一覧の行がクリックされた場合
    $(document).on('click', 'tr',function(e) {
      // クリックした行のすべての子要素を取得
      var obj = $(this).children();

      // 取得した各子要素の中身を、配列に格納
      var array = [];
      $.each(obj, function(i, val) {   // この書き方がポイント
        array.push($(val).html());
      });
      // 問い合わせコードを取得
      var qcode = array[8];
      //alert(qcode);
 
      // 配列を、送信フォームにセット
      var strp ='以下の情報を編集します。よろしいですか？';
      $('.msg').text(strp);
      var strb = '<h4>' + array[5] + '</h4>';
      $('#postMod').append(strb); 

      var strb = '<input id="btnok" type="submit" value="OK！ 編集画面へ">';
      $('#postMod').append(strb); 
      var strb = '<input id="btnng" type="button" value="キャンセル">';
      $('#postMod').append(strb); 

      // 問い合わせコードをHTMLに返却（PHPで読めるように）
      var strb = '<input id="qcode" type="hidden" name="qcode" value="' + qcode + '">';
      $('#postMod').append(strb); 

      window.scrollTo(0,0);
    })

    $(document).on('click', '#btnng',function(e) {
      // キャンセルボタンをクリックしたときの動作
      $('.msg').text('');
      $('#postMod').html('');       
    })

}) 