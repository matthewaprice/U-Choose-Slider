<?php
class UCS_Slider {

	public function __construct() {
		
		add_action( 'admin_enqueue_scripts', array( &$this, 'UCSRegisterJs' ) );
								
	}
	
	public function UCSRegisterJs() {

		wp_register_script( 'ucs-scripts', WP_PLUGIN_URL . '/u-choose-slider/js/scripts.js', array( 'jquery' ), '', true );
		wp_enqueue_script( 'ucs-scripts' );
				
	}
	
	public function UCSSliderSettings() {
		
		$inserted = $updated = false;
		
		if ( isset( $_POST['submit'] ) && check_admin_referer('ucs-settings') ) :
		
			global $wpdb;
			$values = array(
				'slider_title' => stripslashes_deep( $_POST['_slider_title'] ),
				'slider_description' => stripslashes_deep( $_POST['_slider_description'] ),
				'slider_link' => stripslashes_deep( $_POST['_slider_link'] ),
				'slider_image' => stripslashes_deep( $_POST['_slider_image'] ),
				'slider_active' => stripslashes_deep( $_POST['_slider_active'] ),																
			);
			$formats = array( 
				'%s','%s','%s','%s','%d'
			);
			$insert = $wpdb->insert( $wpdb->prefix . 'ucs_slider', $values, $formats );
			if ( $insert )
				$inserted = true;
				
		endif;
		
		if ( isset( $_POST['update'] ) && check_admin_referer('ucs-edit-slider-settings') ) :
			
			global $wpdb;
			$values = array(
				'slider_title' => stripslashes_deep( $_POST['_slider_title'] ),
				'slider_description' => stripslashes_deep( $_POST['_slider_description'] ),
				'slider_link' => stripslashes_deep( $_POST['_slider_link'] ),
				'slider_image' => stripslashes_deep( $_POST['_slider_image'] ),
				'slider_active' => stripslashes_deep( $_POST['_slider_active'] ),																
			);
			$where = array(
				'id' => $_POST['_slider_id']
			);
			$values_formats = array(
				'%s','%s','%s','%s','%d'
			);
			$where_formats = array(
				'%d'
			);
			$update = $wpdb->update( $wpdb->prefix . 'ucs_slider', $values, $where, $values_formats, $where_formats );
			if ( $update )
				$updated = true;
				
		endif;
		
		?>
		<div class="wrap">
			<h2>U Choose Slider Management</h2>
			<?php if ( $inserted ) : ?><?php echo "<div id='message' class='updated fade'><p>Slider has been added.</p></div>" ?><?php endif; ?>						
			<?php if ( $updated ) : ?><?php echo "<div id='message' class='updated fade'><p>Slider has been updated.</p></div>" ?><?php endif; ?>						
			
			<form action="" method="post">
				<table class="form-table">
					<tr valign="top">
						<th scope="row"><label for="_slider_title">Slider Title</label></th>
						<td><input name="_slider_title" type="text" id="_slider_title" value="" class="regular-text"></td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="_slider_description">Slider Description</label></th>
						<td><textarea style="width: 400px; height: 100px;" name="_slider_description" id="_slider_description" value="" class="regular-text"></textarea></td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="_slider_link">Slider Link</label></th>
						<td>
							<input name="_slider_link" type="text" id="_slider_link" value="" class="regular-text">
							<p class="description">Where do you want the site visitor to go when clicking image?</p>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="_slider_image">Slider Image</label></th>
						<td>
							<input name="_slider_image" type="text" id="_slider_image" value="" class="regular-text">
							<p class="description">Upload the image to the <a href="/wp-admin/upload.php">media library</a> and then paste in the url here. (size: 710w x 300h)</p>							
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="_slider_active">Make Active Now?</label></th>
						<td><input name="_slider_active" type="checkbox" id="_slider_active" value="1" class="regular-text" checked="checked"></td>
					</tr>																				
				</table>
				<?php wp_nonce_field( 'ucs--settings' ); ?>				
				<p class="submit"><input type="submit" name="submit" id="submit" class="button-primary" value="Create Slider Image"></p>				
			</form>
			
			<h3>Active Slider Images</h3>
			<table class="widefat">
				<thead>
					<tr>
						<th>Title</th>
						<th>Description</th>
						<th>Link</th>
						<th>Image</th>
						<th>Active</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php
					$images = $this->UCSGetSliderImages( 'active' ); 
					foreach ( $images as $image ) :
					?>
					<tr>
						<td><?php echo $image->slider_title; ?></td>
						<td><?php echo $image->slider_description; ?></td>
						<td><?php echo $image->slider_link; ?></td>
						<td><img src="<?php echo $image->slider_image; ?>" width="200"></td>
						<td>
							<?php
							switch( $image->slider_active ) :
								case '1' :
									echo 'Yes';
									break;
								case '0' :
								default :
									echo 'No';
									break;	
							endswitch;
							?>									
						</td>
						<td><button class="button-primary edit-slider" id="edit-slider-<?php echo $image->id; ?>">Edit</div>																							
					</tr>
					<tr>
						<td colspan="6" style="display:none; background: #fff" id="slider-form-<?php echo $image->id; ?>">
							<form action="" method="post">
								<table class="form-table">
									<tr valign="top">
										<th scope="row"><label for="_slider_title">Slider Title</label></th>
										<td><input name="_slider_title" type="text" id="_slider_title" value="<?php echo $image->slider_title; ?>" class="regular-text"></td>
									</tr>
									<tr valign="top">
										<th scope="row"><label for="_slider_description">Slider Description</label></th>
										<td><textarea style="width: 400px; height: 100px;" name="_slider_description" id="_slider_description" class="regular-text"><?php echo $image->slider_description; ?></textarea></td>
									</tr>
									<tr valign="top">
										<th scope="row"><label for="_slider_link">Slider Link</label></th>
										<td>
											<input name="_slider_link" type="text" id="_slider_link" value="<?php echo $image->slider_link; ?>" class="regular-text">
											<p class="description">Where do you want the site visitor to go when clicking image?</p>
										</td>
									</tr>
									<tr valign="top">
										<th scope="row"><label for="_slider_image">Slider Image</label></th>
										<td>
											<input name="_slider_image" type="text" id="_slider_image" value="<?php echo $image->slider_image; ?>" class="regular-text">
											<p class="description">Upload the image to the <a href="/wp-admin/upload.php">media library</a> and then paste in the url here. (size: 710w x 300h)</p>							
										</td>
									</tr>																											
										<tr valign="top">
											<?php
											$checked = '';
											if ( $image->slider_active == 1 ) :
												$checked = ' checked="checked"';
											endif;
											?>											
											<th scope="row"><label for="_slider_active">Make Active?</label></th>
											<td><input name="_slider_active" type="checkbox" id="_slider_active" value="1" class="regular-text"<?php echo $checked; ?>></td>
										</tr>																				
									</table>
									<?php wp_nonce_field( 'ucs-edit-slider-settings' ); ?>	
									<input type="hidden" name="_slider_id" value="<?php echo $image->id; ?>">			
									<p class="submit"><input type="submit" name="update" id="update-<?php echo $image->ID; ?>" class="button-primary" value="Update Slider Image"></p>
							</td>								
						</form>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>

			<?php
			$images = $this->UCSGetSliderImages( 'inactive' ); 
			if ( $images ) :
			?>	
			<h3>In-Active Slider Images</h3>
			<table class="widefat">
				<thead>
					<tr>
						<th>Title</th>
						<th>Description</th>
						<th>Link</th>
						<th>Image</th>
						<th>Active</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php
					foreach ( $images as $image ) :
					?>
					<tr>
						<td><?php echo $image->slider_title; ?></td>
						<td><?php echo $image->slider_description; ?></td>
						<td><?php echo $image->slider_link; ?></td>
						<td><img src="<?php echo $image->slider_image; ?>" width="200"></td>
						<td>
							<?php
							switch( $image->slider_active ) :
								case '1' :
									echo 'Yes';
									break;
								case '0' :
								default :
									echo 'No';
									break;	
							endswitch;
							?>									
						</td>
						<td><button class="button-primary edit-slider" id="edit-slider-<?php echo $image->id; ?>">Edit</div>																							
					</tr>
					<tr>
						<td colspan="6" style="display:none; background: #fff" id="slider-form-<?php echo $image->id; ?>">
							<form action="" method="post">
								<table class="form-table">
									<tr valign="top">
										<th scope="row"><label for="_slider_title">Slider Title</label></th>
										<td><input name="_slider_title" type="text" id="_slider_title" value="<?php echo $image->slider_title; ?>" class="regular-text"></td>
									</tr>
									<tr valign="top">
										<th scope="row"><label for="_slider_description">Slider Description</label></th>
										<td><textarea style="width: 400px; height: 100px;" name="_slider_description" id="_slider_description" class="regular-text"><?php echo $image->slider_description; ?></textarea></td>
									</tr>
									<tr valign="top">
										<th scope="row"><label for="_slider_link">Slider Link</label></th>
										<td>
											<input name="_slider_link" type="text" id="_slider_link" value="<?php echo $image->slider_link; ?>" class="regular-text">
											<p class="description">Where do you want the site visitor to go when clicking image?</p>
										</td>
									</tr>
									<tr valign="top">
										<th scope="row"><label for="_slider_image">Slider Image</label></th>
										<td>
											<input name="_slider_image" type="text" id="_slider_image" value="<?php echo $image->slider_image; ?>" class="regular-text">
											<p class="description">Upload the image to the <a href="/wp-admin/upload.php">media library</a> and then paste in the url here.</p>							
										</td>
									</tr>																											
										<tr valign="top">
											<?php
											$checked = '';
											if ( $image->slider_active == 1 ) :
												$checked = ' checked="checked"';
											endif;
											?>											
											<th scope="row"><label for="_slider_active">Make Active?</label></th>
											<td><input name="_slider_active" type="checkbox" id="_slider_active" value="1" class="regular-text"<?php echo $checked; ?>></td>
										</tr>																				
									</table>
									<?php wp_nonce_field( 'ucs-edit-slider-settings' ); ?>	
									<input type="hidden" name="_slider_id" value="<?php echo $image->id; ?>">			
									<p class="submit"><input type="submit" name="update" id="update-<?php echo $image->ID; ?>" class="button-primary" value="Update Slider Image"></p>
							</td>								
						</form>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
			<?php endif; ?>		
		</div>
		<?php
		
	}
	
	public function UCSGetSliderImages( $active = 'active' ) {
		
		global $wpdb;

		$q  = "SELECT * ";
		$q .= "FROM {$wpdb->prefix}ucs_slider ";
		
		switch ( $active ) :
			case 'active' :
				$q .= "WHERE slider_active = 1 ";			
				break;
			case 'inactive' :
				$q .= "WHERE slider_active = 0 ";			
				break;				
			case 'all' :	
				$q .= "WHERE slider_active IN (1,0) ";							
				break;
		endswitch;
		
		$results = $wpdb->get_results( $q );
		return $results;
		
	}
	
}
?>