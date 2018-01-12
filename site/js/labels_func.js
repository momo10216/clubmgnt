function removeOptions(select) {
    var i;
    for(i = select.options.length - 1 ; i >= 0 ; i--)
    {
        select.remove(i);
    }
}

function producerSelected() {
	var producer = document.getElementById('producer').value;
	var select = document.getElementById('format');
	removeOptions(select);
	for(var i = 0; i < formats[producer].length; i++) {
		var opt = formats[producer][i];
		var el = document.createElement('option');
		el.textContent = opt;
		el.value = opt;
		select.appendChild(el);
	}
	formatSelected();
}

function formatSelected() {
	var producer = document.getElementById('producer').value; 
	var format = document.getElementById('format').value; 
	var select = document.getElementById('product');
	var key = producer+'|'+format;
	removeOptions(select);
	for(var i = 0; i < products[key].length; i++) {
		var opt = products[key][i].name;
		var el = document.createElement('option');
		el.textContent = opt;
		el.value = opt;
		select.appendChild(el);
	}
	productSelected();
}

function productSelected() {
	var producer = document.getElementById('producer').value;
	var format = document.getElementById('format').value;
	var product = document.getElementById('product').value;
	var key = producer+'|'+format;
	for(var i = 0; i < products[key].length; i++) {
		var entry = products[key][i];
		if (product = entry.name) {
			document.getElementById('pageWidth').value = entry.pageWidth;
			document.getElementById('pageHeight').value = entry.pageHeight;
			document.getElementById('pageMarginTop').value = entry.pageMarginTop;
			document.getElementById('pageMarginLeft').value = entry.pageMarginLeft;
			document.getElementById('pageOrientation').value = entry.pageOrientation;
			document.getElementById('rows').value = entry.rows;
			document.getElementById('columns').value = entry.columns;
			document.getElementById('spacingHorizontal').value = entry.spacingHorizontal;
			document.getElementById('spacingVertical').value = entry.spacingVertical;
			document.getElementById('labelWidth').value = entry.labelWidth;
			document.getElementById('labelHeight').value = entry.labelHeight;
		}
	}
}

var select = document.getElementById('producer');
for(var i = 0; i < producer.length; i++) {
	var opt = producer[i];
	var el = document.createElement('option');
	el.textContent = opt;
	el.value = opt;
	select.appendChild(el);
}
producerSelected();

