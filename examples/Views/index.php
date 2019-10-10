<?= $this->extend('layouts/public') ?>
<?= $this->section('main') ?>

<div class="container">
	<button type="button" class="btn btn-primary float-right" onclick="return desktopModal('heroes/new');"><i class="fas fa-plus-circle"></i> New hero</button>
	<h1 class="display-4">Heroes</h1>

	<?php if (empty($heroes)): ?>
	
	<p>You don't have any heroes! Would you like to <a href="<?= site_url('heroes/new') ?>" onclick="return desktopModal('heroes/new');">add one now</a>?</p>
	
	<?php else: ?>

	<div class="card-deck">
		<?= view('heroes/list', ['heroes' => $heroes]) ?>
	<?php endif; ?>
	
</div>

<?= $this->endSection() ?>
