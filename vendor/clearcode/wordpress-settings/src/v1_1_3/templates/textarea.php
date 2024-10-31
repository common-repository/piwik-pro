<?php defined( 'ABSPATH' ) or exit; ?>
<label>
    <?php if ( ! empty( $before ) ) : ?><?= $before ?><?php endif; ?>
    <textarea id="<?= $id ?>" name="<?= $name ?>" <?php if ( ! empty ( $atts ) ) foreach ( $atts as $key => $value ) echo is_int( $key ) ? $value : sprintf( '%s="%s"', $key, $value ); ?>><?php if ( ! empty( $value ) ) : ?><?= $value ?><?php endif; ?></textarea>
    <?php if ( ! empty( $after ) ) : ?><?= $after ?><?php endif; ?>
</label>
<?php if ( ! empty( $description ) ) : ?>
    <p class="description">
        <?= $description ?>
    </p>
<?php endif; ?>