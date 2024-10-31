<?php return ( function() { $map = require __DIR__ . '/classmap.php';
    return spl_autoload_register( function( $class ) use( $map ) { return ! ( $map[ $class ] ?? null ) ?: require __DIR__ . $map[ $class ]; } );
} )(); # This file is part of https://github.com/PiotrPress/composer-classmapper package.