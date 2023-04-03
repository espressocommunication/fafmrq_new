<?php $file = get_field('file'); if($file) : ?>
	<div class="article">
		<h3>Fichier attaché</h3>
		<b><?php echo $file['title']; ?></b>
		<p><?php echo $file['description']; ?></p>
		<p><a href="<?php echo $file['url']; ?>">Télécharger</a></p>
	</div>
<?php endif ?>
<?php $file2 = get_field('file2'); if($file2) : ?>
	<div class="article">
		<h3>Fichier attaché</h3>
		<b><?php echo $file2['title']; ?></b>
		<p><?php echo $file2['description']; ?></p>
		<p><a href="<?php echo $file2['url']; ?>">Télécharger</a></p>
	</div>
<?php endif ?>
<?php $file3 = get_field('file3'); if($file3) : ?>
	<div class="article">
		<h3>Fichier attaché</h3>
		<b><?php echo $file3['title']; ?></b>
		<p><?php echo $file3['description']; ?></p>
		<p><a href="<?php echo $file3['url']; ?>">Télécharger</a></p>
	</div>
<?php endif ?>