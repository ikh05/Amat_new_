export function functionAjax (url, functionBerhasil = function(){}, functionGagal = function(){}, syarat = true){
	let xhr = new XMLHttpRequest();
	xhr.open('GET', url);
	xhr.send();
	xhr.onload = function (e) {
		if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200){
			let hasil = xhr.responseText;
			if(typeof(syarat) === 'string'){
				if(hasil.search(syarat) != -1){
					functionBerhasil(hasil);
				}else{
					functionGagal(hasil);
				}
			}else{
				if(syarat){
					functionBerhasil(hasil);
				}else{
					functionGagal(hasil);
				}
			}
		}
	}
}
