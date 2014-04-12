<?php
add_action( 'admin_init', 'theme_options_init' );
add_action( 'admin_menu', 'theme_options_add_page' );

/**
 * Init plugin options to white list our options
 */
function theme_options_init(){
	register_setting( 'skin_options', 'skin_theme_options', 'theme_options_validate' );

add_action( 'admin_enqueue_scripts', 'mw_enqueue_color_picker' );
function mw_enqueue_color_picker( $hook_suffix ) {
    // first check that $hook_suffix is appropriate for your admin page
    wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_script( 'theme-options-scripts', get_stylesheet_directory_uri() . '/library/js/admin-scripts.js', array( 'wp-color-picker' ), false, true );
    wp_enqueue_style( 'theme-options-styles', get_stylesheet_directory_uri() . '/library/css/admin.css', array(), '', 'all' );
	wp_enqueue_media();
}

}

/**
 * Load up the menu page
 */
function theme_options_add_page() {
	add_theme_page( __( 'Theme Options', 'skin' ), __( 'Theme Options', 'skin' ), 'edit_theme_options', 'theme_options', 'theme_options_do_page' );
}

function theme_options_tabs( $current = 'general' ) {
    $tabs = array( 'general' => 'General','footer' => 'Footer', 'products' => 'Product Options', 'credits' => 'User Credits', 'payment' => 'Payment Gateway' );
    echo '<div id="icon-themes" class="icon32"><br></div>';
    echo '<h2 class="nav-tab-wrapper theme-option-tabs">';
    foreach( $tabs as $tab => $name ){
        $class = ( $tab == $current ) ? ' nav-tab-active' : '';
        echo "<a class='nav-tab$class' href='#$tab'>$name</a>";
    }
    echo '</h2>';
}


/**
 * Create the options page
 */
