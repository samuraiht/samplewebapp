window.onload = () => {
	let mode = 'create';

	function setButtonEvent() {
		const buttonUpdate = document.getElementsByClassName('update');
		for(let i in buttonUpdate) {
			buttonUpdate[i].onclick = e => {
				e.preventDefault();//既定の動作の無効化
				const me = e.currentTarget;
				mode = 'update';
				document.getElementById('buttonExe').textContent = '更新';
				document.getElementById('id').value = me.getAttribute('data-id');
				document.getElementById('name').value = me.getAttribute('data-name');
				document.getElementById('count').value = me.getAttribute('data-count');
			};
		}

		const buttonDelete = document.getElementsByClassName('delete');
		for(let i in buttonDelete) {
			buttonDelete[i].onclick = e => {
				e.preventDefault();//既定の動作の無効化
		 		if(confirm('本当に削除しますか？')) {
		 			const dataId = e.currentTarget.getAttribute('data-id');
		 			fetchJSON('ajax.php', 'mode=delete', 'id=' + dataId).then(data => { showResult(data); });
		 		}
				mode = 'create';
	  		document.getElementById('buttonExe').textContent = '登録';
				document.getElementById('name').value = '';
				document.getElementById('count').value = '0';
			};
		}
	}

	function showResult(data) {
		document.getElementById('result').textContent = data.result;
		document.getElementById('data').innerHTML = data.html;
		setButtonEvent();
	}

	setButtonEvent();

	document.getElementById('init').onclick = e => {
   	fetchJSON('model.php').then(data => { showResult(data); });
	}

	document.getElementById('create').onclick = e => {
		mode = 'create';
		document.getElementById('buttonExe').textContent = '登録';
		document.getElementById('name').value = '';
		document.getElementById('count').value = '0';
	};

	document.getElementById('buttonExe').onclick = e => {
    switch(mode) {
    	case 'create'://新規
	    	fetchJSON('ajax.php', 'mode=create', 'name=' + document.getElementById('name').value + '&count=' + document.getElementById('count').value).then(data => { showResult(data); });
    		break;
    	case 'update'://更新
	    	fetchJSON('ajax.php', 'mode=update', 'id=' + document.getElementById('id').value + '&name=' + document.getElementById('name').value + '&count=' + document.getElementById('count').value).then(data => { showResult(data); });
    }
	};
};