<div class="slider-container">
	<ul>
		<?php
			$cities = pods('city', array(
				'limit' => -1
			));
			while ($cities->fetch()):
				$img = get_the_post_thumbnail($cities->display('ID'), 'full', array());
				$img = preg_replace('/(width|height)="\d+"/', '', $img);
		?>
		<li>
			<img src="<?php echo $img ?>" alt="">
			<div class="content">
				<h1><?php echo $cities->display('post_title'); ?></h1>
				<h3>Known for: <?php echo $cities->display('known_for'); ?></h3>
				<div class="excerpt">
					<p><?php echo $cities->display('excerpt'); ?></p>
				</div>
			</div>
<!-- 			<div class="flag-bubble">
				<img src="<?php echo $cities->display('city_flag'); ?>">
			</div> -->
		</li>
		<?php endwhile; ?>
	</ul>
	<div class="control left" id="control-left">&lt;</div>
	<div class="control right" id="control-right">&gt;</div>
</div>