function theme_options_do_page() {
	global $select_options, $radio_options;

	if ( ! isset( $_REQUEST['settings-updated'] ) )
		$_REQUEST['settings-updated'] = false;

	?>
	<div class="wrap">
		<?php echo "<h2>" . get_current_theme() . __( ' Theme Options', 'skin' ) . "</h2>"; ?>

		<?php if ( false !== $_REQUEST['settings-updated'] ) : ?>
		<div class="updated fade theme-options-updated"><p><strong><?php _e( 'Options saved', 'skin' ); ?></strong></p></div>
		<?php endif; ?>
		<?php theme_options_tabs('general'); ?>
		<form method="post" action="options.php">
			<?php settings_fields( 'skin_options' ); ?>
			<?php $options = get_option( 'skin_theme_options' ); ?>

			<table id="general-tab" class="form-table current theme-options-tabs">

				<tr valign="top" >
					<th scope="row"><?php _e( 'Logo', 'skin' ); ?></th>
					<td>
						<input id="skin_theme_options_logo" class="regular-text" type="text" name="skin_theme_options[logo]" value="<?php esc_attr_e( $options['logo'] ); ?>" /><input id="button_skin_theme_options_logo" class="meta_upload" name="button_skin_theme_options[logo]" type="button" value="Upload" style="width: auto;" />
					<label class="description" for="skin_theme_options_logo"><?php _e( 'Insert website logo', 'skin' ); ?></label>
					<?php if($options['logo'] ) { ?><br /> <img src="<?php echo $options['logo']; ?>" style="max-width: 200px" /><?php } ?>
					</td>
				</tr>

			
				<tr valign="top"><th scope="row"><?php _e( 'Background Color', 'skin' ); ?></th>
					<td>
						<input id="skin_theme_options_bgcolor" class="regular-text colorpicker-field" type="text" name="skin_theme_options[bgcolor]" value="<?php esc_attr_e( $options['bgcolor'] ); ?>" />
					<label class="description" for="skin_theme_options_bgcolor"><?php _e( 'Website Backgrouund Color scheme', 'skin' ); ?></label>
					</td>
				</tr>
				
				<tr valign="top"><th scope="row"><?php _e( 'Foreground Color', 'skin' ); ?></th>
					<td>
						<input id="skin_theme_options_fgcolor" class="regular-text colorpicker-field" type="text" name="skin_theme_options[fgcolor]" value="<?php esc_attr_e( $options['fgcolor'] ); ?>" />
					<label class="description" for="skin_theme_options_fgcolor"><?php _e( 'Website Foreground Color Scheme', 'skin' ); ?></label>
					</td>
				</tr>
				
				<tr valign="top"><th scope="row"><?php _e( 'Text Color', 'skin' ); ?></th>
					<td>
						<input id="skin_theme_options_txcolor" class="regular-text colorpicker-field" type="text" name="skin_theme_options[txcolor]" value="<?php esc_attr_e( $options['txcolor'] ); ?>" />
					<label class="description" for="skin_theme_options_txcolor"><?php _e( 'Website Text Color scheme', 'skin' ); ?></label>
					</td>
				</tr>

				<tr valign="top"><th scope="row"><?php _e( 'Phone Number', 'skin' ); ?></th>
					<td>
						<input id="skin_theme_options_phone_number" class="regular-text" type="text" name="skin_theme_options[phone_number]" value="<?php esc_attr_e( $options['phone_number'] ); ?>" />
					<label class="description" for="skin_theme_options_phone_number"><?php _e( 'Insert Phone Number', 'skin' ); ?></label>
					</td>
				</tr>
				<tr valign="top"><th scope="row"><?php _e( 'Email Adress', 'skin' ); ?></th>
					<td>
						<input id="skin_theme_options_email" class="regular-text" type="text" name="skin_theme_options[email]" value="<?php esc_attr_e( $options['email'] ); ?>" />
					<label class="description" for="skin_theme_options_email"><?php _e( 'Insert Email Address', 'skin' ); ?></label>
					</td>
				</tr>
			</table>
			
			<table id="footer-tab" class="form-table theme-options-tabs">
				
				<tr valign="top"><th scope="row"><?php _e( 'Copyright', 'skin' ); ?></th>
					<td>
						<input id="skin_theme_options_copyright" class="regular-text" type="text" name="skin_theme_options[copyright]" value="<?php esc_attr_e( $options['copyright'] ); ?>" />
					<label class="description" for="skin_theme_options_copyright"><?php _e( 'Copyright text', 'skin' ); ?></label>
					</td>
				</tr>

			
			</table>
			
			<table id="products-tab" class="form-table theme-options-tabs">
				
				<tr valign="top"><th scope="row"><?php _e( 'Default product bidding fee', 'skin' ); ?></th>
					<td>
						<input id="skin_theme_options_numcredits" class="regular-text" type="text" name="skin_theme_options[numcredits]" value="<?php esc_attr_e( $options['numcredits'] ); ?>" />
					<label class="description" for="skin_theme_options_numcredits"><?php _e( 'Number of credits', 'skin' ); ?></label>
					</td>
				</tr>
				
			</table>
			
			<table id="credits-tab" class="form-table theme-options-tabs">
				
				<tr valign="top"><th scope="row"><?php _e( '50 Credits', 'skin' ); ?></th>
					<td>
						<input id="skin_theme_options_tup50" class="regular-text" type="text" name="skin_theme_options[tup50]" value="<?php esc_attr_e( $options['tup50'] ); ?>" />
					<label class="description" for="skin_theme_options_tup50"><?php _e( 'Euros', 'skin' ); ?></label>
					</td>
				</tr>
				
				<tr valign="top"><th scope="row"><?php _e( '100 Credits', 'skin' ); ?></th>
					<td>
						<input id="skin_theme_options_tup100" class="regular-text" type="text" name="skin_theme_options[tup100]" value="<?php esc_attr_e( $options['tup100'] ); ?>" />
					<label class="description" for="skin_theme_options_tup100"><?php _e( 'Euros', 'skin' ); ?></label>
					</td>
				</tr>
				
				<tr valign="top"><th scope="row"><?php _e( '150 Credits', 'skin' ); ?></th>
					<td>
						<input id="skin_theme_options_tup150" class="regular-text" type="text" name="skin_theme_options[tup150]" value="<?php esc_attr_e( $options['tup150'] ); ?>" />
					<label class="description" for="skin_theme_options_tup150"><?php _e( 'Euros', 'skin' ); ?></label>
					</td>
				</tr>

			
			</table>
			
			<table id="payment-tab" class="form-table theme-options-tabs">
				<tr valign="top"><th scope="row"><?php _e( 'Paypal User Name', 'skin' ); ?></th>
					<td>
						<input id="skin_theme_options_apiuname" class="regular-text" type="text" name="skin_theme_options[apiuname]" value="<?php esc_attr_e( $options['apiuname'] ); ?>" />
					<label class="description" for="skin_theme_options_apiuname"><?php _e( 'Enter Paypal API User Name', 'skin' ); ?></label>
					</td>
				</tr>
				<tr valign="top"><th scope="row"><?php _e( 'Paypal Password', 'skin' ); ?></th>
					<td>
						<input id="skin_theme_options_apiupwd" class="regular-text" type="text" name="skin_theme_options[apiupwd]" value="<?php esc_attr_e( $options['apiupwd'] ); ?>" />
					<label class="description" for="skin_theme_options_apiupwd"><?php _e( 'Enter Paypal API password', 'skin' ); ?></label>
					</td>
				</tr>
				<tr valign="top"><th scope="row"><?php _e( 'Paypal Signature', 'skin' ); ?></th>
					<td>
						<input id="skin_theme_options_apisignature" class="regular-text" type="text" name="skin_theme_options[apisignature]" value="<?php esc_attr_e( $options['apisignature'] ); ?>" />
					<label class="description" for="skin_theme_options_apisignature"><?php _e( 'Enter Paypal API Signature', 'skin' ); ?></label>
					</td>
				</tr>
				<tr valign="top"><th scope="row"><?php _e( 'Paypal Environment', 'skin' ); ?></th>
					<td>
						<select id="skin_theme_options_paypalenv" name="skin_theme_options[paypalenv]">
							<option value="">Select..</option>
							<option value="sandbox" <?php if( $options['paypalenv'] == "sandbox") { echo 'selected="selected"';} ?>>Test</option>
							<option value="live" <?php if( $options['paypalenv'] == "live") { echo 'selected="selected"';} ?>>Live</option>
						</select>
					<label class="description" for="skin_theme_options_paypalenv"><?php _e( 'Select Paypal Environment', 'skin' ); ?></label>
					</td>
				</tr>
			
			</table>

			<p class="submit">
				<input type="submit" class="button-primary" value="<?php _e( 'Save Options', 'skin' ); ?>" />
			</p>
		</form>
	</div>
	<?php
}

