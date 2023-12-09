export function hex (selektor) {
	let hexs = document.querySelectorAll(selektor);
	for (hex of hexs) {
		let width = hex.getAttribute('width');
		let height = hex.getAttribute('height');

		if(width != undefined){
			height = width * Math.sqrt(3);
		}else if(height != undefined){
			width = height / Math.sqrt(3);
		}else{
			width = 100;
			height = 100 * Math.sqrt(3);
		}

		hex.style.height = height + 'px';
		hex.style.width = width + 'px';
	}
}