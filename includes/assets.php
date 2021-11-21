<?php

/**
 * Loads ourpass-woocommerce.js in footer.
 *
 * @package OurPass
 */

/**
 * Enqueue the OurPass Woocommerce script.
 */
function ourpasswc_enqueue_script()
{
	wp_enqueue_script(
		'ourpass-cdn',
		OURPASSWC_URL . 'assets/js/cdn.js',
		array('jquery'),
		OURPASSWC_VERSION,
		true
	);

	wp_enqueue_script(
		'ourpass-woocommerce',
		OURPASSWC_URL . 'assets/js/scripts-wp.js',
		array('jquery', 'ourpass-cdn'),
		OURPASSWC_VERSION,
		true
	);
}
add_action('wp_enqueue_scripts', 'ourpasswc_enqueue_script');


/**
 * Enqueue admin assets.
 */
function ourpasswc_admin_enqueue_scripts()
{
	/**
	 * Load the Select2 library.
	 *
	 * @version 4.0.13
	 *
	 * @see https://select2.org/.
	 */
	$select2_version = '4.0.13';
	wp_enqueue_script(
		'select2',
		OURPASSWC_URL . 'assets/vendor/select2/select2.min.js',
		array('jquery'),
		$select2_version,
		true
	);
	wp_enqueue_style(
		'select2',
		OURPASSWC_URL . 'assets/vendor/select2/select2.min.css',
		array(),
		$select2_version
	);

	wp_enqueue_script(
		'ourpasswc-admin-js',
		OURPASSWC_URL . 'assets/js/scripts-wp-admin.min.js',
		array('jquery', 'select2'),
		OURPASSWC_VERSION,
		true
	);

	$current_screen = get_current_screen();

	if (!empty($current_screen) && isset($current_screen->id) && 'toplevel_page_ourpass' !== $current_screen->id) {
		return;
	}
	wp_enqueue_style(
		'ourpass-admin-css',
		OURPASSWC_URL . 'assets/css/styles.css',
		array(),
		OURPASSWC_VERSION
	);
}
add_action('admin_enqueue_scripts', 'ourpasswc_admin_enqueue_scripts');

/**
 * Load the styles in the head.
 */
function ourpasswc_wp_head()
{
	$ourpasswc_load_button_styles = get_option(OURPASSWC_SETTING_LOAD_BUTTON_STYLES, true);

	if (empty($ourpasswc_load_button_styles)) {
		return;
	}

	$button_styles = ourpasswc_get_button_styles();

	if (empty($button_styles)) {
		return;
	}
?>
	<style>
		<?php echo esc_html($button_styles); ?>
	</style>
<?php
}
add_action('wp_head', 'ourpasswc_wp_head');

/**
 * Enqueue block editor assets for the Gutenberg blocks.
 */
// function ourpasswc_enqueue_block_editor_assets() {

// 	// Enqueue the script.
// 	wp_enqueue_script(
// 		'ourpasswc-block-editor-js',
// 		OURPASSWC_URL . 'assets/dist/blocks/index.js',
// 		array( 'wp-blocks', 'wp-i18n', 'wp-components', 'wp-element' ),
// 		OURPASSWC_VERSION,
// 		true
// 	);

// 	// Enqueue the stylesheet.
// 	wp_enqueue_style(
// 		'ourpasswc-block-editor-css',
// 		OURPASSWC_URL . 'assets/dist/blocks/index.css',
// 		array(),
// 		OURPASSWC_VERSION
// 	);
// }
// add_action( 'enqueue_block_editor_assets', 'ourpasswc_enqueue_block_editor_assets' );
