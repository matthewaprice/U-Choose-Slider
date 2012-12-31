U-Choose-Slider
===============

WordPress Plugin that simply stores data for a slider and then gives a template tag so that you can use your own slider of choice


For use with jQuery Cycle
<pre>
&lt;script&gt;
jQuery(document).ready(function() {
 	jQuery("#cycle").cycle({
		fx: "fade",
		random: 1
	});
});
&lt;/script&gt;
&lt;ul id="cycle"&gt;
	&lt;?php $slider_images = get_ucs_slider_images(); ?&gt;					
	&lt;?php foreach ( $slider_images as $image ) : ?&gt;
	&lt;li&gt;
		&lt;a href="&lt;?php echo $image-&gt;slider_link; ?&gt;"&gt;
		&lt;img src="&lt;?php echo $image-&gt;slider_image; ?&gt;"&gt;		
		&lt;/a&gt;
		&lt;div class="info-box"&gt;
			&lt;a href="&lt;?php echo $image-&gt;slider_link; ?&gt;"&gt;				
				&lt;p class="title"&gt;&lt;?php echo $image-&gt;slider_title; ?&gt;&lt;/p&gt;
			&lt;/a&gt;
			&lt;!--&lt;p class="description"&gt;&lt;?php echo $image-&gt;description; ?&gt;&lt;/p&gt;--&gt;
			&lt;!--&lt;p class="button-read-more"&gt;&lt;a href="&lt;?php echo $image-&gt;read_more_link; ?&gt;" class="button"&gt;Read More&lt;/a&gt;&lt;/p&gt;--&gt;
		&lt;/div&gt;			
		
	&lt;/li&gt;
	&lt;?php endforeach; ?&gt;		
&lt;/ul&gt;
</pre>

For use with Twitter Bootstrap's Carousel
<pre>
&lt;script&gt;
jQuery(document).ready(function() {
	jQuery('.carousel').carousel();	
});
&lt;/script&gt;

&lt;div id="my_carousel" class="carousel slide"&gt;
	&lt;div class="carousel-inner"&gt;
		&lt;?php $slider_images = get_ucs_slider_images(); ?&gt;
		&lt;?php
		$i = 0 ;
		foreach ( $slider_images as $img ) : ?&gt;
		&lt;div class="&lt;?php echo ( $i == 0 ) ? 'active ' : ''; ?&gt;item"&gt;
			&lt;a href="&lt;?php echo $img-&gt;slider_link; ?&gt;"&gt;
			&lt;img src="&lt;?php echo $img-&gt;slider_image; ?&gt;"&gt;
			&lt;div class="carousel-caption"&gt;
				&lt;h4&gt;&lt;?php echo $img-&gt;slider_title; ?&gt;&lt;/h4&gt;
				&lt;p&gt;&lt;?php echo $img-&gt;slider_description; ?&gt;&lt;/p&gt;
			&lt;/div&gt;
			&lt;/a&gt;
		&lt;/div&gt;
		&lt;?php $i++; endforeach; ?&gt;
	&lt;/div&gt;
	&lt;a class="carousel-control left" href="#my_carousel" data-slide="prev"&gt;&lsaquo;&lt;/a&gt;
	&lt;a class="carousel-control right" href="#my_carousel" data-slide="next"&gt;&rsaquo;&lt;/a&gt;
&lt;/div&gt;	
</pre>