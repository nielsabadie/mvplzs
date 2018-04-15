<?php echo $email_heading ?>

<?php _e( 'Hello,', 'dokan-lite' ); ?>

<?php _e( 'A new product is submitted to your site and is pending review', 'dokan-lite' ); ?>
<a href="<?php echo $data['site_url'] ?>" ><?php echo $data['site_name'] ?></a> 

<?php _e( 'Summary of the product:', 'dokan-lite' ); ?>

<?php _e( 'Summary of the product:', 'dokan-lite' ); ?>

<?php _e( 'Title :', 'dokan-lite' ); ?>

<?php printf( '<a href="%s">%s</a>', $data['product_link'], $data['product-title']  ); ?>

<strong>
	<?php _e( 'Price :', 'dokan-lite' ); ?>
</strong>
<?php echo wc_price( $data['price'] ); ?>


<strong>
    <?php _e( 'Vendor :', 'dokan-lite' ); ?>
</strong>
<?php 
printf( '<a href="%s">%s</a>', $data['seller_url'], $data['seller-name']  ); ?>

<strong>
    <?php _e( 'Category :', 'dokan-lite' ); ?>
</strong>
<?php echo $data['category'] ?>

<?php _e( 'The product is currently in "pending" status.', 'dokan-lite' ); ?>

<?php do_action( 'woocommerce_email_footer', $email );?>