<?php
if( !defined('ABSPATH'))
    exit;

$default = array(
    'index' => 0,
    'rule'  => array(),
);


$params = wp_parse_args( $args, $default );
extract( $params );

$rule_name = isset( $rule['rule_name'] ) ? $rule['rule_name'] : '';
$rule_type = isset( $rule['rule_type'] ) ? $rule['rule_type'] : '';
$role_to_apply = isset( $rule['rule_role'] ) ? $rule['rule_role'] : '';
$role_value = isset( $rule['rule_value'] ) ? $rule['rule_value'] : '';
$currency_symbol = get_woocommerce_currency_symbol();
$all_roles = ywcrbp_get_user_role();


if ($rule_type === 'discount_perc' || $rule_type === 'markup_perc') {
    $symbol = ' (%)';
    $class_price = 'wc_input_decimal';
    $role_value = wc_format_localized_decimal($role_value);
} else {
    $symbol = ' (' . $currency_symbol . ')';
    $class_price = 'wc_input_price';
    $role_value = wc_format_localized_price($role_value);
}

$label_role_value = sprintf('%s %s', __('Value', 'yith-woocommerce-role-based-prices' ), $symbol );
?>

<div class="woocommerce_price_rule closed" rel="<?php esc_attr_e( $index );?>">
    <h3>
        <a href="#" class="remove_row_price delete"><?php _e( 'Remove', 'yith-woocommerce-role-based-prices' );?></a>
        <div class="handlediv" title="Click to toggle"></div>
        <label class="price_rule_name"><?php echo $rule_name;?></label>
    </h3>
    <div class="woocommerce_price_rule_data">
        <table cellpadding="0" cellspacing="0">
            <tbody>
                <tr>
                    <td colspan="2" class="rule_name_td">
                        <label><?php _e('Rule name','yith-woocommerce-role-based-prices' );?></label>
                        <input type="text" name="_product_rules[<?php echo $index ;?>][rule_name]" class="rule_name" value="<?php esc_attr_e( $rule_name );?>" placeholder="<?php _e('Name your rule','yith-woocommerce-role-based-prices' );?>">
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="rule_role">
                        <label><?php _e('Apply to','yith-woocommerce-role-based-prices');?></label>
                        <select name="_product_rules[<?php echo $index;?>][rule_role]" class="wc-enhanced-select" placeholder="<?php _e('Select user role','yith-woocommerce-role-based-prices');?>">
                            <?php
                            if( !empty( $all_roles ) ):
                                foreach( $all_roles as $key => $role ):?>
                                    <option value="<?php echo $key;?>" <?php selected( $key, $role_to_apply  );?>><?php echo $role;?></option>
                                <?php endforeach;endif; ?>
                        </select>
                    </td>
                </tr>
            <tr>
                <td class="rule_type_lbl">
                    <?php
                     $label_rule_price = '';

                    if( 'discount_perc' === $rule_type || 'discount_val' === $rule_type ){

                        $label_rule_price = __('Discount', 'yith-woocommerce-role-based-prices' );
                    }
                    else{
                        $label_rule_price = __('Markup', 'yith-woocommerce-role-based-prices' );
                    }

                    $txt_label = sprintf( '%s : <span class="price_type_txt">%s</span>',  __('Discount or markup', 'yith-woocommerce-role-based-prices' ), $label_rule_price)
                    ?>
                    <label><?php echo $txt_label;?></label>
                    <input type="hidden" name="_product_rules[<?php echo $index;?>][rule_type]" value="<?php esc_attr_e( $rule_type );?>">
                </td>

            </tr>
            <tr>
                <td class="rule_value">
                    <label><?php echo $label_role_value;?></label>
                    <input type="text" class="short <?php echo $class_price;?>" value="<?php esc_attr_e( $role_value );?>" name="_product_rules[<?php echo $index;?>][rule_value]">

                </td>
            </tr>

            </tbody>
        </table>
    </div>

</div>