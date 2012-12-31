U-Choose-Slider
===============

WordPress Plugin that simply stores data for a slider and then gives a template tag so that you can use your own slider of choice


For use with jQuery Cycle
<code>
<script>
jQuery(document).ready(function() {
 	jQuery("#cycle").cycle({
		fx: "fade",
		random: 1
	});
});
</script>
<ul id="cycle">
	<?php $slider_images = get_ucs_slider_images(); ?>					
	<?php foreach ( $slider_images as $image ) : ?>
	<li>
		<a href="<?php echo $image->slider_link; ?>">
		<img src="<?php echo $image->slider_image; ?>">		
		</a>
		<div class="info-box">
			<a href="<?php echo $image->slider_link; ?>">				
				<p class="title"><?php echo $image->slider_title; ?></p>
			</a>
			<!--<p class="description"><?php echo $image->description; ?></p>-->
			<!--<p class="button-read-more"><a href="<?php echo $image->read_more_link; ?>" class="button">Read More</a></p>-->
		</div>			
		
	</li>
	<?php endforeach; ?>		
</ul>
</code>

For use with Twitter Bootstrap's Carousel
<code>
<script>
jQuery(document).ready(function() {
	jQuery('.carousel').carousel();	
});
</script>

<div id="my_carousel" class="carousel slide">
	<div class="carousel-inner">
		<?php $slider_images = get_ucs_slider_images(); ?>
		<?php
		$i = 0 ;
		foreach ( $slider_images as $img ) : ?>
		<div class="<?php echo ( $i == 0 ) ? 'active ' : ''; ?>item">
			<a href="<?php echo $img->slider_link; ?>">
			<img src="<?php echo $img->slider_image; ?>">
			<div class="carousel-caption">
				<h4><?php echo $img->slider_title; ?></h4>
				<p><?php echo $img->slider_description; ?></p>
			</div>
			</a>
		</div>
		<?php $i++; endforeach; ?>
	</div>
	<a class="carousel-control left" href="#my_carousel" data-slide="prev">&lsaquo;</a>
	<a class="carousel-control right" href="#my_carousel" data-slide="next">&rsaquo;</a>
</div>	
</code>