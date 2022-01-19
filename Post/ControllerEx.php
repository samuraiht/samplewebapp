<?php
# imagesから画像一覧を取得
$sql = 'SELECT `id`,`src`,`alt` FROM `images`;';
$images = select($sql);

# 実行したSQLの記録
execute("INSERT INTO `debug`.`sqllog` (`sql`) VALUES('" . str_replace("'", "''", $sql) . "');");

$icon = '';
foreach($images as $img) $icon .= '<option value="' . $img['id'] . '"><img src="' . $img['src'] . '" alt="' . $img['alt'] . '"></option>';

# postsから記事一覧を取得
$sql = 'SELECT `posts`.`id`,`posts`.`title`,`posts`.`content`,`posts`.`icon`,`images`.`src`,`images`.`alt` FROM `posts` LEFT JOIN `images` ON `posts`.`icon`=`images`.`id`;';
$list = select($sql);

# 実行したSQLの記録
execute("INSERT INTO `debug`.`sqllog` (`sql`) VALUES('" . str_replace("'", "''", $sql) . "');");

$html = '';
$data = '';
foreach($list as $item) {
# <li><a href="app.php?mode=show&id=1"><h2>title</h2><div><img class="icon" src="img/corridor.jpg" alt="大学の廊下"></div></a></li>
	$html .= '<li><a href="app.php?mode=show&id=' . $item['id'] . '"><h2>title</h2><div><img class="icon" src="' . $item['src'] . '" alt="' . $item['alt'] . '"></div></a></li>';
# <tr data-id="1"><td data-col="id">1</td><td data-col="title">タイトル</td><td data-col="content">本文</td><td data-col="icon" class="number">1</td><td><button data-id="1" data-title="タイトル" data-content="本文" class="update">編集</button></td><td><button data-id="1" class="delete warn">削除</button></td></tr>
	$select = '';
	foreach($images as $img) $select .= '<option value="' . $img['id'] . '"' . ($img['id'] == $item['icon'] ? ' selected' : '') . '><img src="' . $img['src'] . '" alt="' . $img['alt'] . '"></option>';
	$data .= '<tr data-id="' . $item['id'] . '"><td data-col="id">' . $item['id'] . '</td><td data-col="title">' . $item['title'] . '</td><td data-col="content">' . $item['content'] . '</td><td class="number"><select data-col="icon">' . $select . '</select></td><td><button data-id="' . $item['id'] . '" data-title="' . $item['title'] .  '" data-content="' . $item['content'] . '" data-icon="' . $item['icon'] . '" class="update">編集</button></td><td><button data-id="' . $item['id'] . '" class="delete warn">削除</button></td></tr>';
}
?>