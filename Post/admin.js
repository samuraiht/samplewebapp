/*global fetchJSON*/

window.onload = () => {
	const app = 'app.php',
				result = document.getElementById('result'),
				posts = document.getElementById('posts'),
				src = document.getElementById('src'),
				alt = document.getElementById('alt'),
				btnExe = document.getElementById('buttonExe'),
				inputs = [
					{ data : 'data-id', elem : document.getElementById('id'), initValue : '' },
					{ data : 'data-title', elem : document.getElementById('title'), initValue : '' },
					{ data : 'data-content', elem : document.getElementById('content'), initValue : '' },
					{ data : 'data-icon', elem : document.getElementById('icon'), initValue : '' }
				];
	let mode = 'store', oldValue;

	function showResult(data) {
		result.textContent = data.result;// メッセージ
//		posts.innerHTML = data.html;// HTMLのtable要素の内容
		setButtonEvent();
		init();
	}

	function init() {
		mode = 'store';
		btnExe.textContent = '投稿';
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

	document.getElementById('upload').onclick = () => {
		if(!src.files.length) {
			result.innerHTML = '画像を選択してください。';
			return;
		}
		const reader = new FileReader();
		reader.readAsDataURL(src.files[0]);
		reader.onload = () => { fetchJSON(app, { mode : 'img' }, { org : src.files[0].name, src : reader.result, alt : alt.value }).then(data => { showResult(data); }); };
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