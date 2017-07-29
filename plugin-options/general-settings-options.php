<?php
if( !defined('ABSPATH'))
    exit;

$desc = sprintf('%s', __( 'By selecting Regular Price, the new prices will be calculated on the product base price, otherwise on the sale price (if available)', 'yith-woocommerce-role-based-prices' ) );

$setting    =    array(

    'general-settings'  =>  array(

        'general_start' => array(
            'name' => __( 'General settings', 'yith-woocommerce-role-based-prices' ),
            'type'  => 'title'
        ),

        'how_apply_rule' => array(
               'name' => __( 'Apply price rule on', 'yith-woocommerce-role-based-prices' ),
                'desc_tip' => $desc,
                'type'    => 'radio',
                'id' => 'ywcrbp_apply_rule',
                'options' => array(
                        'regular' => __('Regular Price', 'yith-woocommerce-role-based-prices' ),
                        'on_sale' => __('On Sale Price', 'yith-woocommerce-role-based-prices')
                ),
                'default' => 'regular'
               ),
        'general_end' => array(
            'type'  => 'sectionend',
        ),

    )
);


return apply_filters('ywcrbp_general_settings_opt', $setting );