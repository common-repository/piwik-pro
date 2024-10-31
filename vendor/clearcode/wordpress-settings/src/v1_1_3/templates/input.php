<?php defined( 'ABSPATH' ) or exit; ?>
<label>
    <?php if ( ! empty( $before ) ) : ?><?= $before ?><?php endif; ?>
    <input id="<?= $id ?>" name="<?= $name ?>" value="<?= $value ?>"<?php if ( ! empty ( $atts ) ) foreach ( $atts as $key => $value ) echo is_int( $key ) ? $value : sprintf( ' %s="%s"', $key, $value ); ?>/>
    <?php if ( ! empty( $after ) ) : ?><?= $after ?><?php endif; ?>
</label>
<?php if ( ! empty( $description ) ) : ?>
    <p class="description">
        <?= $description ?>
    </p>
<?php endif; ?>