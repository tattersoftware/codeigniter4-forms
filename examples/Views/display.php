
		<div class="card hero mb-3" data-id="<?= $hero->id ?>" style="min-width: 12rem; max-width: 12rem;">
			<img src="<?= $hero->portrait ?? base_url('assets/portraits/generic.png') ?>" class="card-img-top" alt="Hero portrait">
			<div class="card-body">
				<h5 class="card-title"><?= $hero->name ?></h5>
				<p class="card-text"><small class="text-muted"><?= $hero->power ?></small></p>
				<p class="card-text"><?= $hero->description ?></p>
			</div>
			<div class="card-footer">
				<a class="card-link btn btn-primary" href="<?= site_url("heroes/show/{$hero->id}") ?>">Details</a>
				<a class="card-link btn btn-link" href="<?= site_url("heroes/edit/{$hero->id}") ?>" onclick="return desktopModal('heroes/edit/{$hero->id}');">Edit</a>
			</div>
		</div>
