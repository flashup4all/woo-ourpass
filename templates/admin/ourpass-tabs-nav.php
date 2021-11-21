<?php
/**
 * OurPass admin settings page nav template.
 *
 * @package OurPass
 */

$ourpasswc_tabs       = ourpasswc_get_settings_tabs();
$ourpasswc_active_tab = ourpasswc_get_active_tab();

?>

<nav class="nav-tab-wrapper">
	<?php
	foreach ( $ourpasswc_tabs as $tab_name => $tab_label ) :
		$tab_url   = sprintf( 'admin.php?page=ourpass&tab=%s', $tab_name );
		$tab_class = array( 'nav-tab' );
		if ( $ourpasswc_active_tab === $tab_name ) {
			$tab_class[] = 'nav-tab-active';
		}
		$tab_class = implode( ' ', $tab_class );
		?>
	<a href="<?php echo esc_url( $tab_url ); ?>" class="<?php echo esc_attr( $tab_class ); ?>"><?php echo esc_html( $tab_label ); ?></a>
	<?php endforeach; ?>
</nav>
