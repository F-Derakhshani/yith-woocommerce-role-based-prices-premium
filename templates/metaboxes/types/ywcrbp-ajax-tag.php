<?php
if( !defined( 'ABSPATH' ) )
    exit;

extract( $args );

global $post;
$placeholder_txt    =   isset( $placeholder ) ? $placeholder : '';
$is_multiple = isset( $multiple ) && $multiple;
$multiple = ( $is_multiple ) ? 'true' : 'false';

$tag_ids = get_post_meta( $post->ID, $id, true );
if( !is_array( $tag_ids ) ) {
    $tag_ids = explode( ',', get_post_meta( $post->ID, $id, true ) );
}
$json_ids   =   array();

if( $tag_ids ){

    foreach( $tag_ids as $tag_id ){

        $tag_name   =   get_term_by( 'id', $tag_id, 'product_tag' );
        if( !empty( $tag_name ) )
            $json_ids[ $tag_id ] = '#'.$tag_name->term_id.'-'.$tag_name->name;
        }
    }

$currency_symbol = get_woocommerce_currency_symbol();

$args = array(
    'id' => $id,
    'class' => 'wc-product-search',
    'name' => $name,
    'data-multiple' => true,
    'data-placeholder' => $placeholder_txt,
    'data-action' => 'yit_role_price_json_search_product_tags',
    'data-selected' => $json_ids,
    'value' =>  implode( ',',array_keys( $json_ids ) ),
    'style' => 'width:300px;'
);
?>

<div id="<?php echo $id ?>-container" <?php if ( isset( $deps ) ): ?>data-field="<?php echo $id ?>" data-dep="<?php echo $deps['ids'] ?>" data-value="<?php echo $deps['values'] ?>" <?php endif ?>>

    <label for="<?php echo esc_attr( $id ); ?>"><?php echo esc_html($label ); ?></label>
    <?php yit_add_select2_fields( $args );?>
    <span class="desc inline"><?php echo $desc ?></span>
</div>

