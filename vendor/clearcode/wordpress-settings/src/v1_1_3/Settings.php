<?php

/*
    Copyright (C) 2022 by Clearcode <https://clearcode.cc>
    and associates (see AUTHORS.txt file).

    This file is part of clearcode/wordpress-settings.

    clearcode/wordpress-settings is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 3 of the License, or
    (at your option) any later version.

    clearcode/wordpress-settings is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with clearcode/wordpress-settings; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

namespace PiwikPRO\Vendor\Clearcode\Settings\v1_1_3;

use PiwikPRO\Vendor\Clearcode\Framework\v6_1_3\Filterer;
use PiwikPRO\Vendor\Clearcode\Framework\v6_1_3\Templater;

defined( 'ABSPATH' ) or exit;

if ( ! class_exists( __NAMESPACE__ . '\Settings' ) ) {
    class Settings {
        protected $settings = [];

        public function __construct( array $settings ) {
            $this->settings = array_map( function( $setting ) {
                return [
                    'group' => ( isset( $setting[ 'group' ] ) and is_string( $setting[ 'group' ] ) ) ? $setting[ 'group' ] : '',
                    'type' => ( isset( $setting[ 'type' ] ) and in_array( $setting[ 'type' ], [ 'array', 'boolean', 'integer', 'number', 'object' ] ) ) ? $setting[ 'type' ] : 'string',
                    'description' => ( isset( $setting[ 'description' ] ) and is_string( $setting[ 'description' ] ) ) ? $setting[ 'description' ] : '',
                    'rest' => ( isset( $setting[ 'rest' ] ) and is_bool( $setting[ 'rest' ] ) ) ? $setting[ 'rest' ] : false,
                    'pages' => ( isset( $setting[ 'pages' ] ) and is_array( $setting[ 'pages' ] ) and ! empty( $setting[ 'pages' ] ) ) ? array_map( function( $page ) {
                        return [
                            'menu' => [
                                'title' => ( isset( $page[ 'menu' ][ 'title' ] ) and is_string( $page[ 'menu' ][ 'title' ] ) ) ? $page[ 'menu' ][ 'title' ] : '',
                                'icon' => ( isset( $page[ 'menu' ][ 'icon' ] ) and is_string( $page[ 'menu' ][ 'icon' ] ) ) ? $page[ 'menu' ][ 'icon' ] : '',
                                'position' => ( isset( $page[ 'menu' ][ 'position' ] ) and is_numeric( $page[ 'menu' ][ 'position' ] ) ) ? (int)$page[ 'menu' ][ 'position' ] : null,
                                'parent' => ( isset( $page[ 'menu' ][ 'parent' ] ) and is_string( $page[ 'menu' ][ 'parent' ] ) ) ? $page[ 'menu' ][ 'parent' ] : false,
                            ],
                            'title' => ( isset( $page[ 'title' ] ) and is_string( $page[ 'title' ] ) ) ? $page[ 'title' ] : '',
                            'capability' => ( isset( $page[ 'capability' ] ) and is_string( $page[ 'capability' ] ) ) ? $page[ 'capability' ] : 'manage_options',
                            'render' => [
                                'callback' => ( isset( $page[ 'render' ][ 'callback' ] ) and is_callable( $page[ 'render' ][ 'callback' ] ) ) ? $page[ 'render' ][ 'callback' ] : null,
                                'template' => ( isset( $page[ 'render' ][ 'template' ] ) and is_string( $page[ 'render' ][ 'template' ] ) ) ? $page[ 'render' ][ 'template' ] : '',
                                'args' => ( isset( $page[ 'render' ][ 'args' ] ) and is_array( $page[ 'render' ][ 'args' ] ) ) ? $page[ 'render' ][ 'args' ] : []
                            ],
                            'tabs' => ( isset( $page[ 'tabs' ] ) and is_array( $page[ 'tabs' ] ) and ! empty( $page[ 'tabs' ] ) ) ? array_map( function( $tab ) {
                                return [
                                    'title' => ( isset( $tab[ 'title' ] ) and is_string( $tab[ 'title' ] ) ) ? $tab[ 'title' ] : '',
                                    'sections' => ( isset( $tab[ 'sections' ] ) and is_array( $tab[ 'sections' ] ) and ! empty( $tab[ 'sections' ] ) ) ? array_map( function( $section ) {
                                        return [
                                            'title' => ( isset( $section[ 'title' ] ) and is_string( $section[ 'title' ] ) ) ? $section[ 'title' ] : '',
                                            'render' => [
                                                'callback' => ( isset( $section[ 'render' ][ 'callback' ] ) and is_callable( $section[ 'render' ][ 'callback' ] ) ) ? $section[ 'render' ][ 'callback' ] : null,
                                                'template' => ( isset( $section[ 'render' ][ 'template' ] ) and is_string( $section[ 'render' ][ 'template' ] ) ) ? $section[ 'render' ][ 'template' ] : '',
                                                'args' => ( isset( $section[ 'render' ][ 'args' ] ) and is_array( $section[ 'render' ][ 'args' ] ) ) ? $section[ 'render' ][ 'args' ] : []
                                            ],
                                            'fields' => ( isset( $section[ 'fields' ] ) and is_array( $section[ 'fields' ] ) and ! empty( $section[ 'fields' ] ) ) ? array_map( function( $field ) {
                                                return [
                                                    'title' => ( isset( $field[ 'title' ] ) and is_string( $field[ 'title' ] ) ) ? $field[ 'title' ] : '',
                                                    'render' => [
                                                        'callback' => ( isset( $field[ 'render' ][ 'callback' ] ) and is_callable( $field[ 'render' ][ 'callback' ] ) ) ? $field[ 'render' ][ 'callback' ] : null,
                                                        'template' => ( isset( $field[ 'render' ][ 'template' ] ) and is_string( $field[ 'render' ][ 'template' ] ) ) ? $field[ 'render' ][ 'template' ] : '',
                                                        'args' => ( isset( $field[ 'render' ][ 'args' ] ) and is_array( $field[ 'render' ][ 'args' ] ) ) ? $field[ 'render' ][ 'args' ] : []
                                                    ],
                                                    'sanitize' => ( isset( $field[ 'sanitize' ] ) and is_callable( $field[ 'sanitize' ] ) ) ? $field[ 'sanitize' ] : function( $option ) { return $option; },
                                                    'default' => ( isset( $field[ 'default' ] ) ) ? $field[ 'default' ] : '',
                                                ];
                                            }, $section[ 'fields' ] ) : []
                                        ];
                                    }, $tab[ 'sections' ] ) : []
                                ];
                            }, $page[ 'tabs' ] ) : []
                        ];
                    }, $setting[ 'pages' ] ) : []
                ];
            }, $settings );

            new Filterer( $this );
        }

        public function action_admin_menu() {
            foreach ( $this->settings as $option_name => $setting ) {
                foreach ( $setting[ 'pages' ] as $page_slug => $page ) {
                    if ( ! $title = $page[ 'menu' ][ 'title' ] ?: $page[ 'title' ] ) continue;

                    $callback = function() use ( $setting, $option_name, $page_slug, $page, $title ) {
                        if ( ! current_user_can( $page[ 'capability' ] ) ) wp_die( __( 'Cheatin&#8217; uh?' ) );

                        $tabs = [];
                        foreach ( $page[ 'tabs' ] as $tab_id => $tab )
                            if ( isset( $tab[ 'title' ] ) )
                                $tabs[ $tab_id ] = $tab[ 'title' ];

                        echo $this->render( $page[ 'render' ][ 'callback' ], $page[ 'render' ][ 'template' ] ?: 'page', array_merge( $page[ 'render' ][ 'args' ],
                            [
                                'option_name' => $option_name,
                                'option_group' => $setting[ 'group' ] ?: $page_slug,
                                'page' => $page_slug,
                                'header' => $title,
                                'tab' => $this->get_tab( array_keys( $tabs ) ),
                                'tabs' => $tabs,
                                'url' => menu_page_url( $page_slug, false )
                            ] ) );
                    };

                    if ( $page[ 'menu' ][ 'parent' ] )
                        add_submenu_page(
                            $page[ 'menu' ][ 'parent' ],
                            $page[ 'title' ] ?: $title,
                            $page[ 'menu' ][ 'icon' ] ? $this->render( null, 'menu', [
                                'icon' => $page[ 'menu' ][ 'icon' ],
                                'content' => $title
                            ] ) : $title,
                            $page[ 'capability' ],
                            $page_slug,
                            $callback,
                            $page[ 'menu' ][ 'position' ]
                        );
                    else
                        add_menu_page(
                            $page[ 'title' ] ?: $title,
                            $title,
                            $page[ 'capability' ],
                            $page_slug,
                            $callback,
                            $page[ 'menu' ][ 'icon' ],
                            $page[ 'menu' ][ 'position' ]
                        );
                }
            }
        }

        public function action_admin_init() {
            foreach ( $this->settings as $option_name => $setting ) {
                $option = get_option( $option_name, [] );

                foreach ( $setting[ 'pages' ] as $page_slug => $page ) {

                    $sanitize = [];
                    $default = [];

                    foreach ( $page[ 'tabs' ] as $tab_id => $tab ) {
                        if ( $this->get_tab( array_keys( $page[ 'tabs' ] ) ) !== $tab_id ) continue;
                        foreach ( $tab[ 'sections' ] as $section_id => $section ) {
                            add_settings_section(
                                $section_id,
                                $section[ 'title' ],
                                function() use( $section ) {
                                    echo $this->render( $section[ 'render' ][ 'callback' ],
                                        $section[ 'render' ][ 'template' ] ?: 'section',
                                        $section[ 'render' ][ 'args' ]
                                    );
                                },
                                $page_slug
                            );

                            foreach ( $section[ 'fields' ] as $field_id => $field ) {
                                add_settings_field(
                                    $field_id,
                                    $field[ 'title' ],
                                    function( $args ) use ( $field ) {
                                        echo $this->render( $field[ 'render' ][ 'callback' ], $field[ 'render' ][ 'template' ], $args );
                                    },
                                    $page_slug,
                                    $section_id,
                                    array_merge( $field[ 'render' ][ 'args' ], [
                                        'id' => $id = sprintf( '%s-%s', $option_name, $field_id ),
                                        'name' => sprintf( '%s[%s]', $option_name, $field_id ),
                                        'value' => isset( $option[ $field_id ] ) ? $option[ $field_id ] : $field[ 'default' ],
                                        'label_for' => $id
                                    ] )
                                );

                                $sanitize[ $field_id ] = $field[ 'sanitize' ];
                                $default[ $field_id ] = $field[ 'default' ];
                            }
                        }
                    }

                    register_setting(
                        $setting[ 'group' ] ?: $page_slug,
                        $option_name,
                        [
                            'type' => $setting[ 'type' ],
                            'description' => $setting[ 'description' ],
                            'show_in_rest' => $setting[ 'rest' ],
                            'sanitize_callback' => function( $option ) use( $sanitize, $default, $option_name ) {
                                if ( empty( $sanitize ) and empty( $default ) ) return $option;
                                $sanitized_option = [];
                                foreach ( $sanitize as $id => $callback )
                                    if ( isset( $option[ $id ] ) and ! empty( $option[ $id ] ) ) $sanitized_option[ $id ] = $callback( $option[ $id ] );
                                    else $sanitized_option[ $id ] = $default[ $id ];

                                return array_merge( get_option( $option_name ), $sanitized_option );
                            },
                            'default' => $default
                        ]
                    );
                }
            }
        }

        public function render( $callback, $template, $args ) {
            $callback = $callback ?: [ new Templater( [ __DIR__ . '/templates', '' ] ), 'render' ];
            return call_user_func( $callback, $template, $args );
        }
        
        public function get_tab( array $tabs ) {
            return ( isset( $_GET[ 'tab' ] ) and in_array( $_GET[ 'tab' ], $tabs ) ) ? $_GET[ 'tab' ] : reset( $tabs );
        }
    }
}
