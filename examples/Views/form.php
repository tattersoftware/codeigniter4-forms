
	<?= form_open(isset($hero) ? "heroes/{$hero->id}" : 'heroes', ['onsubmit' => 'return desktopSubmit(this, closeModal);']) ?>

		<div class="form-group">
			<label for="name">Name</label>
			<input name="name" type="text" value="<?= set_value('name', $hero->name ?? '') ?>" class="form-control" id="name" placeholder="Enter name" />
			<div id="name-feedback"></div>
		</div>

		<div class="form-group">
			<label for="power">Power</label>
			<input name="power" type="text" value="<?= set_value('power', $hero->power ?? '') ?>" class="form-control" id="power" placeholder="Enter superpower" />
			<div id="power-feedback"></div>
		</div>

		<button class="btn btn-primary" type="submit"><?= isset($hero) ? 'Update' : 'Create' ?></button>

		<div class="feedback"></div>

	<?= form_close() ?>
