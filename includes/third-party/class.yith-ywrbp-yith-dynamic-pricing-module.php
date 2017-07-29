<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( ! class_exists( 'YITH_WRBP_Dynamic_Pricing_Module' ) ) {

	class YITH_WRBP_Dynamic_Pricing_Module {

		protected static $instance;

		public function __construct() {
			remove_filter( 'option_woocommerce_tax_display_shop', array(
				YITH_Role_Based_Prices_Product(),
				'show_price_incl_excl_tax'
			), 10 );
			remove_filter( 'option_woocommerce_tax_display_cart', array(
				YITH_Role_Based_Prices_Product(),
				'show_price_incl_excl_tax'
			), 10 );
			add_action( 'ywdpd_after_cart_process_discounts', array( $this, 'update_cart' ), 99 );
		}

		/**
		 * Returns single instance of the class
		 * @author YITHEMES
		 * @return \YITH_WRBP_Dynamic_Pricing_Module
		 * @since 1.0.0
		 */
		public static function get_instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		/**
		 *
		 */
		public function update_cart() {


			WC()->cart->calculate_totals();

		}


		/**
		 * @param string $html
		 * @param array $rule
		 * @param WC_Product $product
		 */
		public function show_right_discount_in_table( $html, $rule, $product ) {

			$product_id = yit_get_base_product_id( $product );
			$role_price = YITH_Role_Based_Prices_Product()->get_new_price( $product_id );

			if ( 'no_price' != $role_price ) {

				$price = ( WC()->cart->tax_display_cart == 'excl' ) ? yit_get_price_excluding_tax( $product, 1, $role_price ) : yit_get_price_including_tax( $product, 1, $role_price );
				$discount_price = ywdpd_get_discounted_price_table( $price, $rule );

				$html = wc_price( $discount_price );
			}

			return $html;
		}


	}
}
/**
 * @return YITH_WRBP_Dynamic_Pricing_Module
 */
function YITH_WRBP_Dynamic_Pricing_Module() {
	return YITH_WRBP_Dynamic_Pricing_Module::get_instance();
}

YITH_WRBP_Dynamic_Pricing_Module();