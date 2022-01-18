・使い始め
ルートディレクトリのindex.phpにアクセスして初期化ボタンを押してください。
使いたい機能ModelEx.phpの中の処理が実行されて、データベース及びテーブルを作成、初期データを登録。

このリポジトリ自体のcloneはこちら

git clone git@github.com:samuraiht/samplewebapp
cd samplewebapp
git remote remove origin

phpMyAdminはこちらをどうぞ
1端末に1つあれば十分ですのでプロジェクトごとに設置して容量オーバーにならないように注意です。

git clone git@github.com:samuraiht/phpMyAdmin
cd phpMyAdmin
git remote remove origin

・MVCの考え方
Controllerのアクションって？
GET/POST/PUT/DELETE

ログアウト処理は別に退会ではないのだけど…？
RESTFul的には…
DELETE
HTML例：<input type="hidden" name="_method" value="DELETE">

実際の動作的には？
GET

プリフェッチ：前もって取得…？ログアウト処理を前もって実行してしまうのでは？
POST

index : GET
初期表示＆一覧表示 データベース->SELECT …;

create : GET
新規登録画面(View)を表示する

store : POST
createの画面から、「登録、投稿」したとき、データベース->INSERT INTO … (…) VALUES(…);
createまたはindex(View)に戻るのが標準的

show : GET
個別表示画面(View)を表示する データベース->SELECT 1件だけ;

edit : GET
編集画面(View)を表示する

update : PUT
editの画面から、「更新」したとき、データベース->UPDATE … SET … WHERE …;
editまたはindex(View)に戻るのが標準的

destroy : DELETE
index画面から、1件「削除」する
index(View)にリダイレクト