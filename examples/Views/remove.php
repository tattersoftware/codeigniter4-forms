<?= $this->extend('layouts/public') ?>
<?= $this->section('main') ?>

<div class="container">
	<h1 class="display-4">Remove Hero</h1>

	<div class="row">
		<div class="col">
			<?= view('heroes/confirm', ['hero' => $hero]) ?>

			<?= view('heroes/display', ['hero' => $hero]) ?>
		</div>
		<div class="col-md"></div>
		<div class="col-xl"></div>
	</div>

</div>

<?= $this->endSection() ?>
