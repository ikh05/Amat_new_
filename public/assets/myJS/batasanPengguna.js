export function batasanPengguna (argument) {
	// event tombil ditekan
	document.addEventListener('keydown', ev =>{
		if(ev.ctrlKey){
			let tekan = ev.key.toLowerCase();
			if(tekan === 's'){
				console.log('anda berusaha mengesave halaman!');
				event.preventDefault();
			}
			else if(tekan === 'u'){
				console.log('anda berusaha menampilkan code halaman!');
				event.preventDefault();
			}
		}
	})


	// mencegah klik kanan
	window.addEventListener('contextmenu', ev => {
		event.preventDefault();
	})
}
