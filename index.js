/*global fetchJSON*/

window.onload = () => {
	const result = document.getElementById('result');

	function init(target) {
		result.textContent = '';
		if(confirm('本当に初期化しますか？この操作は元に戻せません。')) fetchJSON(`${target}/Model.php`).then(data => { result.textContent = data.result; });
	}

	document.getElementById('initApp').onclick = e => { init('app'); };
	document.getElementById('initFlower').onclick = e => { init('Flower'); };
	document.getElementById('initPost').onclick = e => { init('Post'); };
};