・使い始めまたはデータベースをリセットしたいとき
model.phpにアクセス(URLに入れてページを表示またはコマンド：php indexEx.php)
modelEx.phpの中の処理が実行されて、データベース及びテーブルを作成、初期データを登録。

・在庫確認のページ
index.php
ajax.jsの読み込み
	定義してあるfetchJSONが使えるようになる
index-c.jsの読み込み
	このページだけで使う処理を記載
	どのボタンをクリックしたとき、どんな処理をするかなどを定義してある

・データの流れ
1. index.php内の選択肢を選ぶ valueがついています(Roseを選んだとします)
2. 検索ボタンを押すと、検索ボタンのonclick(index.js内)が実行される
GET方式：	mode=search
POST方式：name=Rose
3. fetchJSON(ajax.js内)が、指定されたパラメーターをajax.phpに送る
4. ajax.phpがこれらを受信して、レスポンスをechoで出力する例：{"result":0,"count":4}
5. fetchJSON(ajax.js内)で、このecho結果を受信する
6. returnしたものはindex-c.js内のfetchJSON(…).then(data => {…})のdataに入ります
7. thenの中の、showResult(index.js内)がデータの終着地点です

phpMyAdminはこちらをどうぞ
1端末に1つあれば十分ですのでプロジェクトごとに設置して容量オーバーにならないように注意です。
git clone https://github.com/samuraiht/phpMyAdmin