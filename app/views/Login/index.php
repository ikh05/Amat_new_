<section style="overflow: visible;">
	<div style="overflow: visible;" class="container text-center">
		<div style="overflow: visible;" class="row satu-height justify-content-center align-items-center">
			<div style="overflow: visible;" class="col-12 col-sm-10 col-lg-5 ">
				<div style="overflow: visible;" class="card-flip">
					<div style="overflow: visible;" class="rotateFlip <?= isset($data['daftar']) ? 'flip' : '' ?>">
						<div class="front card p-2 <?= isset($data['daftar']) ? 'd-none' : '' ?>">
							<h3  class="border-bottom">Masuk</h3>
							<form action="<?= BASE_URL ?>login/masuk" method='post'>
								<!-- iterasi masuk (untuk membuka lupa pass) -->
								<input type="hidden" name="iterasi_masuk" value="<?= isset($data['masuk']) ? $data['masuk']['iterasi_masuk'] : 0 ?>" >

								<div class="input-group mb-3">
								 	<input type="text" class="shadow-sm form-control username-masuk" placeholder="Username/Email" name="username" autocomplete="off" value="<?= isset($data['masuk']) ? $data['masuk']['username'] : ''?>" required>
								</div>
								
								<div class="input-group mb-3">
									<button tabindex="-1" class="btn btn-secondary hide-pass shadow-sm" type="button">
										<i class="fa-regular fa-eye-slash"></i>
										<i class="d-none fa-regular fa-eye"></i>
									</button>
								  	<input type="password" class="form-control shadow-sm" placeholder="Password" name="password" autocomplete="off" id="pass" value="<?= isset($data['masuk']) ? $data['masuk']['password'] : '' ?>" required>
								</div>
								
								<button class="btn fw-bold btn-outline-primary btn-secondary text-white btn-masuk w-50 shadow-sm" name="submit">Masuk</button>
							</form>
							
							<div class="justify-content-center align-items-center">
								<p>Belum memiliki akun?</p>
								<button onclick="flip(this)" class="btn  btn-outline-primary btn-secondary text-white w-50 fw-bold">Daftar</button>
							</div>
						</div>


						<!-- daftar -->
						<div class="back card p-2 <?= isset($data['daftar']) ? '' : 'd-none' ?>">
							<h3 class="border-bottom">Daftar</h3>
							<div class="scroll" style="overflow-y: auto;">
								<form action="<?= BASE_URL ?>login/daftar" method='post'>

									<div class="input-group mb-3">
									  <input type="text" class="form-control username-daftar" placeholder="Username" name="username" autocomplete="off" value="<?= isset($data['daftar']) ? $data['daftar']['username'] : '' ?>" required>
									</div>

									<div class="input-group mb-3">
									  <input type="text" class="form-control username-daftar" placeholder="Nama Lengkap" name="nama" autocomplete="off" value="<?= isset($data['daftar']) ? $data['daftar']['nama'] : '' ?>" required>
									</div>
									
									<div class="input-group mb-3">
										<select name="jk" required class="form-select form-control">
											<option class="d-none">Jenis Kelamin</option>
											<option value="laki-laki">Laki-laki</option>
											<option value="perempuan">Perempuan</option>
										</select>
									</div>

									<div class="input-group mb-3">
										<button tabindex="-1" class="btn btn-secondary hide-pass" type="button" >
											<i class="fa-regular fa-eye-slash"></i>
											<i class="d-none fa-regular fa-eye"></i>
										</button>
									  	<input type="password" class="form-control password" placeholder="Password" name="password" autocomplete="off" id="pass1" value="<?= isset($data['daftar']) ? $data['daftar']['password'] : '' ?>" required>
									</div>								
									<div class="input-group mb-3">
									  	<input type="password" class="form-control password" placeholder="Ulangi Password" name="konfpassword" autocomplete="off" id="pass2" value="<?= isset($data['daftar']) ? $data['daftar']['konfpassword'] : '' ?>" required>
									</div>

									<button class="btn btn-outline-primary btn-secondary text-white btn-daftar w-50 fw-bold" name="submit" disabled>Daftar</button>
								</form>
								<div class="justify-content-center align-items-center">
									<p>Sudah punya akun?</p>
									<button onclick="flip(this)" class="btn btn-outline-primary btn-secondary text-white w-50 fw-bold">Masuk</button>
								</div>
							</div>
						</div>

						<div class="colorCard card"></div>
					</div>
				</div>
			</div>
		</div>
	</div>	
