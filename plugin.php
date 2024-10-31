<?php

/**
 * Plugin Name:       Piwik PRO
 * Plugin URI:        https://wordpress.org/plugins/piwik-pro/
 * Description:       Adds the Piwik PRO container (with tracking code) to your WordPress site.
 * Version:           1.3.6
 * Requires at least: 5.7
 * Requires PHP:      7.4
 * Author:            Piwik PRO
 * Author URI:        https://piwik.pro/
 * License:           GPLv3
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain:       piwik-pro
 * Domain Path:       /languages/

   Copyright (C) since 2021 by Piwik PRO <https://piwik.pro>
   and associates (see AUTHORS.txt file).

   This file is part of Piwik PRO plugin.

   Piwik PRO plugin is free software; you can redistribute it and/or modify
   it under the terms of the GNU General Public License as published by
   the Free Software Foundation; either version 3 of the License, or
   (at your option) any later version.

   Piwik PRO plugin is distributed in the hope that it will be useful,
   but WITHOUT ANY WARRANTY; without even the implied warranty of
   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
   GNU General Public License for more details.

   You should have received a copy of the GNU General Public License
   along with Piwik PRO plugin; if not, write to the Free Software
   Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

defined( 'ABSPATH' ) or exit;

require __DIR__ . '/autoload.php';

try {
	PiwikPRO\Plugin::instance( __FILE__ );
} catch ( Exception $exception ) {
	if ( WP_DEBUG && WP_DEBUG_DISPLAY ) echo $exception->getMessage();
	if ( WP_DEBUG && WP_DEBUG_LOG ) error_log( $exception->getMessage() );
}