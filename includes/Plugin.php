<?php

/*
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

namespace PiwikPRO;

use PiwikPRO\Vendor\Clearcode\Framework\v6_1_3\Templater;

defined( 'ABSPATH' ) or exit;

if ( ! class_exists( __NAMESPACE__ . '\Plugin' ) ) {
	class Plugin extends \PiwikPRO\Vendor\Clearcode\Framework\v6_1_3\Plugin {
	    protected $settings = [];
	    protected $defaults = [
            'url' => '',
            'id' => '',
            'layer' => 'dataLayer',
            'sync' => false,
            'async' => true,
            'woocommerce' => true
        ];

	    public function activation() {
            add_option( Settings::OPTION, $this->defaults );
        }

        public function deactivation() {}

        public function action_init() {
            if ( false === get_option( Settings::OPTION ) ) $this->activation();
            if ( array_keys( get_option( Settings::OPTION ) ) !== array_keys( $this->defaults ) )
                update_option( Settings::OPTION, array_merge( $this->defaults, get_option( Settings::OPTION ) ) );

            $this->settings = get_option( Settings::OPTION, $this->defaults );
            $this->settings[ 'nonce' ] = apply_filters( 'piwik_pro_nonce', '' );

            new Settings();
            new WooCommerce();
		}

        public function filter_plugin_action_links( $actions, $plugin_file, $plugin_data, $context ) {
            if ( empty( $plugin_data[ 'Name' ] ) ) return $actions;
            if ( self::get( 'name' ) == $plugin_data[ 'Name' ] )
                array_unshift( $actions, self::render( 'link', [
                    'url' => admin_url( add_query_arg( 'page', Settings::PAGE, Settings::PARENT ) ),
                    'link' => self::__( 'Settings' )
                ] ) );

            return $actions;
        }

        public function action_wp_head() {
            foreach ( [ 'url', 'id', 'layer', 'sync' ] as $key ) if ( ! $this->settings[ $key ] ) return;

            if ( strtotime( '2024-10-07' ) > time() )
                echo wp_get_inline_script_tag(
                    ( $this->settings[ 'nonce' ] ? self::render( 'nonce', $this->settings ) : '' ) .
                    self::render( 'sync', $this->settings ),
                    $this->settings[ 'nonce' ] ? [ 'nonce' => $this->settings[ 'nonce' ] ] : []
                );
        }

        public function action_wp_body_open() {
            foreach ( [ 'url', 'id', 'layer', 'async' ] as $key ) if ( ! $this->settings[ $key ] ) return;

            echo wp_get_inline_script_tag(
                self::render( 'async', $this->settings ),
                $this->settings[ 'nonce' ] ? [ 'nonce' => $this->settings[ 'nonce' ] ] : []
            );
        }

        public function action_wp_footer() {
            foreach ( [ 'url', 'id', 'layer' ] as $key ) if ( ! $this->settings[ $key ] ) return;
            if ( ! $this->settings[ 'sync' ] and ! $this->settings[ 'async' ] ) return;

            echo wp_get_inline_script_tag(
                self::render( 'push', [ 'data' => [
                    'setTrackingSource',
                    'wordpress',
                    self::get( 'version' )
                ] ] )
            );
        }

        public function settings( $key ) {
            return $this->settings[ $key ] ?? null;
        }

        static public function render( $template, $args = [] ) {
            return call_user_func(
                [ new Templater( [ dirname( __DIR__ ) . '/templates' ] ), 'render' ],
                $template,
                $args );
        }
	}
}
