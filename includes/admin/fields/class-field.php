<?php

/**
 * Base field class.
 */
abstract class OurPass_Form_Field {

	/**
	 * Field args.
	 *
	 * @var array
	 */
	protected $args = array();

	/**
	 * Field constructor.
	 *
	 * @param array $args The args that define the field.
	 */
	public function __construct( $args ) {
		$this->set_field_args( $args );

		// First make sure all required args are present.
		if ( ! $this->should_do_render() ) {
			return;
		}

		$this->do_render();
	}

	/**
	 * Validate the args before rendering.
	 *
	 * @return bool
	 */
	protected function should_do_render() {
		if ( empty( $this->args['name'] ) ) {
			return false;
		}

		return true;
	}

	/**
	 * Render the field, description, and timestamp.
	 */
	protected function do_render() {
		$this->render();
		$this->maybe_render_description();
		$this->maybe_render_timestamp();
	}

	/**
	 * Get the default args for the field type.
	 *
	 * @return array
	 */
	protected function get_default_args() {
		return array();
	}

	/**
	 * Set the field args.
	 *
	 * @param array $args The args passed into the field.
	 */
	protected function set_field_args( $args ) {
		$defaults = array(
			'name' => '',
			'id'   => '',
		);

		$default_args = wp_parse_args( $this->get_default_args(), $defaults );

		$args = wp_parse_args( $args, $default_args );

		// If the id is empty, set it equal to the name field.
		if ( empty( $args['id'] ) ) {
			$args['id'] = $args['name'];
		}

		// Set the class $args variable.
		$this->args = $args;
	}

	/**
	 * Render the field.
	 */
	abstract protected function render();

	/**
	 * Maybe render the field description.
	 */
	protected function maybe_render_description() {
		if ( empty( $this->args['description'] ) ) {
			return;
		}
		?>
		<p class="description"><?php echo \wp_kses_post( $this->args['description'] ); ?></p>
		<?php
	}

	/**
	 * Maybe render a last updated timestamp.
	 */
	protected function maybe_render_timestamp() {
		// Check for timestamp and render if available.
		$ourpass_timestamps = \get_option( OURPASSWC_SETTINGS_TIMESTAMPS, array() );

		if ( empty( $ourpass_timestamps ) || empty( $ourpass_timestamps[ $this->args['name'] ] ) ) {
			return;
		}

		$timestamp           = $ourpass_timestamps[ $this->args['name'] ];
		$formatted_timestamp = sprintf(
			/* translators: 1: Last modified date, 2: Last modified time. */
			__( '%1$s at %2$s' ),
			/* translators: Last modified date format. See https://www.php.net/manual/datetime.format.php */
			date( __( 'Y/m/d' ), $timestamp ),
			/* translators: Last modified time format. See https://www.php.net/manual/datetime.format.php */
			date( __( 'g:i a' ), $timestamp )
		);
		?>
		<p class="description ourpass-setting-timestamp"><small><em><?php esc_html_e( 'Last updated'); ?>: <?php echo esc_html( $formatted_timestamp ); ?></em></small></p>
		<?php
	}
}
