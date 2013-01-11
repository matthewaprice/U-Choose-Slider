<?php
class UCS_Base {
	
	public function __construct() {
		
		add_action( 'admin_menu', array( &$this, 'UCSMenuSetup' ) );
		$this->slider_settings = new UCS_Slider();
						
	}
	
	public function UCSPluginActivation() {
	
		global $wpdb;
		
		$ucs_table_name = $wpdb->prefix . "ucs_slider";
		$sql  = "CREATE TABLE IF NOT EXISTS $ucs_table_name ";
		$sql .= "( ";
		$sql .= "id int(11) NOT NULL AUTO_INCREMENT primary key, ";
		$sql .= "slider_title VARCHAR(128) DEFAULT '' NOT NULL, ";
		$sql .= "slider_image VARCHAR(128) DEFAULT '' NOT NULL, ";
		$sql .= "slider_description VARCHAR(250) DEFAULT '' NOT NULL, ";
		$sql .= "slider_link VARCHAR(128) DEFAULT '' NOT NULL, ";	
		$sql .= "slider_active TINYINT(1) DEFAULT 1 NOT NULL ";
		$sql .= ");";
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
		add_option( "ucs_slider_db_version", "1.0" );					
		
	}
	
	public function UCSMenuSetup() {
		
		add_menu_page( 'U Choose Slider', 'U Choose Slider', 'manage_options', 'ucs-slider', array( &$this, 'UCSGetSliderSettings' ) );
		
		global $submenu;
		if ( isset($submenu['ucs-slider']) )
			$submenu['ucs-homepage'][0][0] = __( 'Slider', 'ucs-slider' );		
		
	}
	
	public function UCSGetSliderSettings() {
		
		$this->slider_settings->UCSSliderSettings();
		
	}
	
}
?>