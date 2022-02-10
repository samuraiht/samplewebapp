<?php require_once 'Controller.php'; ?><!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>花の一覧</title>
	<link rel="stylesheet" href="../app/css/reset.css">
	<link rel="stylesheet" href="flower.css">
	<script src="../app/js/fetch.js"></script>
	<script src="flower.js"></script>
</head>
<body>
	<h1>SimpleMVC database admin demo</h1>
	<nav><a href="../">トップページ</a></nav>
	<table>
		<thead>
			<tr>
				<th>商品番号</th>
				<th>名称</th>
				<th>在庫</th>
				<th>価格</th>
				<th>ポイント</th>
				<th>送料</th>
				<th>編集</th>
				<th>削除</th>
			</tr>
		</thead>
		<tbody id="data"><?php echo $html; ?></tbody>
	</table>
	<button id="store">登録・入荷</button>
	<form>
		<input type="hidden" id="id">
		<div><label for="name">品目</label><input type="text" id="name"></div>
		<div><label for="count">在庫</label><input type="number" id="count" value="0"></div>
		<div><label for="price">価格</label><input type="number" id="price" value="0"></div>
		<div><label for="point">ポイント</label><input type="number" id="point" value="0"></div>
		<div><label for="shipping">送料</label><input type="number" id="shipping" value="0"></div>
	</form>
	<button id="buttonExe">登録</button>
	<div id="result"></div>
</body>
</html>