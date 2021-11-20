<?php

/**
 * Image Select field class.
 */
class OurPass_Form_Image_Select extends OurPass_Form_Select {

	/**
	 * Render the field, description, and timestamp.
	 */
	protected function do_render() {
		$this->maybe_render_description();
		$this->maybe_render_timestamp();
		$this->render();
	}

	/**
	 * Render the field.
	 */
	protected function render() {
		?>
		<div class="ourpass-image-select" id="ourpass-image-select-<?php echo \esc_attr( $this->args['name'] ); ?>">
		<?php
		$index = 0;
		foreach ( $this->args['options'] as $value => $option ) :
			$label = ! empty( $option['label'] ) ? $option['label'] : '';
			$image = ! empty( $option['image'] ) ? $option['image'] : '';
			$id    = $this->args['name'] . '-' . $index;
			$index++;
			?>
			<div class="ourpass-image-select--item">
				<input
					type="radio"
					name="<?php echo \esc_attr( $this->args['name'] ); ?>"
					id="<?php echo \esc_attr( $id ); ?>"
					class="ourpass-image-select--input screen-reader-text"
					value="<?php echo \esc_attr( $value ); ?>"
					<?php \checked( $this->args['value'], $value ); ?>
				/>
				<label
					for="<?php echo \esc_attr( $id ); ?>"
					class="ourpass-image-select--label"
					aria-label="<?php echo \esc_attr( $label ); ?>"
				>
					<span class="ourpass-image-select--label-text"><?php echo \esc_html( $label ); ?></span>
					<?php if ( ! empty( $image ) ) : ?>
					<img src="<?php echo \esc_url( $image ); ?>" class="ourpass-image-select--image" alt="<?php echo \esc_attr( $label ); ?>" />
					<?php endif; ?>
				</label>
			</div>
				<?php
		endforeach;
		?>
		</div>
		<?php
	}
}
