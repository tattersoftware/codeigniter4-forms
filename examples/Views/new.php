<?= $this->extend('layouts/public') ?>
<?= $this->section('main') ?>

<div class="container">
	<h1 class="display-4">Add Hero</h1>

	<div class="row">
		<div class="col">
			<?= view('heroes/form') ?>
		</div>
		<div class="col-md"></div>
		<div class="col-xl"></div>
	</div>
</div>

<?= $this->endSection() ?>
