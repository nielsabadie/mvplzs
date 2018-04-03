<?php
/**
 * Single Product Price
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/price.php.
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

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

global $product;

	$author     = get_user_by( 'id', $product->post->post_author );
	$store_info = dokan_get_store_info( $author->ID );
	$user_info = get_userdata ($author->ID);
	$nickname = $user_info->nickname;
	$user_avatar = get_avatar ( $user_info );

	
	?>
	<div id="productUserDetails">
		<span class="avatarNameUser"><?php
			if ( !empty( $store_info['store_name'] ) ) {
				if ( !empty ($user_avatar)) { 
					'<span>' . printf( '<a href="%s">%s</a>', dokan_get_store_url( $author->ID ),get_avatar ($user_info, 25) . ' <p style="display:inline-block">' . $nickname . '</p></span>' );
				} else {
					'<span><i class="fa fa-user"></i> <p style="display:inline-block">' . $nickname . '</p></span>';
				}
			}; ?>
			
		</span>

		<span class="reviewUser">
			<?php $rating = dokan_get_seller_rating( $author->ID);?>
		
			<?php
			if ( ! $rating['count'] ) {
				echo '<p style="display: inline-block">| Aucun avis</p>';
				return;
			}
			
			$short_text = _n( '%s rating from %d review', '%s rating from %d reviews', $rating['count'], 'dokan-lite' );
			$text = sprintf( __( 'Rated %s out of %d', 'dokan-lite' ), $rating['rating'], number_format( 5 ) );
			$width = ( $rating['rating']/5 ) * 100;
			?>


			<?php
			$review_small_text = sprintf( '<i style="color:#ff9700" class="fa fa-star"></i> ' . $rating['rating'] . '/5 (' . $rating['count'] . ")" );

			if ( function_exists( 'dokan_get_review_url' ) ) {
				$review_small_text = sprintf( '| <a href="%s">%s</a>', esc_url( dokan_get_review_url( $author->ID ) ), $review_small_text );
			}
			
			?>
		
		
			<?php echo $review_small_text; ?>
		</span>
        
    	<?php 
		if ( isset( $store_info['address']['city'] ) && !empty( $store_info['address']['city'] ) ) {  	$address_details_seller = $store_info['address'];?>
		<span class="locationUser">
			<?php echo ' | <a target="_blank" href="https://www.google.fr/maps/place/' . $address_details_seller['city'] . '/" title=" Où se trouve ' .  $address_details_seller['city'] . ' ?"><i class="fa fa-map-marker"></i> ' .' '. $address_details_seller['city'] . '</a>' ?>
		</span><?php
		} ?>
			
		
		<?php printf( '<a style="margin-bottom: 20px; font-size: 0.7em; display:block;" class="btn btn-secondary" href="%s">%s</a>', dokan_get_store_url( $author->ID ),'Contacter le vendeur' );?>
	</div>



<?php
//global $product;

function singleProductAttribute(WC_Product $productObject, $attribute, $text) {
    $attributeValue = wc_get_product_terms($productObject->get_id(), $attribute, array('fields' => 'names'));

    if (is_array($attributeValue) && !empty($attributeValue)) {
        echo '<p><strong style="font-weight: bold">' . $text . '</strong> : ' . $attributeValue[0] . '</p>';
    }
}

echo '<div>';

/*echo '<pre>';
var_dump($product);
var_dump(wc_get_product_terms($product));
echo '</pre>';*/

//singleProductAttribute($product, 'pa_brand', 'Marque');

singleProductAttribute($product, 'pa_etat', 'Etat');

singleProductAttribute($product, 'pa_color', 'Couleur');

singleProductAttribute($product, 'pa_couleur-ps4', 'Couleur');

singleProductAttribute($product, 'pa_couleur-xbox-one', 'Couleur');

singleProductAttribute($product, 'pa_capacite-ssd-dd-nas', 'Capacité');
	
singleProductAttribute($product, 'pa_capacite-du-disque-dur', 'Capacité');

singleProductAttribute($product, 'pa_capacite-cles-usb', 'Capacité');

singleProductAttribute($product, 'pa_capacite-xbox-one', 'Capacité');

singleProductAttribute($product, 'pa_capacite-ps4', 'Capacité');

singleProductAttribute($product, 'pa_focale-maximale', 'Focale Maximale');

singleProductAttribute($product, 'pa_focale-minimale', 'Focale Minimale');

singleProductAttribute($product, 'pa_zoom-optique', 'Zoom Optique');
	
singleProductAttribute($product, 'pa_boitier-nu', 'Boitier nu');

singleProductAttribute($product, 'pa_nombre-de-declenchements', 'Nombre de déclenchements');

singleProductAttribute($product, 'pa_megapixels', 'Mégapixels');

singleProductAttribute($product, 'pa_norme-hd-4k', 'Qualité vidéo HD / 4K');

singleProductAttribute($product, 'pa_taille-de-lecran-tv', 'Taille d\'écran');

singleProductAttribute($product, 'pa_processeur-ordi-bureau', 'Processeur');

singleProductAttribute($product, 'pa_processeur-ordi-portables', 'Processeur');
	
singleProductAttribute($product, 'pa_carte-graphique-ordi-bureau', 'Carte graphique');

singleProductAttribute($product, 'pa_taille-ecran-ordi-portables', 'Taille d\'écran');

singleProductAttribute($product, 'pa_debloque-tout-operateur', 'Débloqué tout opérateur');

singleProductAttribute($product, 'pa_megapixels', 'Débloqué tout opérateur');

echo '</div>';
?>

<div>
	<?php $yithCompare = new YITH_Woocompare_Frontend;?>
	<?php 
		$productId = $product->get_id();
		$yithCompare->add_compare_link($productId, array('button_or_link' => 'link', 'button_text' => '+ Comparer'));
	?>
</div>


<p style="margin-top: 15px; margin-bottom: 0px !important" class="price"><?php echo $product->get_price_html(); ?></p>
