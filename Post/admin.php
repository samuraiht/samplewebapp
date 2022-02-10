<?php require_once 'Controller.php'; ?><!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>記事管理</title>
	<link rel="stylesheet" href="../app/css/reset.css">
	<link rel="stylesheet" href="admin.css">
	<script src="../app/js/fetch.js"></script>
	<script src="admin.js"></script>
</head>
<body>
	<nav><a href="./">トップページ</a></nav>
	<table>
		<thead>
			<tr>
				<th>ID</th>
				<th>タイトル</th>
				<th>本文</th>
				<th>サムネ</th>
				<th>編集</th>
				<th>削除</th>
			</tr>
		</thead>
		<tbody id="data"><?php echo $data; ?></tbody>
	</table>
	<button id="store">新規</button>
	<form>
		<input type="hidden" id="id">
		<div><label for="title">タイトル</label><input type="text" id="title"></div>
		<div><label for="content">本文</label><textarea id="content" cols="50" rows="10"></textarea></div>
		<div><label for="icon">アイコン</label><select id="icon"><?php echo $icon; ?></select></div>
	</form>
	<form>
		<div><label for="src">画像を選択</label><input type="file" id="src" accept="image/*"></div>
		<div><label for="alt">画像の説明</label><input type="text" id="alt" placeholder="画像の説明　教材:大学の廊下"></div>
	</form>
	<button id="upload">画像のアップロード</button>
	<button id="buttonExe">登録</button>
	<div id="result"></div>
</body>
</html>