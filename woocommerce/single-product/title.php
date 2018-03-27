<?php
/**
 * Single Product title
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/title.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see        https://docs.woocommerce.com/document/template-structure/
 * @author     WooThemes
 * @package    WooCommerce/Templates
 * @version    1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

the_title( '<h1 class="product_title entry-title">', '</h1>' );?>


<?php /*
	$user_id = $store_user->get_id();
	$user_info = get_userdata($user_id);
	$nickname = $user_info->nickname;
*/?>
	
	<?php do_action( 'woocommerce_after_shop_loop_item_title' );
	
	global $product;
	
		?><h3 style="font-family: var(--font-family1); font-weight: bold;"><?php echo $product->get_name();?></h3>
	<?php
	
	if (is_product() ) {
		echo the_date('', '<p class="date_published"><strong>Annonce publiée le: </strong>', '</p>', false);
	}
	//var_dump($product);
	

	
	$product->data;
	$product->get_date_created();






