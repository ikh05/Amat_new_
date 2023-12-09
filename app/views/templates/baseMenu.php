<!-- identitas -->
<div id="identitas" class="fixed-top">
	<div class="row" style="padding: 10px; top: 10px; margin: 10px 10px 10px 0; border: 3px solid var(--bs-primary); border-left: none; background-color: var(--container_Dark); border-radius: 0px 10px 10px 0px;">
		<div class="position-relative" style="width: 80px !important;">
			<div class="position-absolute top-50 start-50 translate-middle" style="border-radius: 50%; height: 75px; width: 75px; background-color: #5555; border: 1px solid #fff5;"></div>
			<img class="position-absolute top-50 start-50 translate-middle" src="<?= BASE_URL ?>assets/img/profil/<?= $_SESSION[LOGIN]['foto_profil'] ?>" alt="foto profil" style="width: 75px;">
		</div>
		<div class="col">
			<div class="row">
				<p class="text-capitalize fw-bold"><?= $_SESSION[LOGIN]['nama'] ?></p>
			</div>
			<div class="row">
				<p class="text-capitalize fst-italic">@<?= $_SESSION[LOGIN]['username'] ?></p>
			</div>
		</div>
	</div>
</div>



<!-- belum di pas kan ditengah-tengah -->
<div id="spinLoading" class="w-100 h-100 position-absolute">
	<i class="fa-solid fa-spinner fa-spin position-absolute top-50 start-50" style="font-size: 50px; overflow: visible; z-index: 10000; color: white; transform-origin: center center;"></i>
</div>


<div id="menu" class="position-absolute" style="padding: 10px; border: 2px solid var(--bs-primary); background-color: var(--container_Dark); border-radius: 10px 0 0 10px; border-right: none; overflow-y: auto;">
</div>

<!-- navigasi -->
<section id="navigasi">
	<nav class="fixed-bottom" style="margin-top: 10px; border-top: 2px solid var(--bs-primary); background-color: var(--container_Dark); height: 65px;">
		<!-- <div class="hex position-absolute" height="30" style="border-top: 1px solid var(--bs-primary); border-bottom: 1px solid var(--bs-primary); background-color: #444;"></div> -->
		<div class="position-relative" style="width: 100%; height: 100%;">
			<div id="menuNav" class="row position-absolute translate-middle top-50 start-50 text-center w-100 m-0" style="margin: 5px;">
				<div class="col <?= $data['judul'] == 'Home' ? 'aktif' : ''; ?>" klik="ubahMenu" url='Home/potralMenu/beranda' target='#menu'>
					<i class="fa-sharp fa-solid fa-house"></i>
				</div>
				<div class="col <?= $data['judul'] == 'Profil' ? 'aktif' : ''; ?>" klik="ubahMenu" url='Profil/potralMenu' target='#menu'>
					<i class="fa-sharp fa-solid fa-user"></i>
				</div>
				<div class="col" klik="ubahMenu" url='Tugas/potralMenu/index' target="#menu">
					<i class="fa-sharp fa-ragular fa-pen"></i>
				</div>
				<div class="col" klik="ubahMenu" url='Home/setting/index' target="#menu">
					<i class="fa-sharp fa-ragular fa-sliders"></i>
				</div>
				<div class="col"><a href="<?= BASE_URL ?>Login/keluar">
					<i class="fa-sharp fa-ragular fa-xmark"></i>
				</a></div>
			</div>
		</div>
	</nav>
</section>
<style type="text/css">
	#menuNav .aktif i{
		color: var(--bs-primary);
		transition: all .5s;
		transform-origin: center center;
		transform: scale(1.5);
		overflow: visible;
	} 
</style>

<script type="module">
	import {batasanPengguna} from '<?= BASE_URL ?>assets/myJs/batasanPengguna.js';
	// batasanPengguna();


	import {functionAjax} from '<?= BASE_URL ?>assets/myJS/ajax.js';

	// atur Ukuran #menu
	function aturUkuran () {
		let identitas = document.getElementById('identitas');
		let menu = document.getElementById('menu');
		let nav = document.querySelector('nav');
		let body = document.body;
		menu.style.top = (identitas.offsetHeight) + 'px';
		menu.style.width = '100vw';
		menu.style.height = (body.offsetHeight - identitas.offsetHeight - 75) + 'px';
	}
	window.addEventListener('resize', aturUkuran);
	window.addEventListener('load', ()=>{
		aturUkuran();
		ubahMenu();
	});


	// mengubah menu yang ditampilkan sesuai dengan navbar yang dipilih
	let allTombolNav = document.querySelectorAll('#menuNav [klik="ubahMenu"]');
	for (let tombol of allTombolNav) {
		tombol.addEventListener('click', ()=>{
			if(!tombol.classList.contains('aktif')){
				document.querySelector('#menuNav .aktif').classList.remove('aktif');
				tombol.classList.add('aktif');
				document.getElementById('spinLoading').classList.remove('d-none');
				ubahMenu();
			}
		});
	}

	function ubahMenu () {
		let url = document.querySelector('#menuNav .aktif').getAttribute('url');
		url = '<?= BASE_URL ?>'+url;
		functionAjax (url, function (e) {
			window.location.href = '<?= BASE_URL ?>Home';
		}, function (e){
			document.getElementById('spinLoading').classList.add('d-none');
			document.getElementById('menu').innerHTML = e;
			pembaharuanEventMenu();
		}, 'meta charset');
	}
	function pembaharuanEventMenu(){
		let allTombolMenu = document.querySelectorAll('#menu [klik=ubahMenu]');
	 	console.log('allTombolMenu');
	 	console.log(allTombolMenu);
		for(let tombol of allTombolMenu) {
			tombol.addEventListener('click', ()=>{
				console.log(tombol);
				document.getElementById('spinLoading').classList.remove('d-none');
				let url = tombol.getAttribute('url');
				functionAjax(url, (e)=>{
					document.getElementById('spinLoading').classList.add('d-none')
					document.getElementById('menu').innerHTML = e;
					pembaharuanEventMenu();
				});
			})
		}
	}

</script>
