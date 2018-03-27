<?php
/**
 * View Order
 *
 * Shows the details of a particular order on the account page.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/view-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>

<div class="image-product-view-worder">
	<?php
	// Get a list of all items that belong to the order
	$products = $order->get_items();

	// Loop through the items and get the product image
	foreach( $products as $product ) {

		$product_obj = new WC_Product( $product["product_id"] );

		echo $product_obj->get_image();

	}
	?>
</div>


<p><?php
	/* translators: 1: order number 2: order date 3: order status */
	printf(
		__( 'Order #%1$s was placed on %2$s and is currently %3$s.', 'woocommerce' ),
		'<mark class="order-number">' . $order->get_order_number() . '</mark>',
		'<mark class="order-date">' . wc_format_datetime( $order->get_date_created() ) . '</mark>',
		'<mark class="order-status">' . wc_get_order_status_name( $order->get_status() ) . '</mark>'
	);
	?></p>


<?php if ( $notes = $order->get_customer_order_notes() ) : ?>
	<h2><?php _e( 'Order updates', 'woocommerce' ); ?></h2>
	<ol class="woocommerce-OrderUpdates commentlist notes">
		<?php foreach ( $notes as $note ) : ?>
			<li class="woocommerce-OrderUpdate comment note">
				<div class="woocommerce-OrderUpdate-inner comment_container">
					<div class="woocommerce-OrderUpdate-text comment-text">
						<p class="woocommerce-OrderUpdate-meta meta"><?php echo date_i18n( __( 'l jS \o\f F Y, h:ia', 'woocommerce' ), strtotime( $note->comment_date ) ); ?></p>
						<div class="woocommerce-OrderUpdate-description description">
							<?php echo wpautop( wptexturize( $note->comment_content ) ); ?>
						</div>
						<div class="clear"></div>
					</div>
					<div class="clear"></div>
				</div>
			</li>
		<?php endforeach; ?>
	</ol>
<?php endif; ?>

<?php do_action( 'woocommerce_view_order', $order_id ); ?>

<?php if($order->get_status() != "completed") { ?>
	<div class="valid-order" style="overflow: hidden;font-size: 1.4em;padding: 2em;"><span style="font-weight: 500;">Colis receptionné :</span>
		<br/>

		<form>
			<div style="width:50%; float: left">
				<input type="radio" name="status_order" value="good" checked> Le produit reçu est conforme<br>
				<input type="radio" name="status_order" value="bad_order"> Le produit reçu n'est pas conforme<br>
				<input type="radio" name="status_order" value="bad_ship"> J'ai un problème avec la livraison
			</div>
			<div style="width: 50%; float:left">
				<input style="display: inline" type="submit" value="Valider">
			</div>

		</form>
	</div>


	<?php
}

if($_GET['status_order'] == 'good') {

	ob_start();
	$order->update_status('completed', 'order_note');

	if( $mp_transfers = get_post_meta( $order_id, 'mp_transfers', true ) )
		return false;

	if( !$mp_transaction_id = get_post_meta( $order_id, 'mp_transaction_id', true ) )
		return false;



	if( $mp_success_transaction_id = get_post_meta( $order_id, 'mp_success_transaction_id', true ) )
		$mp_transaction_id = $mp_success_transaction_id;

	$mp = mpAccess::getInstance();
	$user_id = get_current_user_id();
	$mp_user_id = $mp->set_mp_user($user_id);

	$order = new WC_Order( $order_id );
	$order_data = $order->get_data();

	$seller = dokan_get_seller_id_by_order( $order_id );
	$mp_amount = dokan_get_seller_amount_from_order($order_id);


	$mp_transfers = $mp->wallet_trans($order_id, $mp_transaction_id, $user_id, $seller, $mp_amount, 0, 'EUR');

	update_post_meta( $order_id, 'mp_transfers', $mp_transfers );

	$order->update_status('completed', 'Commande bien reçu');

}

if($_GET['status_order'] == 'bad_order') {
	$order->update_status('pending', 'Le produit reçu n\'est pas conforme');

}
if($_GET['status_order'] == 'bad_ship') {
	$order->update_status('pending', 'Problème avec la livraison');
}

?>