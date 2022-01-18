<?php
# モードが空の場合、何をするかわからないので、処理中断
if(empty($_GET['mode'])) exit;

require_once '../app/db.php';
require_once '../app/app.php';

function echoJSON($arr) {
	echo json_encode($arr);
}

function echoJSON($key, $val) {
	echoJSON([$key => $val]);
}

switch($_GET['mode']) {
	case 'index':
# 接続 失敗時処理中断
		if(!connect('post')) {
			echoJSON('result', $link->connect_error);
			break;
		}

		$sql = 'SELECT `posts`.`title`,`posts`.`content`,`images`.`src`,`images`.`alt` FROM `posts` LEFT JOIN `images` ON `posts`.`icon`=`images`.`id`;';
		$posts = select($sql);

# 実行したSQLの記録
		sqllog($sql);

		$res = ['result' => 0, 'data' => []];
		foreach($posts as $p) {
			$res['data'][] = [
				'title' => $p['title'],
				'content' => $p['content'],
				'icon' => !empty($p['src']) ? ['src' => $p['src'], 'alt' => $p['alt']] : NULL
			];
		}
		echoJSON($res);
		break;

	case 'show':
# 接続 失敗時処理中断
		if(!connect('post')) {
			echoJSON('result', $link->connect_error);
			break;
		}

# パラメーターチェック
		if(empty((int)$_GET['id'])) {
			echoJSON('result', 'パラメーターが正しくありません。');
			break;
		}

		$sql = 'SELECT `posts`.`title`,`posts`.`content`,`images`.`src`,`images`.`alt` FROM `posts` LEFT JOIN `images` ON `posts`.`icon`=`images`.`id`;';
		$posts = select($sql);

# 実行したSQLの記録
		sqllog($sql);

		$res = ['result' => 0, 'data' => NULL];
		if(count($posts)) {
			$res['data'] = [
				'title' => $posts[0]['title'],
				'content' => $p['content'],
				'icon' => !empty($p['src']) ? ['src' => $p['src'], 'alt' => $p['alt']] : NULL
			];
		}
		echoJSON($res);
		break;

	case 'store':
# 接続 失敗時処理中断
		if(!connect('post')) {
			echoHTML($link->connect_error);
			break;
		}

# INSERT
		$title = !empty($_POST['title']) ? "'" . str_replace("'", "''", $_POST['title']) . "'" : 'NULL';
		$content = !empty($_POST['content']) ? "'" . str_replace("'", "''", $_POST['content']) . "'" : 'NULL';
		$icon = !empty((int)$_POST['icon']) ? (int)$_POST['icon']) : 'NULL';
		$sql = "INSERT INTO `posts` (`title`,`content`,`icon`) VALUES({$title},{$content},{$icon};";
		execute($sql);

# 実行したSQLの記録
		sqllog($sql);

		echoJSON('result', '投稿完了');
		break;

	case 'update':
# 接続 失敗時処理中断
		if(!connect('post')) {
			echoHTML($link->connect_error);
			break;
		}

# パラメーターチェック
		if(empty((int)$_POST['id'])) {
			echoJSON('result', 'パラメーターが正しくありません。');
			break;
		}

# UPDATE
		$title = !empty($_POST['title']) ? "'" . str_replace("'", "''", $_POST['title']) . "'" : 'NULL';
		$content = !empty($_POST['content']) ? "'" . str_replace("'", "''", $_POST['content']) . "'" : 'NULL';
		$icon = !empty((int)$_POST['icon']) ? (int)$_POST['icon']) : 'NULL';
		$sql = "UPDATE `posts` SET `title`={$title},`content`={$content},`icon`{$icon} WHERE `id`={(int)$_POST['id']};";
		execute($sql);

# 実行したSQLの記録
		sqllog($sql);

		echoJSON('result', '編集完了');
		break;

	case 'delete':
# 接続 失敗時処理中断
		if(!connect('post')) {
			echoHTML($link->connect_error);
			break;
		}

# パラメーターチェック
		if(empty((int)$_POST['id'])) {
			echoJSON('result', 'パラメーターが正しくありません。');
			break;
		}

# DELETE
		$sql = "DELETE FROM `posts` WHERE `id`={(int)$_POST['id']};";
		execute($sql);

# 実行したSQLの記録
		sqllog($sql);

		echoJSON('result', '削除完了');
}

# 切断
disconnect();
?>