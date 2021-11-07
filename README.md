・使い始めまたはデータベースをリセットしたいとき
model.phpにアクセス(URLに入れてページを表示またはコマンド：php indexEx.php)
modelEx.phpの中の処理が実行されて、データベース及びテーブルを作成、初期データを登録。

・在庫確認のページ
index.php <- conrtoller.php::options()を使用
ajax.jsの読み込み
	定義してあるajax.js::fetchJSONが使えるようになる
index.jsの読み込み
	このページだけで使う処理を記載
	どのボタンをクリックしたとき、どんな処理をするかなどを定義してある

・ユーザー側画面の処理とデータの流れ
0. controller.php::options()で、データベースの花の名前`name`を全件取得して選択肢を作る
1. index.php内の選択肢を選ぶvalueがついています(Roseを選んだとします)
2. 検索ボタンを押すと、index.js::document.getElementById('search').onclickが実行される
Request URL: ajax.php
GET Query：	mode=search
POST Query：name=Rose
3. ajax.js::fetchJSONが、指定されたパラメーターをajax.phpに送る
4. ajax.phpがこれらを受信して、レスポンスをechoで出力する 例：{"result":0,"count":4}
5. ajax.js::fetchJSONで、このecho結果を受信する
6. returnしたものはindex.js::fetchJSON(…).then(data => {…})のdataに入ります
7. thenの中の、index.js::showResultがデータの終着地点です
8. ページ上に結果表示

このリポジトリ自体のcloneはこちら
git clone git@github.com:samuraiht/samplewebapp

phpMyAdminはこちらをどうぞ
1端末に1つあれば十分ですのでプロジェクトごとに設置して容量オーバーにならないように注意です。
git clone git@github.com:samuraiht/phpMyAdmin