function LoadingBar() {
	var body = document.body;
	var div = document.createElement('div');
	div.style.width = '0px';
	div.style.height = '50px';
	div.align = "center";
	div.style.backgroundColor = '#3C6';
	body.appendChild(div);

	this.innerDiv = div;

	div = div.cloneNode();
	div.style.position = 'absolute';
	div.style.top = '0px';
	div.style.left = '0px';
	div.style.backgroundColor = '';
	div.style.border = '1px solid black';
	div.innerHTML = '<h4>Loading:</h4>';
	div.style.width = '400px';
	body.appendChild(div);

	this.outerDiv = div;

	this.setLoadFactor = function(factor) {
		// this.innerDiv.style.width = '30px';
		this.innerDiv.style.width = Math.round(parseInt(this.outerDiv.style.width)*factor) + 'px';
	}

	var loadFactor = 0;

	this.intervalFunc = function(obj) {
		loadFactor += 0.01;
		loadFactor = loadFactor > 1 ? 1 : loadFactor;
		obj.setLoadFactor(loadFactor);
	}

	setInterval(this.intervalFunc, 33, this);
}

window.onload = function() {
	// alert('All is okey!');
	var tableSelect = document.getElementById('tableSelect');
	var logFileSelect = document.getElementById('logFileSelect');
	var tableData = document.getElementById('tableData');

	tableSelect.onchange = function(e) {
		if (this.selectedIndex != 0) {
			logFileSelect.selectedIndex = 0;
			logFileSelect.onchange();
		}
		// var str = 'tableSelect was changed!\nArguments:\n';
		// for (var key in e) {
		// 	str += 'e[' + key + '] = ' + e[key] + ',\n';
		// }
		// alert(str);

		// alert('"' + this.selectedOptions.item(0).innerHTML + '" element was selected!');
		for (var i = 1; i < this.options.length; i++) {
			var table = document.getElementById(this.options[i].innerHTML);

			if (!table) {
				return;
			}

			var display_st;
			if (i == this.selectedIndex) {
				display_st = 'block';
			} else {
				display_st = 'none';
			}

			table.style.display = display_st;
		}

	}
	tableSelect.onchange();

	logFileSelect.onchange = function(e) {
		if (this.selectedIndex != 0) {
			tableSelect.selectedIndex = 0;
			tableSelect.onchange();
		}
		// var str = 'logFileSelect was changed!\nArguments:\n';
		// for (var key in e) {
		// 	str += 'e[' + key + '] = ' + e[key] + ',\n';
		// }
		// alert(str);

		// alert('"' + this.selectedOptions.item(0).innerHTML + '" element was selected!');
		for (var i = 1; i < this.options.length; i++) {
			var table = document.getElementById(this.options[i].innerHTML+'LF');

			if (!table) {
				alert('No table '+this.options[i].innerHTML+'LF');
				return;
			}

			var display_st;
			if (i == this.selectedIndex) {
				display_st = 'block';
			} else {
				display_st = 'none';
			}

			table.style.display = display_st;
		}

	}
	logFileSelect.onchange();
}