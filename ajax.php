<?php
# モードが空の場合、何をするかわからないので、処理中断
if(empty($_GET['mode'])) exit;

require_once 'database.php';

function echoHTML($msg) {
# flowerから花一覧を取得
	$list = select('SELECT `id`,`name`,`count` FROM `flower`;');

# <tr><td class="id">1</td><td class="name">Rose</td><td class="count">4</td><td><button data-id="1" class="edit">編集</button></td></tr>
	$html = '';
	foreach($list as $item) $html .= '<tr data-id="' . $item['id'] . '"><td class="id">' . $item['id'] . '</td><td class="name">' . $item['name'] . '</td><td class="count">' . $item['count'] . '</td><td><button data-id="' . $item['id'] . '" data-name="' . $item['name'] .  '" data-count="' . $item['count'] . '" class="update">編集</button></td><td><button data-id="' . $item['id'] . '" class="delete">削除</button></td></tr>';
	$json = [
		'result' => $link->error ?? $msg,
		'html' => $html
	];
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
		execute("INSERT INTO `flower` (`name`,`count`) VALUES('" . str_replace("'", "''", $_POST['name']) . "'," . (int)$_POST['count'] . ');');
		echoHTML('登録完了');
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
		execute("UPDATE `flower` SET `name`='" . str_replace("'", "''", $_POST['name']) . "',`count`=" . (int)$_POST['count'] . ' WHERE `id`=' . (int)$_POST['id'] . ';');
		echoHTML('更新完了');
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
		execute('DELETE FROM `flower` WHERE `id`=' . (int)$_POST['id'] . ';');
		echoHTML('削除完了');
}
$link->close();
?>