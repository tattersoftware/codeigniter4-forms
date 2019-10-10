
<?php foreach ($heroes as $hero): ?>
		
<?= view('heroes/display', ['hero' => $hero]) ?>

<?php endforeach; ?>
