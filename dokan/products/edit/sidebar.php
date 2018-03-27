<?php
global $post;

$_downloadable   = get_post_meta( $post->ID, '_downloadable', true );
$_virtual   = get_post_meta( $post->ID, '_virtual', true );

$_is_lot_discount       = get_post_meta( $post->ID, '_is_lot_discount', true );
$_lot_discount_quantity = get_post_meta( $post->ID, '_lot_discount_quantity', true );
$_lot_discount_amount   = get_post_meta( $post->ID, '_lot_discount_amount', true );
$is_enable_op_discount  = dokan_get_option( 'discount_edit', 'dokan_selling', '' ) ? dokan_get_option( 'discount_edit', 'dokan_selling', '' ) : array();

?>
<div class="update-button-wrap">
    <input type="submit" name="dokan_update_product" class="dokan-btn dokan-btn-theme dokan-btn-lg" value="<?php esc_attr_e( 'Update Product', 'dokan' ); ?>"/>
</div>

<div class="toggle-sidebar-container">

    <div class="dokan-post-status dokan-toggle-sidebar">
        <label for="post_status"><?php _e( 'Product Status:', 'dokan' ); ?> : </label>

        <?php $pending_class = $post->post_status == 'pending' ? '  dokan-label dokan-label-warning': ''; ?>
        <span style="font-weight: bold" class="dokan-toggle-selected-display<?php echo $pending_class; ?>"><?php echo dokan_get_post_status( $post->post_status ); ?></span>
    </div>

    <div class="product-type dokan-toggle-sidebar">
        

        <?php
        $supported_types = apply_filters( 'dokan_product_type_selector', array(
            'simple'    => __( 'Simple product', 'dokan' ),
        ) );

        if ( $terms = wp_get_object_terms( $post->ID, 'product_type' ) ) {
            $product_type = sanitize_title( current( $terms )->name );
        } else {
            $product_type = 'simple';
        }


        if ( !array_key_exists( $product_type, $supported_types) ) {
            $product_type = 'simple';
        }
        ?>
    </div> <!-- .product-type -->
</div>