</section>

<script>
	window.addEventListener('load', function () {
		// besar card tetap
		let height_body = document.querySelector('body').offsetHeight;
		let allCard = document.querySelectorAll('section div.card');
		for (card of allCard) {
			card.style.height = (height_body-100)+'px';
		}
		document.querySelector('section div.colorCard').style.height = (height_body - 90)+'px';
		
		// besar tombol hidden pass tetap
		let allHidePass = document.querySelectorAll('form button.hide-pass');
		let width_hidden_pass = allHidePass[0].offsetWidth;
		if(document.querySelector('.front').classList.contains('d-none')){
			width_hidden_pass = allHidePass[1].offsetWidth;
		}
		for (button of allHidePass) {
			button.style.width = width_hidden_pass+'px';
		}
	});
	
	
	// cek form
	document.querySelector('.back').addEventListener('click', cekForm);
	document.querySelector('.back').addEventListener('input', cekForm);
	function cekJenisKelamin() {
		let selectJk = document.querySelector('.form-select[name=jk]');
		return (selectJk.value == 'perempuan' || selectJk.value == 'laki-laki') ? true : false;
	}
	function cekKonfirmasiPassword () {
		let pass1 = document.getElementById('pass1');
		let pass2 = document.getElementById('pass2');
		let button1 = pass1.previousElementSibling;
		let usernameDaftar = document.querySelector('input.username-daftar');
		let daftar = document.querySelector('.btn-daftar');
		if(pass1.value == pass2.value){
			pass1.classList.remove('border-danger');
			pass2.classList.remove('border-danger');
			pass1.previousElementSibling.classList.remove('border-danger');
			return true;
		}else {
			pass1.classList.add('border-danger');
			pass2.classList.add('border-danger');
			pass1.previousElementSibling.classList.add('border-danger');
			return false;
		}
	}

	function cekForm() {
		let boolKirimData = cekKonfirmasiPassword() && cekJenisKelamin();
		(boolKirimData) ? enebleKirimData() : disableKirimData();
	}
	function disableKirimData () {
		document.querySelector('.btn-daftar').setAttribute('disabled', true);
	}
	function enebleKirimData () {
		document.querySelector('.btn-daftar').removeAttribute('disabled');
	}

	// show/hidden pass masuk
	let masuk_hiddenPass = document.querySelector('.front .hide-pass');
	masuk_hiddenPass.addEventListener('click', function () {
		// ambil input
		let input = masuk_hiddenPass.parentElement.children[1];
		let icon1 = masuk_hiddenPass.children[0];
		let icon2 = masuk_hiddenPass.children[1];
		console.log(icon1);
		console.log(icon2);
		// ganti tipe dari input menjadi pass atau text || ganti class icon
		if(input.getAttribute('type') == 'password'){
			input.setAttribute('type', 'text');
		}else{
			input.setAttribute('type', 'password');
		}
		icon1.classList.toggle('d-none');
		icon2.classList.toggle('d-none');
	});


	// show/hidden pass daftar
	let daftar_hiddenPass = document.querySelector('.back .hide-pass');
	daftar_hiddenPass.addEventListener('click', function (){
		allPassword_Daftar = document.querySelectorAll('input.password');
		for (input of allPassword_Daftar) {
			if(input.getAttribute('type') != 'password') input.setAttribute('type', 'password');
			else input.setAttribute('type', 'text');
		}
		daftar_hiddenPass.children[0].classList.toggle('d-none');
		daftar_hiddenPass.children[1].classList.toggle('d-none');
	});



	// lempar ke halaman ubah pass
	document.querySelector('.lupaPass').addEventListener('click', function () {
		window.location.href = '<?= BASE_URL ?>login/lupaPass/<?= isset($data['masuk']) ? $data['masuk']['username'] : '_'  ?>';
	})
</script>