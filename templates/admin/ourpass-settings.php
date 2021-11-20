<?php
/**
 * Fast admin settings page template.
 *
 * @package Fast
 */

$ourpasswc_tabs       = ourpasswc_get_settings_tabs();
$ourpasswc_active_tab = ourpasswc_get_active_tab();

?>
<div class="wrap ourpass-settings">
	<h2><?php esc_html_e( 'OurPass Settings', ); ?></h2>

	<?php
	// Load the tabs nav.
	ourpasswc_load_template( 'admin/ourpass-tabs-nav' );

	// Load the tab content for the active tab.
	$valid_tab_contents   = array_keys( $ourpasswc_tabs );

	if ( ! in_array( $ourpasswc_active_tab, $valid_tab_contents, true ) ) {
		$ourpasswc_active_tab = 'ourpass_app_info';
	}

	$ourpasswc_tab_template = 'admin/tabs/' . str_replace( '_', '-', $ourpasswc_active_tab );

	ourpasswc_load_template( $ourpasswc_tab_template );

	// Load the OurPass settings footer.
	ourpasswc_load_template( 'admin/ourpass-settings-footer' );
	?>
</div>
