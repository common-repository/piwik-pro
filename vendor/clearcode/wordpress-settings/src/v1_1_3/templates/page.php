<?php defined( 'ABSPATH' ) or exit; ?>
<div class="wrap">
	<form method="post" action="options.php<?php if ( ! empty( $tab ) ) : ?>?tab=<?= $tab ?><?php endif ?>">
        <?php if ( ! empty( $tab ) and ! empty( $tabs ) ) : ?>
            <h1 class="wp-heading-inline"><?= $header ?></h1>
            <h2 class="nav-tab-wrapper">
                <?php foreach( $tabs as $key => $value ) : ?>
                    <a href="<?= add_query_arg( 'tab', $key, $url ) ?>" class="nav-tab<?= $key === $tab ? ' nav-tab-active' : ''; ?>"><?= $value; ?></a>
                <?php endforeach; ?>
            </h2>
        <?php else : ?>
            <h1><?= $header ?></h1>
        <?php endif; ?>
		<?php
            settings_errors( $option_name );
            settings_fields( $option_group );
            do_settings_sections( $page );
            submit_button();
		?>
	</form>
</div>