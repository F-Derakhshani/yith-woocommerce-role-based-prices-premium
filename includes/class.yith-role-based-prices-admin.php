<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( ' YITH_Role_Based_Prices_Admin' ) ) {

	class YITH_Role_Based_Prices_Admin {

		protected static $instance;

		/**
		 * YITH_Role_Based_Prices_Admin constructor.
		 */
		public function __construct() {
			add_action( 'woocommerce_admin_field_select-customer-role', array( $this, 'show_custom_type' ) );
			add_action( 'woocommerce_admin_field_show-prices-user-role', array( $this, 'show_prices_user_type' ) );
			add_action( 'pre_update_option', array( $this, 'update_custom_message' ), 20, 3 );
			add_action( 'admin_enqueue_scripts', array( $this, 'include_admin_script' ) );

		}

		/**
		 * Returns single instance of the class
		 * @author YITHEMES
		 * @return \YITH_Role_Based_Prices_Admin
		 * @since 1.0.0
		 */
		public static function get_instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		/**show custom type
		 * @author YITHEMES
		 * @since 1.0.0
		 */
		public function show_custom_type( $option ) {

			wc_get_template( 'admin/select-customer-role.php', array( 'option' => $option ), '', YWCRBP_TEMPLATE_PATH );
		}

		/**show custom type
		 * @author YITHEMES
		 * @since 1.0.0
		 */
		public function show_prices_user_type( $option ) {

			wc_get_template( 'admin/show-prices-user-role.php', array( 'option' => $option ), '', YWCRBP_TEMPLATE_PATH );
		}

		/**
		 * add script and style in admin
		 * @author YITHEMES
		 * @since 1.0.0
		 */
		public function include_admin_script() {
			if ( ! isset( $_GET['post'] ) ) {
				global $post;
			} else {
				$post = $_GET['post'];
			}
			$right_post_type = ( isset( $post ) && get_post_type( $post ) === 'yith_price_rule' ) || ( isset( $_GET['post_type'] ) && 'yith_price_rule' === $_GET['post_type'] ) || ( isset( $_GET['page'] ) && 'yith_vendor_role_based_prices_settings' === $_GET['page'] );
			$suffix          = ! ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '.min' : '';

			wp_enqueue_script( 'ywcrbp_admin', YWCRBP_ASSETS_URL . 'js/ywcrbp_admin' . $suffix . '.js', array( 'jquery' ), YWCRBP_VERSION );

			if ( ( isset( $_GET['page'] ) && $_GET['page'] == 'yith_wcrbp_panel' ) || $right_post_type ) {

				wp_enqueue_style( 'ywcrbp_style', YWCRBP_ASSETS_URL . 'css/ywrbp_admin.css', array(), YWCRBP_VERSION );

			}

			if ( $right_post_type ) {

				wp_enqueue_script( 'select2', WC()->plugin_url() . '/assets/js/select2/select2' . $suffix . '.js', array( 'jquery' ), '3.5.2' );
				wp_enqueue_script( 'wc-enhanced-select', WC()->plugin_url() . '/assets/js/admin/wc-enhanced-select' . $suffix . '.js', array(
					'jquery',
					'select2'
				), WC_VERSION );

				wp_enqueue_script( 'woocommerce_admin', WC()->plugin_url() . '/assets/js/admin/woocommerce_admin' . $suffix . '.js', array(
					'jquery',
					'jquery-blockui',
					'jquery-ui-sortable',
					'jquery-ui-widget',
					'jquery-ui-core',
					'jquery-tiptip'
				), WC_VERSION );

			}
		}

		/**
		 * before update custom message, remove html tag
		 * @author YITHEMES
		 * @since 1.0.0
		 *
		 * @param $value
		 * @param $option
		 * @param $old_value
		 *
		 * @return string
		 */
		public function update_custom_message( $value, $option, $old_value ) {

			if ( 'ywcrbp_message_user' === $option ) {
				$value = htmlspecialchars( stripslashes( $value ) );
			}

			return $value;
		}
	}
}

/**
 *
 * @author YITHEMES
 * @return YITH_Role_Based_Prices_Admin
 * @since 1.0.0
 */
function YITH_Role_Based_Admin() {
	return YITH_Role_Based_Prices_Admin::get_instance();
}

