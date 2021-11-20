<?php

/**
 * Input field class.
 */
class OurPass_Form_Input extends OurPass_Form_Field {

	/**
	 * Get the default args for the field type.
	 *
	 * @return array
	 */
	protected function get_default_args() {
		return array(
			'name'        => '',
			'id'          => '',
			'type'        => 'text',
			'class'       => 'input-field',
			'value'       => '',
			'description' => '',
		);
	}

	/**
	 * Render the field.
	 */
	protected function render() {
		?>
		<input
			name="<?php echo \esc_attr( $this->args['name'] ); ?>"
			id="<?php echo \esc_attr( $this->args['id'] ); ?>"
			type="<?php echo \esc_attr( $this->args['type'] ); ?>"
			class="<?php echo \esc_attr( $this->args['class'] ); ?>"
			value="<?php echo \esc_attr( $this->args['value'] ); ?>"
		/>
		<?php
	}
}
