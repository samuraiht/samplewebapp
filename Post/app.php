<?php
# モードが空の場合、何をするかわからないので、処理中断
if(empty($_GET['mode'])) exit;

require_once '../app/db.php';
require_once '../app/app.php';

function echoJSONArray($arr) {
	echo json_encode($arr);
}

function echoJSON($key, $val) {
	echoJSONArray([$key => $val]);
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
		echoJSONArray($res);
		break;

	case 'store':
# 接続 失敗時処理中断
		if(!connect('post')) {
			echoJSONArray($link->connect_error);
			break;
		}

# INSERT
		$title = !empty($_POST['title']) ? "'" . sqlEscape($_POST['title']) . "'" : 'NULL';
		$content = !empty($_POST['content']) ? "'" . sqlEscape($_POST['content']) . "'" : 'NULL';
		$icon = !empty((int)$_POST['icon']) ? (int)$_POST['icon'] : 'NULL';
		$sql = "INSERT INTO `posts` (`title`,`content`,`icon`) VALUES({$title},{$content},{$icon};";
		execute($sql);

# 実行したSQLの記録
		sqllog($sql);

		echoJSON('result', '投稿完了');
		break;

	case 'update':
# 接続 失敗時処理中断
		if(!connect('post')) {
			echoJSONArray($link->connect_error);
			break;
		}

# パラメーターチェック
		if(empty((int)$_POST['id'])) {
			echoJSON('result', 'パラメーターが正しくありません。');
			break;
		}

# UPDATE
		$id = (int)$_POST['id'];
		$title = !empty($_POST['title']) ? "'" . sqlEscape($_POST['title']) . "'" : 'NULL';
		$content = !empty($_POST['content']) ? "'" . sqlEscape($_POST['content']) . "'" : 'NULL';
		$icon = !empty($_POST['icon']) ? (int)$_POST['icon'] : 'NULL';
		$sql = "UPDATE `posts` SET `title`={$title},`content`={$content},`icon`={$icon} WHERE `id`={$id};";
		execute($sql);

# 実行したSQLの記録
		sqllog($sql);

		echoJSON('result', '編集完了');
		break;

	case 'delete':
# 接続 失敗時処理中断
		if(!connect('post')) {
			echoJSONArray($link->connect_error);
			break;
		}

# パラメーターチェック
		if(empty((int)$_POST['id'])) {
			echoJSON('result', 'パラメーターが正しくありません。');
			break;
		}

# DELETE
		$id = (int)$_POST['id'];
		$sql = "DELETE FROM `posts` WHERE `id`={$id};";
		execute($sql);

# 実行したSQLの記録
		sqllog($sql);

		echoJSON('result', '削除完了');
		break;

	case 'img':
# 接続 失敗時処理中断
		if(!connect('post')) {
			echoJSONArray($link->connect_error);
			break;
		}


# パラメーターチェック
		if(empty($_POST['org']) || empty($_POST['src'])) {
			echoJSON('result', 'パラメーターが正しくありません。');
			break;
		}

# INSERT
		$org = sqlEscape($_POST['org']);
		$src = sqlEscape($_POST['src']);
		$alt = !empty($_POST['alt']) ? "'" . sqlEscape($_POST['alt']) . "'" : 'NULL';
		connect('post');# 接続
		$sql = "INSERT INTO `images` (`org`,`src`,`alt`) VALUES('{$org}','{$src}',{$alt});";
		execute($sql);

# 実行したSQLの記録
		sqllog($sql);

		echoJSON('result', '画像アップロード完了');
}

# 切断
disconnect();
?>