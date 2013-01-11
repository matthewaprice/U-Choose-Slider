jQuery(document).ready(function() {

	jQuery('.edit-slider').click(function() {
		var sliderId = jQuery(this).attr('id');
		sliderId = sliderId.split('-');
		jQuery('#slider-form-'+sliderId[2]).toggle();
	});
	
});