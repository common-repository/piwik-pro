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

if ( ! class_exists( __NAMESPACE__ . '\Settings' ) ) {
    class Settings extends \PiwikPRO\Vendor\Clearcode\Settings\v1_1_3\Settings {
        const OPTION = 'piwik_pro';
        const PAGE = 'piwik-pro';
        const PARENT = 'options-general.php';

        public function __construct() {
            parent::__construct( [
                self::OPTION => [
                    'pages' => [
                        self::PAGE => [
                            'title' => Plugin::__( 'Piwik PRO' ),
                            'menu' => [
                                'title' => Plugin::__( 'Piwik PRO' ),
                                'icon' => 'dashicons-chart-area',
                                'position' => null,
                                'parent' => self::PARENT
                            ],
                            'tabs' => [
                                [
                                    'sections' => [
                                        [
                                            'title' => Plugin::__( 'Settings' ),
                                            'fields' => array_merge( [
                                                'url' => [
                                                    'title' => Plugin::__( 'Container address (URL)' ),
                                                    'default' => '',
                                                    'sanitize' => [ $this, 'sanitize_url' ],
                                                    'render' => [
                                                        'template' => 'input',
                                                        'args' => [
                                                            'atts' => [
                                                                'type' => 'text',
                                                                'class' => 'regular-text'
                                                            ],
                                                            'description' => Plugin::__( 'Enter your Piwik PRO account address with <strong>containers</strong> added to the address.<br />
                                                                             For standard domains: <code>https://yourname.<strong>containers</strong>.piwik.pro</code>.<br />
                                                                             For custom domains: <code>https://yourname.piwik.pro/<strong>containers</strong></code>.<br /><br />
                                                                             <strong>Note:</strong> This address may be different for Piwik PRO on-premises or private cloud accounts.<br />
                                                                             Contact us to get the right address.' )
                                                        ]
                                                    ]
                                                ],
                                                'id' => [
                                                    'title' => Plugin::__( 'Site ID' ),
                                                    'default' => '',
                                                    'sanitize' => [ $this, 'sanitize_id' ],
                                                    'render' => [
                                                        'template' => 'input',
                                                        'args' => [
                                                            'atts' => [
                                                                'type' => 'text',
                                                                'class' => 'regular-text'
                                                            ],
                                                            'description' => Plugin::__( 'This is the unique ID for your site in Piwik PRO. <a href="https://help.piwik.pro/support/questions/find-website-id/" target="_blank">Where to find it?</a>' )
                                                        ]
                                                    ]
                                                ],
                                                'async' => [
                                                    'title' => Plugin::__( 'Containers' ),
                                                    'default' => false,
                                                    'sanitize' => [ $this, 'sanitize_checkbox' ],
                                                    'render' => [
                                                        'callback' => [ $this, 'render_checkbox' ],
                                                        'template' => 'input',
                                                        'args' => [
                                                            'field' => 'async',
                                                            'value' => true,
                                                            'atts' => [
                                                                'type' => 'checkbox'
                                                            ],
                                                            'after' => Plugin::__( 'Basic container (async)' ),
                                                            'description' => Plugin::__( "This container holds your tracking code and is used to handle most tags.<br /><br />
                                                                             <strong>Note:</strong> Make sure your WordPress theme has the <code>wp_body_open()</code> function<br />
                                                                             right after the opening <code>&lt;body&gt;</code> tag, otherwise the container won’t work." )
                                                        ]
                                                    ]
                                                ]
                                            ], ( strtotime( '2024-10-07' ) > time() ) ? [
                                                'sync' => [
                                                    'title' => '',
                                                    'default' => false,
                                                    'sanitize' => [ $this, 'sanitize_checkbox' ],
                                                    'render' => [
                                                        'callback' => [ $this, 'render_checkbox' ],
                                                        'template' => 'input',
                                                        'args' => [
                                                            'field' => 'sync',
                                                            'value' => true,
                                                            'atts' => [
                                                                'type' => 'checkbox'
                                                            ],
                                                            'after' => Plugin::__( 'Additional container (sync)' ),
                                                            'description' => Plugin::__( 'Add this container if you want to use sync tags. It loads tags before the page content loads.' ) . '<br />' .
                                                                             '<p><span class="notice notice-warning">' . Plugin::__( 'Support for the sync tags will be sunset on October 7, 2024. We recommend using async tags instead.' ) . '</span></p>'
                                                        ]
                                                    ]
                                                ]
                                            ] : [], [
                                                'layer' => [
                                                    'title' => Plugin::__( 'Data layer' ),
                                                    'default' => 'dataLayer',
                                                    'sanitize' => [ $this, 'sanitize_layer' ],
                                                    'render' => [
                                                        'template' => 'input',
                                                        'args' => [
                                                            'value' => true,
                                                            'atts' => [
                                                                'type' => 'text',
                                                                'class' => 'regular-text'
                                                            ],
                                                            'description' => Plugin::__( 'Default: <code>dataLayer</code>. Rename the data layer if you use other software with data layers.<br />
                                                                                 If the names are the same, the software can interfere with each other. 
                                                                                 <a href="https://developers.piwik.pro/en/latest/tag_manager/data_layer_name.html#data-layer-name-guidelines" target="_blank">How to check it?</a>' )
                                                        ]
                                                    ]
                                                ]
                                            ], class_exists( 'WooCommerce' ) ? [
                                                'woocommerce' => [
                                                    'title' => Plugin::__( 'WooCommerce' ),
                                                    'default' => false,
                                                    'sanitize' => [ $this, 'sanitize_checkbox' ],
                                                    'render' => [
                                                        'callback' => [ $this, 'render_checkbox' ],
                                                        'template' => 'input',
                                                        'args' => [
                                                            'field' => 'woocommerce',
                                                            'value' => true,
                                                            'atts' => [
                                                                'type' => 'checkbox'
                                                            ],
                                                            'after' => Plugin::__( 'Enable ecommerce tracking for <code>WooCommerce</code>.' ),
                                                            'description' => Plugin::__( 'If turned on, you’ll automatically track all ecommerce events in your online store. <a href="https://help.piwik.pro/support/getting-started/track-ecommerce/" target="_blank">Read more</a>' )
                                                        ]
                                                    ]
                                                ]
                                            ] : [] )
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ] );
        }

        protected function sanitize_url( $value ) {
            $value = rtrim( sanitize_text_field( $value ), '/' );
            if ( ! filter_var( $value, FILTER_VALIDATE_URL ) ) {
                $this->notice( 'Wrong <code>Container address (URL)</code> value.' );
                return get_option( self::OPTION )[ 'url' ];
            }
            return $value;
        }

        protected function sanitize_id( $value ) {
            $value = strtolower( sanitize_text_field( $value ) );
            if ( preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-[1-5][0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/', $value ) !== 1 ) {
                $this->notice( 'Wrong <code>Site ID</code> value.' );
                return get_option( self::OPTION )[ 'id' ];
            }
            return $value;
        }

        protected function sanitize_layer( $value ) {
            $value = sanitize_text_field( $value );
            if ( preg_match('/^[a-zA-Z_$][0-9a-zA-Z_$]*$/', $value ) !== 1 ) {
                $this->notice( 'Wrong <code>Data layer</code> value.' );
                return get_option( self::OPTION )[ 'layer' ];
            }
            return $value;
        }

        protected function sanitize_checkbox( $value ) {
            return (bool)$value;
        }

        protected function render_checkbox( $template, $args ) {
            $field = $args[ 'field' ];

            if ( get_option( self::OPTION )[ $field ] )
                $args[ 'atts' ][ 'checked'] = 'checked';

            $args['value'] = true;

            return call_user_func(
                [ new Templater( [ dirname( __DIR__ ) . '/vendor/clearcode/wordpress-settings/src/v1_1_3/templates' ] ), 'render' ],
                $template,
                $args );
        }

        protected function notice( $message, $type = 'error' ) {
            add_settings_error(
                Plugin::get( 'slug' ),
                'settings_updated',
                $message,
                in_array( $type, [ 'success', 'warning', 'info' ] ) ? $type : 'error'
            );
        }
    }
}