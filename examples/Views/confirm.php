	<p>Are you sure you want to remove <?= $hero->name ?>?</p>

	<?= form_open("heroes/delete/{$hero->id}", ['onsubmit' => 'return desktopSubmit(this, closeModal);']) ?>

		<button class="btn btn-primary" type="submit">Confirm</button>

		<a class="btn btn-secondary" href="<?= site_url("heroes/show/{$hero->id}") ?>"
			onclick="closeModal(); return ! isMobile();">Cancel</a>

		<div class="feedback"></div>

	<?= form_close() ?>
