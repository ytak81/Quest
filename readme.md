《アプリ名》
お問い合わせ管理

《バージョン》
1.0

《動作環境》
・サーバ
（PHPの脆弱性対策が十分ではありませんので、ローカルサーバで使用してください）
・データベース：MySQL
・ブラウザ：Chrome
（他のブラウザでの動作確認は、実施しておりません）



《納品物一式》
1）設計書　：下記に記載。
https://docs.google.com/spreadsheets/d/1WTjm9tuMdqC0qxhIHmhDDLxTFRboLrxT4ksVVO1_njw/edit#gid=0

2）テスト仕様書兼報告書　：下記に記載。
https://docs.google.com/spreadsheets/d/1zOU__WUaN5j0ks6Uwn5MCM4bsUF8NabTh3I1Ed7JZ4c/edit?userstoinvite=wish7ycn@gmail.com&ts=5e24fd2a&actionButton=1#gid=1053828369

3）テスト証跡　：下記に収納。
https://drive.google.com/drive/folders/1DKzcKUj9G6WzYg1FRhR6XVGbjpHgIWvk



《動作確認上の前提事項》
データベース（MySQL）に対し、事前設定が必要になります（phpMyadminにて）。
◎データベース名：company

◎以下の2テーブルを用意します。
1.テーブル名：mst_staff
  設計書の「DB仕様」に従ってテーブル定義を行うとともに、本システムを使用する4名のレコードを登録します。
  (4名の詳細は、上記設計書のシート「システム要件」の30行目以降を参照してください)

2.テーブル名；dat_questions 
　設計書の「DB仕様」に従ってテーブル定義を行います。
（レコードの事前登録は不要です）



《セットアップおよび初期設定》
1）localhostと直結したフォルダー「htdocs」の配下に、フォルダー「company」を新規作成する。

2）当システムのすべてのファイルを、1）で作成したフォルダー「company」の直下におく。



《起動方法》
1）ローカルホストにて、MySQLを起動する。

2）ブラウザにて、以下の文字列を入力し、ENTERキーを押す。
http://localhost/company/login.php