/**
 * Sanitize and validate input. Accepts an array, return a sanitized array.
 */
function theme_options_validate( $input ) {
	global $select_options, $radio_options;

	// Our checkbox value is either 0 or 1
	if ( ! isset( $input['option1'] ) )

	// Say our text option must be safe text with no HTML tags
	$input['logo_type'] = wp_filter_nohtml_kses( $input['logo_type'] );
	$input['logo'] = wp_filter_nohtml_kses( $input['logo'] );
	$input['twitter'] = wp_filter_nohtml_kses( $input['twitter'] );
	$input['facebook'] = wp_filter_nohtml_kses( $input['facebook'] );
	$input['google'] = wp_filter_nohtml_kses( $input['google'] );
	$input['footer'] = $input['footer'];
	$input['copyright'] = $input['copyright'];
	$input['numcredits'] = wp_filter_nohtml_kses( $input['numcredits'] );
	$input['tup50'] = wp_filter_nohtml_kses( $input['tup50'] );
	$input['tup100'] = wp_filter_nohtml_kses( $input['tup100'] );
	$input['tup150'] = wp_filter_nohtml_kses( $input['tup150'] );

	// Say our textarea option must be safe text with the allowed tags for posts
	//$input['textarea'] = wp_filter_post_kses( $input['textarea'] );

	return $input;
}

