<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>SampleWebApp</title>
	<link rel="stylesheet" href="app/css/reset.css">
	<script src="app/js/fetch.js"></script>
	<script src="index.js"></script>
</head>
<body>
	<h1>SimpleMVC Web Application</h1>
	<nav>
		<h2>機能一覧</h2>
		<ul>
			<li><a href="Flower/">花の在庫管理画面</a></li>
			<li><a href="Post/">記事投稿機能</a></li>
		</ul>
		<h2>データベース初期化</h2>
		<ul>
			<li><button id="initApp" class="warn">アプリ初期化</button></li>
			<li><button id="initFlower" class="warn">花の在庫初期化</button></li>
			<li><button id="initPost" class="warn">記事投稿初期化</button></li>
		</ul>
	</nav>
	<div id="result"></div>
</body>
</html>