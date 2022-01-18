<?php require_once 'Controller.php'; ?><!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>記事一覧</title>
	<link rel="stylesheet" href="../app/css/reset.css">
	<link rel="stylesheet" href="post.css">
	<script src="../app/js/fetch.js"></script>
	<script src="post.js"></script>
</head>
<body>
	<h1>SimpleMVC async posts demo</h1>
	<nav>
		<ul>
			<li><a href="../">トップページ</a></li>
			<li><a href="admin.php">管理画面</a></li>
		</ul>
		<ul id="index">
			<li><a href="app.php?mode=index&id=1">
				<h2>title</h2>
				<div><img class="icon" src="img/corridor.jpg" alt="大学の廊下"></div>
			</a></li>
		</ul>
	</nav>
</body>
</html>