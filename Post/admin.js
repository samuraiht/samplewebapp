/*global fetchJSON*/

window.onload = () => {
	const app = 'app.php',
				result = document.getElementById('result'),
				posts = document.getElementById('posts'),
				btnExe = document.getElementById('buttonExe'),
				inputs = [
					{ data : 'data-id', elem : document.getElementById('id'), initValue : '' },
					{ data : 'data-name', elem : document.getElementById('name'), initValue : '' },
					{ data : 'data-count', elem : document.getElementById('count'), initValue : '0' },
					{ data : 'data-price', elem : document.getElementById('price'), initValue : '0' },
					{ data : 'data-point', elem : document.getElementById('point'), initValue : '0' },
					{ data : 'data-shipping', elem : document.getElementById('shipping'), initValue : '0' }
				];
	let mode = 'store', oldValue;

	function showResult(data) {
		result.textContent = data.result;// メッセージ
		posts.innerHTML = data.html;// HTMLのtable要素の内容
		setButtonEvent();
		init();
	}

	function init() {
		mode = 'store';
		btnExe.textContent = '登録';
		for(const i of inputs) i.elem.value = i.initValue;
	}

	function setButtonEvent() {
		for(const t of document.getElementsByTagName('td')) {
			t.ondblclick = e => {
				const me = e.currentTarget;// 今ダブルクリックしたセル
				oldValue = me.textContent;
				result.textContent = '';
				if(me.getAttribute('contentEditable') == null) me.setAttribute('contentEditable', '');
				me.focus();
			};
			t.onblur = e => {
				const me = e.currentTarget;// 今フォーカスが外れたセル
				me.attributes.removeNamedItem('contentEditable');
				if(me.textContent != oldValue) fetchJSON(app, { mode : 'celledit' }, { id : me.parentElement.getAttribute('data-id'), col : me.getAttribute('data-col'), val : me.textContent }).then(data => { showResult(data); });
			};
		}

		for(const b of document.getElementsByClassName('update')) {
			b.onclick = e => {
				e.preventDefault();// 既定の動作の無効化
				const me = e.currentTarget;// 今押したボタン
				mode = 'update';// モード切替
				btnExe.textContent = '更新';// 実行ボタンの名目を変更
				result.textContent = '';
				for(const i of inputs) i.elem.value = me.getAttribute(i.data);
			};
		}

		for(const b of document.getElementsByClassName('delete')) {
			b.onclick = e => {
				e.preventDefault();//既定の動作の無効化
				result.textContent = '';
				if(confirm('本当に削除しますか？')) fetchJSON(app, { mode : 'delete' }, { id : e.currentTarget.getAttribute('data-id') }).then(data => { showResult(data); });
			};
		}
	}

	setButtonEvent();

	document.getElementById('store').onclick = () => {
		result.textContent = '';
		init();
	};

	btnExe.onclick = e => {
		switch(mode) {
			case 'store':// 新規
				fetchJSON(app, { mode : mode }, { name : document.getElementById('name').value, count : document.getElementById('count').value, price : document.getElementById('price').value, point : document.getElementById('point').value, shipping : document.getElementById('shipping').value }).then(data => { showResult(data); });
				break;
			case 'update':// 更新
				fetchJSON(app, { mode : mode }, { id : document.getElementById('id').value, name : document.getElementById('name').value, count : document.getElementById('count').value, price : document.getElementById('price').value, point : document.getElementById('point').value, shipping : document.getElementById('shipping').value }).then(data => { showResult(data); });
		}
	};
};