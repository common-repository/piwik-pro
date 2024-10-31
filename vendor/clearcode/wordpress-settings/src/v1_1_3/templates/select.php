<?php defined( 'ABSPATH' ) or exit; ?>
<label <?php if ( ! empty( $label_for ) ) : ?>for="<?= $label_for ?>"<?php endif; ?>>
    <?php if ( ! empty( $before ) ) : ?><?= $before ?><?php endif; ?>
    <select id="<?= $id ?>" name="<?= $name ?><?php if ( ! empty( $atts[ 'multiple' ] ) or is_int( array_search( 'multiple', $atts ?? [] ) ) ) echo '[]'; ?>" <?php if ( ! empty ( $atts ) ) foreach ( $atts as $key => $attr ) echo is_int( $key ) ? $attr : sprintf( '%s="%s"', $key, $attr ); ?>>
    <?php if ( ! empty( $options ) ) foreach( $options as $option => $name ) : ?>
        <option value="<?= $option ?>" <?php if ( is_array( $value ) and in_array( $option, $value ) ) selected( true ); elseif( ! is_array( $value ) ) selected( $option, $value ); ?>><?= $name ?></option>
    <?php endforeach; ?>
    </select>
    <?php if ( ! empty( $after ) ) : ?><?= $after ?><?php endif; ?>
</label>
<?php if ( ! empty( $description ) ) : ?>
    <p class="description">
        <?= $description ?>
    </p>
<?php endif; ?>