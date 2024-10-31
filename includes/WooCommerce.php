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

use PiwikPRO\Vendor\Clearcode\Framework\v6_1_3\Filterer;

defined( 'ABSPATH' ) or exit;

if ( ! class_exists( __NAMESPACE__ . '\WooCommerce' ) ) {
	class WooCommerce {
        public function __construct() {
            new Filterer( $this );
        }

        static public function enabled() {
            if ( ! class_exists( 'WooCommerce' ) ) return false;
            if ( ! Plugin::instance()->settings( 'sync' ) and ! Plugin::instance()->settings( 'async' ) ) return false;
            foreach ( [ 'url', 'id', 'layer', 'woocommerce' ] as $key ) if ( ! Plugin::instance()->settings( $key ) ) return false;

            return true;
        }

        public function action_woocommerce_after_single_product() {
            if ( ! self::enabled() ) return;

            global $product;

            wc_enqueue_js( Plugin::render( 'product', $this->get_product_data( $product->get_id() ) ) );
        }

        public function action_woocommerce_after_add_to_cart_button() {
            if ( ! self::enabled() ) return;

            if ( ! is_single() ) return;
            global $product;

            wc_enqueue_js( Plugin::render( 'add', $this->get_product_data( $product->get_id() ) ) );
        }

        public function action_wp_footer() {
            if ( ! self::enabled() ) return;

            wc_enqueue_js( Plugin::render( 'loop' ) );

            if ( is_order_received_page() and $order = $this->get_order() ) {
                $products = [];
                foreach ( $order->get_items() as $get_item )
                    $products[] = $this->get_product_data( $get_item[ 'product_id' ], $get_item[ 'quantity' ] );

                echo wp_get_inline_script_tag( Plugin::render( 'push', [ 'data' => array_merge(
                    [ 'ecommerceOrder' ],
                    [ $products ],
                    [ $this->get_order_data( $order ) ]
                ) ] ) );

                $order->update_meta_data( '_piwik_pro_tracked', 1 );
                $order->save();
            }
        }

        public function action_woocommerce_after_cart() {
            if ( ! self::enabled() ) return;

            wc_enqueue_js( Plugin::render( 'remove' ) );
        }

        protected function get_product_categories( $product_id ) {
            $categories = [];
            foreach ( get_the_terms( $product_id, 'product_cat' ) as $term )
                $categories[] = esc_js( $term->name );

            switch ( count( $categories ) ) {
                case 0: return '';
                case 1: return $categories[ 0 ];
                default : return array_slice( $categories, 0, 5 );
            }
        }

        protected function get_product_data( $product_id, $quantity = 1 ) {
            return ( $product = wc_get_product( $product_id ) ) ? [
                'sku' => esc_js( $product->get_sku() ?: ( '#' . $product->get_id() ) ),
                'name' => esc_js( $product->get_title() ),
                'category' => $this->get_product_categories( $product->get_id() ),
                'price' => floatval( $product->get_price() ),
                'quantity' => intval( $quantity )
            ] : [];
        }

        protected function get_order() {
            global $wp;

            $order_id = is_numeric( $wp->query_vars[ 'order-received' ] ) ? intval( $wp->query_vars[ 'order-received' ] ) : 0;
            if ( ! $order_id ) return null;

            $order = wc_get_order( $order_id );
            if ( $order and $order->has_status( 'failed' ) ) return null;
            if ( $order and (bool)$order->get_meta( '_piwik_pro_tracked' ) ) return null;

            return $order;
        }

        protected function get_order_data( $order ) {
            return [
                'orderId' => $order->get_id(),
                'grandTotal' => floatval( $order->get_total() ),
                'subTotal' => floatval( $order->get_subtotal() ),
                'tax' => floatval( $order->get_total_tax() ),
                'shipping' => floatval( $order->get_shipping_total() ),
                'discount' => floatval( $order->get_total_discount() )
            ];
        }
	}
}
