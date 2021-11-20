<?php

// Load base field class.
require_once OURPASSWC_PATH . 'includes/admin/fields/class-field.php';
// Load input field class.
require_once OURPASSWC_PATH . 'includes/admin/fields/class-input.php';
// Load textarea field class.
require_once OURPASSWC_PATH . 'includes/admin/fields/class-textarea.php';
// Load checkbox field class.
require_once OURPASSWC_PATH . 'includes/admin/fields/class-checkbox.php';
// Load select field class.
require_once OURPASSWC_PATH . 'includes/admin/fields/class-select.php';
// Load image select field class.
require_once OURPASSWC_PATH . 'includes/admin/fields/class-image-select.php';
// Load ajax select field class.
require_once OURPASSWC_PATH . 'includes/admin/fields/class-ajax-select.php';

/**
 * Standard text input field.
 *
 * @param array $args Attribute args for the field.
 *
 * @return OurPass_Form_Input
 */
function ourpasswc_settings_field_input( $args ) {
	return new OurPass_Form_Input( $args );
}

/**
 * Standard textarea field.
 *
 * @param array $args Attribute args for the field.
 *
 * @return OurPass_Form_Textarea
 */
function ourpasswc_settings_field_textarea( $args ) {
	return new OurPass_Form_Textarea( $args );
}

/**
 * Standard checkbox input field.
 *
 * @param array $args Attribute args for the field.
 *
 * @return OurPass_Form_Checkbox
 */
function ourpasswc_settings_field_checkbox( $args ) {
	return new OurPass_Form_Checkbox( $args );
}

/**
 * Regular select settings field.
 *
 * @param array $args Attribute args for the field.
 *
 * @return OurPass_Form_Select
 */
function ourpasswc_settings_field_select( $args ) {
	return new OurPass_Form_Select( $args );
}

/**
 * Image select settings field.
 *
 * @param array $args Attribute args for the field.
 *
 * @return OurPass_Form_Image_Select
 */
function ourpasswc_settings_field_image_select( $args ) {
	return new OurPass_Form_Image_Select( $args );
}


/**
 * Ajax select settings field.
 *
 * @param array $args Attribute args for the field.
 *
 * @return OurPass_Form_Ajax_Select
 */
function ourpasswc_settings_field_ajax_select( $args ) {
	return new OurPass_Form_Ajax_Select( $args );
}
