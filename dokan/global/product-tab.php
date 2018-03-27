<?php
/**
 * Dokan Seller Single product tab Template
 *
 * @since 2.4
 *
 * @package dokan
 */
?>

<?php
$user_info = get_userdata ($author->ID);
$nickname = $user_info->nickname;
$user_avatar = get_avatar ( $user_info );
?>

<h2><?php _e( 'Vendor Information', 'dokan-lite' ); ?></h2>

<div style="display: inline-block; vertical-align: top;"><?php
			if ( !empty( $store_info['store_name'] ) ) {
				if ( !empty ($user_avatar)) { 
					'<span>' . printf( '<a href="%s">%s</a>', dokan_get_store_url( $author->ID ),get_avatar ($user_info) . '</span>' );
				} else {
					'<span><i class="fa fa-user"></i></span>';
				}
			}; ?>
			
</div>

<div style="display: inline-block; margin-left: 10px">
	<ul class="list-unstyled">
		<?php if ( !empty( $store_info['store_name'] ) ) { ?>
			<li class="store-name">

				<span style="font-size:1.3em" class="details">

					<?php printf( '<a href="%s">%s</a>', dokan_get_store_url( $author->ID ), '<i class="fa fa-user"></i> ' . $nickname ); ?>
				</span>
			</li>
		<?php } ?>

		<li class="store-name">
			<span style="font-size:1.3em" class="details">
				<?php 
				$users = get_users();
				$udata = $user_info;
				$registered = $udata->user_registered; ?>
				
				<?php printf( '<a href="%s">%s</a>', dokan_get_store_url( $author->ID ), '<i class="fa fa-calendar"></i> ' . htmlspecialchars( date( "m/Y", strtotime( $registered ) )) ); ?>
			</span>
		</li>

		<?php if ( isset( $store_info ) && !empty( $store_info ) ) { ?>
		<?php $address_details_seller = $store_info['address'];?>
			<li class="store-address">

				<span class="details">
					<?php echo '<a target="_blank" href="https://www.google.fr/maps/place/' . $address_details_seller['city'] . '/" title="Où se trouve ' . $address_details_seller['city'] . ' "><i class="fa fa-map-marker"></i> ' . $address_details_seller['zip'] .' '. $address_details_seller['city'] . '</a>' ?>
				</span>
			</li>
		<?php } ?>

		<li class="clearfix">
			<?php dokan_get_readable_seller_rating( $author->ID ); ?>
		</li>
	</ul>
</div>

