<h1><?= $data['header'] ?></h1>
<p>Berisi Menu-menu yang dapat kamu pilih</p>
<div class="row">
	<?php foreach ($data['menu'] as $value): ?>
		<div class="col-6 tombolMenu btn btn-danger" style="color: #555;" klik="ubahMenu" url="<?= BASE_URL.$value['url'] ?>">
			<p><?= $value['text'] ?></p>
		</div>
	<?php endforeach; ?>
</div>
