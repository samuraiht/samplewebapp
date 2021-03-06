<?php
# モードが空の場合、何をするかわからないので、処理中断
if(empty($_GET['mode'])) exit;

require_once '../app/db.php';
require_once '../app/app.php';

switch($_GET['mode']) {
	case 'index':# flower.phpの検索処理(廃止)
# 接続 失敗時処理中断
		if(!connect('flower')) {
			echo '{"result":3,"count":0}';
			break;
		}

# $_POST['name']が空の場合、エラーのレスポンスを返して、処理中断
		if(empty($_POST['name'])) {
			echo '{"result":2,"count":0}';
			break;
		}

		$sql = "SELECT `count`,`price`,`point`,`shipping` FROM `flower` WHERE `name`='" . str_replace("'", "''", $_POST['name']) . "';";
		$item = select($sql);

# 実行したSQLの記録
		sqllog($sql);

		if(count($item)) {# item.length 0だとfalse扱いになる　1以上ならtrue扱い
# {"result":0,"count":4,"price":400,"point":0}
			echo '{"result":0,"count":' . $item[0]['count'] . ',"price":' . $item[0]['price'] . ',"point":' . $item[0]['point'] . ',"shipping":' . $item[0]['shipping'] . '}';
			break;
		}

		echo '{"result":1,"count":0}';# 存在しない花
		break;

	case 'store':# flower.php->新規登録
# 接続 失敗時処理中断
		if(!connect('flower')) {
			echoHTML($link->connect_error);
			break;
		}

# パラメーターチェック
		if(empty($_POST['name']) || checkValue($_POST['count']) || checkValue($_POST['price']) || checkValue($_POST['point'])) {
			echoHTML('パラメーターが正しくありません。');
			break;
		}

# すでにある品目かどうか確認
		$sql = "SELECT `count` FROM `flower` WHERE `name`='" . str_replace("'", "''", $_POST['name']) . "';";
		$result = select($sql);

# 実行したSQLの記録
		sqllog($sql);

		if(count($result)) {# 1件存在
# UPDATE
			echoHTML('在庫を追加しました', "UPDATE `flower` SET `count`=" . ((int)$result[0]['count'] + (int)$_POST['count']) . ",`price`=" . (int)$_POST['price'] . ",`point`=" . (int)$_POST['point'] . ",`shipping`=" . (int)$_POST['shipping'] . " WHERE `name`='" . str_replace("'", "''", $_POST['name']) . "';");
		} else {# 0件=存在しない
# INSERT
			echoHTML('登録完了', "INSERT INTO `flower` (`name`,`count`,`price`,`point`,`shipping`) VALUES('" . str_replace("'", "''", $_POST['name']) . "'," . (int)$_POST['count'] . ',' . (int)$_POST['price'] . ',' . (int)$_POST['point'] . ',' . (int)$_POST['shipping'] . ');');
		}
		break;

	case 'update':# flower.php->更新
# 接続 失敗時処理中断
		if(!connect('flower')) {
			echoHTML($link->connect_error);
			break;
		}

# パラメーターチェック
		if(checkValue($_POST['id']) || empty($_POST['name']) || checkValue($_POST['count']) || checkValue($_POST['price']) || checkValue($_POST['point'])) {
			echoHTML('パラメーターが正しくありません。');
			break;
		}

# UPDATE
		echoHTML('更新完了', "UPDATE `flower` SET `name`='" . str_replace("'", "''", $_POST['name']) . "',`count`=" . (int)$_POST['count'] . ',`price`=' . (int)$_POST['price'] . ',`point`=' . (int)$_POST['point'] . ",`shipping`=" . (int)$_POST['shipping'] . ' WHERE `id`=' . (int)$_POST['id'] . ';');
		break;

	case 'celledit':# flower.php->セル編集
# 接続 失敗時処理中断
		if(!connect('flower')) {
			echoHTML($link->connect_error);
			break;
		}

# パラメーターチェック
# $_POST['col'] => どのカラム？ 例: price
# $_POST['val'] => 設定したい値 例: 400
		if(checkValue($_POST['id']) || empty($_POST['col']) || (empty($_POST['val']) && $_POST['val'] !== '0')) {
			echoHTML('パラメーターが正しくありません。');
			break;
		}

# UPDATE
		echoHTML("#{$_POST['id']}の{$_POST['col']}を{$_POST['val']}に更新完了", "UPDATE `flower` SET `{$_POST['col']}`='" . str_replace("'", "''", $_POST['val']) . "' WHERE `id`=" . (int)$_POST['id'] . ';');
		break;

	case 'delete':# admin.php->削除
# 接続 失敗時処理中断
		if(!connect('flower')) {
			echoHTML($link->connect_error);
			break;
		}

# パラメーターチェック
		if(checkValue($_POST['id'])) {
			echoHTML('パラメーターが正しくありません。');
			break;
		}

# DELETE
		echoHTML('削除完了', 'DELETE FROM `flower` WHERE `id`=' . (int)$_POST['id'] . ';');
}

# 切断
disconnect();
?>