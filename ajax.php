<?php
# モードが空の場合、何をするかわからないので、処理中断
if(empty($_GET['mode'])) exit;

require_once 'database.php';

function echoHTML($sql, $msg) {
	global $link;

# SQL実行
	$response = execute($sql) ? $msg : $link->error;

# 備考：controller.php + model.php + ajax.phpに同じ記載があります。
# ----------------------------------------------------------------
# flowerから花一覧を取得
	$list = select('SELECT `id`,`name`,`count` FROM `flower`;');

# <tr><td class="id">1</td><td class="name">Rose</td><td class="count">4</td><td><button data-id="1" data-name="Rose" data-count="4" class="update">編集</button></td><td><button data-id="1" class="delete warn">削除</button></td></tr>
	$html = '';
	foreach($list as $item) $html .= '<tr data-id="' . $item['id'] . '"><td class="id">' . $item['id'] . '</td><td class="name">' . $item['name'] . '</td><td class="count">' . $item['count'] . '</td><td><button data-id="' . $item['id'] . '" data-name="' . $item['name'] .  '" data-count="' . $item['count'] . '" class="update">編集</button></td><td><button data-id="' . $item['id'] . '" class="delete warn">削除</button></td></tr>';
# ----------------------------------------------------------------

	$json = [
		'result' => $response,
		'html' => $html
	];

# PHPの連想配列をjson_encodeすると、JavaScriptのオブジェクトにそのまま使える文字列になります。
# {"result":"登録完了","html":'<tr>～</tr>'}
	echo json_encode($json);
}

switch($_GET['mode']) {
	case 'search':
# $_POST['name']が空の場合、エラーのレスポンスを返して、処理中断
		if(empty($_POST['name'])) {
			echo '{"result":2,"count":0}';
			break;
		}

# 接続 失敗時処理中断
		if(!connect('flower')) {
			echo '{"result":3,"count":0}';
			break;
		}

		$zaiko = select("SELECT `count` FROM `flower` WHERE `name`='" . str_replace("'", "''", $_POST['name']) . "';");
		if(count($zaiko)) {
			echo '{"result":0,"count":' . $zaiko[0]['count'] . '}';
			break;
		}
		echo '{"result":1,"count":0}';# 存在しない花
		break;

	case 'create':
		if(empty($_POST['name']) || (empty($_POST['count']) && $_POST['count'] !== '0')) {
			echo '{"result":"品目と在庫を正しく入力してください。"}';
			break;
		}

# 接続 失敗時処理中断
		if(!connect('flower')) {
			echo '{"result":"' . $link->connect_error . '"}';
			break;
		}

# INSERT
		echoHTML("INSERT INTO `flower` (`name`,`count`) VALUES('" . str_replace("'", "''", $_POST['name']) . "'," . (int)$_POST['count'] . ');', '登録完了');
		break;

	case 'update':
		if((empty($_POST['id']) && $_POST['id'] !== '0') || empty($_POST['name']) || (empty($_POST['count']) && $_POST['count'] !== '0')) {
			echo '{"result":"パラメーターが正しくありません。"}';
			break;
		}

# 接続 失敗時処理中断
		if(!connect('flower')) {
			echo '{"result":"' . $link->connect_error . '"}';
			break;
		}

# UPDATE
		echoHTML("UPDATE `flower` SET `name`='" . str_replace("'", "''", $_POST['name']) . "',`count`=" . (int)$_POST['count'] . ' WHERE `id`=' . (int)$_POST['id'] . ';', '更新完了');
		break;

	case 'delete':
		if(empty($_POST['id']) && $_POST['id'] !== '0') {
			echo '{"result":"パラメーターが正しくありません。"}';
			break;
		}

# 接続 失敗時処理中断
		if(!connect('flower')) {
			echo '{"result":"' . $link->connect_error . '"}';
			break;
		}

# DELETE
		echoHTML('DELETE FROM `flower` WHERE `id`=' . (int)$_POST['id'] . ';', '削除完了');
}

# 切断
$link->close();
?>