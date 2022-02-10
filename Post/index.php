<?php require_once 'Controller.php'; ?><!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>記事一覧</title>
	<link rel="stylesheet" href="../app/css/reset.css">
	<link rel="stylesheet" href="post.css">
</head>
<body>
	<h1>SimpleMVC async posts demo</h1>
	<nav>
		<ul>
			<li><a href="../">トップページ</a></li>
			<li><a href="admin.php">管理画面</a></li>
		</ul>
		<ul id="posts"><?php echo $html; ?></li>
		</ul>
	</nav>
</body>
</html>