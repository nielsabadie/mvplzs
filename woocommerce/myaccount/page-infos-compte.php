<?php if ( ! defined( 'ABSPATH' ) ) {
	exit;
}   

	$dokan_Seller_Verification = Dokan_Seller_Verification::init();
	
	$user = wp_get_current_user();
	$user_id = get_current_user_id();
	$seller_profile = dokan_get_store_info( $user_id );

	$gravatar       = isset( $seller_profile['dokan_verification']['info']['photo_id'] ) ? $seller_profile['dokan_verification']['info']['photo_id'] : 0;
	$phone          = isset( $seller_profile['dokan_verification']['info']['phone'] ) ? $seller_profile['dokan_verification']['info']['phone'] : '';
	$address        = isset( $seller_profile['dokan_verification']['info']['address'] ) ? $seller_profile['dokan_verification']['info']['address'] : '';
	$id_type        = isset( $seller_profile['dokan_verification']['info']['dokan_v_id_type'] ) ? $seller_profile['dokan_verification']['info']['dokan_v_id_type'] : 'passport';
	$id_type        = ( $id_type != '' ) ? $id_type : 'passport';
	$id_status      = isset( $seller_profile['dokan_verification']['info']['dokan_v_id_status'] ) ? $seller_profile['dokan_verification']['info']['dokan_v_id_status'] : '';
	$address_status = isset( $seller_profile['dokan_verification']['info']['store_address']['v_status'] ) ? $seller_profile['dokan_verification']['info']['store_address']['v_status'] : '';
	$phone_status   = isset( $seller_profile['dokan_verification']['verified_info']['phone_status'] ) ? $seller_profile['dokan_verification']['verified_info']['phone_status'] : '';
	$phone_no       = isset( $seller_profile['dokan_verification']['verified_info']['phone'] ) ? $seller_profile['dokan_verification']['verified_info']['phone'] : '';

	$user_firstname = $user->user_firstname;
	$user_lastname = $user->user_lastname;
	$user_meta = get_user_meta ($user_id);
	$user_birthday = date_i18n( get_option( 'date_format' ), strtotime( get_user_meta( $user_id, 'user_birthday', true ) ) );

	$mango = mpAccess::getInstance();
	//var_dump($mango->get_mp_user($user_id));
	?>
 

 <!--<nav class="nav-infos-compte">
  <ul class="navbar-infos-compte">
    <li><a href="#infos_personnelles">Profil</a></li>
    <li><a href="#verification">Vérification du profil</a></li>
    <li><a href="#mes-adresses">Mes adresses</a></li>
    <li><a href="#infos-bancaires">Informations bancaires</a></li>
  </ul>
</nav>-->

  <?php

do_action( 'woocommerce_before_edit_account_form' ); ?>

<h1 style="text-align: center;">Mes informations</h1>

<div id="infos_personnelles" class="my-account-details">	
	<h2>Mes informations personnelles</h2>
		
	<div class="container-fluid">
			
			<div class="row" style="padding-bottom: 16px;">
				<div class="col-sm-12 no-padding-left">
					<?php
						if ( is_user_logged_in() ):
							$user_id = wp_get_current_user();

						if ( ($user_id instanceof WP_User) ) {
							echo get_avatar( $user_id->ID, 64 );
						}

						endif;
					?>

					<a href="/mon-compte/photo-profil" class="discreet_button" title="Modifier ma photo de profil">Modifier</a>
				</div>
			</div>
			
			<div class="row">
				<div class="col-sm-6 no-padding-left">
					<p>
						<strong>Pseudo (public) : </strong><?php echo esc_attr($user_meta['nickname'][0]); ?>
					</p>
				</div>
			
				<div class="col-sm-6 no-padding-left">
					<p>
						<strong>E-mail : </strong><?php echo esc_attr( $user->user_email ); ?>
					</p>
				</div>
			</div>
			
			<div class="row">
				<div class="col-sm-6 no-padding-left">
					<p>
						<strong>Prénom : </strong><?php echo esc_attr($user_firstname); ?>
					</p>
				</div>
			
				<div class="col-sm-6 no-padding-left">
					<p>
						<strong>Nom : </strong><?php echo esc_attr($user_lastname); ?>
					</p>
				</div>
			</div>
			
			<div class="row">
				<div class="col-sm-6 no-padding-left">
					<p>
						<strong>Date de naissance : </strong><?php echo esc_attr($user_birthday); ?>
					</p>	
				</div>
				
				<div class="col-sm-6 no-padding-left" >
					<p style="display: inline-block"><strong>Recevoir la lettre d'amour : </strong></p>
					<?php if ($user_meta['_mc4wp_review_notice_dismissed'][0] > 0) { 
						echo '
						<div id="oui-newsletter" style="display: inline-block;">
							<i style="color: #00DD03" class="fa fa-check" aria-hidden="true"></i> <p style="display: inline-block; ;">Yeah !</p>
						</div>';
	
						} else {
						echo '
						<div id="non-newsletter" style="display: inline-block;">
							<i style="color: #DD0003" class="fa fa-times" aria-hidden="true"></i> <p style="display: inline-block; ;">Non</p>
						</div>';
						} 
					?>
				</div>
			</div>
			
			<div class="row" style="margin-top: 20px;">
				<div class="col-sm-12 no-padding-left">
					<button type="button" class="btn btn-default .btn-sm btn-second" data-toggle="modal" data-target="#modif-infos">Modifier mes informations</button>	
				</div>
			</div>
		</div>
	
	<div id="modif-infos" class="modal fade" role="dialog">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Modifier mes informations</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div style="padding: 50px;" class="modal-body">
					
					<form class="woocommerce-EditAccountForm edit-account" action="" method="post">	
		
						<p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first">
							<label for="nickname"><?php _e('Pseudo', 'woocommerce'); ?> <span class="required">*</span> (public)</label>
							<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="nickname" id="nickname" value="<?php echo esc_attr($nickname); ?>"/>
						</p>

						<p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first form-row form-group type_account">
								<label class="radio">
									<input type="radio" id="individual" name="user_mp_status" value="individual" checked>
									<?php _e( 'I am an individual', 'dokan-lite' ); ?> 
								</label>

								<label class="radio">
									<input type="radio" id="professionnal" name="user_mp_status" value="professional">
									<?php _e( 'I am a professional', 'dokan-lite' ); ?> 
								</label>    
						</p>

						<p class="woocommerce-form-row woocommerce-form-row--last form-row form-row-last" id="type-entreprise" style="display:none;">
								<label for="type_professional">Type d'entreprise <span class="required">*</span></label>
								<select name="type_professional" id="type_professional" value="<?php echo $type_professional; ?>" class="regular-text">
								<option value="society" selected="selected">Societé</option>
								<option value="auto-entreprise">Auto-entreprise</option>
								<option value="association">Association</option>
								</select>
							</p>

						<p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first">
							<label for="billing_first_name"><?php _e( 'First name', 'woocommerce' ); ?> <span class="required">*</span></label>
							<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="billing_first_name" id="billing_first_name" value="<?php echo esc_attr( $user->first_name ); ?>" />
						</p>
						<p class="woocommerce-form-row woocommerce-form-row--last form-row form-row-last">
							<label for="billing_last_name"><?php _e( 'Last name', 'woocommerce' ); ?> <span class="required">*</span></label>
							<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="billing_last_name" id="billing_last_name" value="<?php echo esc_attr( $user->last_name ); ?>" />
						</p>
						<div class="clear"></div>

						<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
							<label for="account_email"><?php _e( 'Email address', 'woocommerce' ); ?> <span class="required">*</span></label>
							<input type="email" class="woocommerce-Input woocommerce-Input--email input-text" name="account_email" id="account_email" value="<?php echo esc_attr( $user->user_email ); ?>" />
						</p>

						<fieldset>
							<legend><?php _e( 'Password change', 'woocommerce' ); ?></legend>

							<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
								<label for="password_current"><?php _e( 'Current password (leave blank to leave unchanged)', 'woocommerce' ); ?></label>
								<input type="password" class="woocommerce-Input woocommerce-Input--password input-text" name="password_current" id="password_current" />
							</p>
							<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
								<label for="password_1"><?php _e( 'New password (leave blank to leave unchanged)', 'woocommerce' ); ?></label>
								<input type="password" class="woocommerce-Input woocommerce-Input--password input-text" name="password_1" id="password_1" />
							</p>
							<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
								<label for="password_2"><?php _e( 'Confirm new password', 'woocommerce' ); ?></label>
								<input type="password" class="woocommerce-Input woocommerce-Input--password input-text" name="password_2" id="password_2" />
							</p>
							
							<?php var_dump($user_meta['_mc4wp_review_notice_dismissed']) ?>
							<div class="onoffswitch">
								<input type="checkbox" name="mc4wp-subscribe" class="onoffswitch-checkbox" id="myonoffswitch" value="1" <?php if ($user_meta['_mc4wp_review_notice_dismissed'][0] > 0) { echo 'checked'; } ?>>
								<label class="onoffswitch-label" for="myonoffswitch">
									<span class="onoffswitch-inner"></span>
									<span class="onoffswitch-switch"></span>
								</label>
							</div>

						</fieldset>
					

						<?php do_action( 'woocommerce_edit_account_form' ); ?>


						<p>
							<?php wp_nonce_field( 'save_account_details' ); ?>
							<input type="submit" class="woocommerce-Button button" name="save_account_details" value="<?php esc_attr_e( 'Save changes', 'woocommerce' ); ?>" />
							<input type="hidden" name="action" value="save_account_details" />
						</p>

						<?php do_action( 'woocommerce_edit_account_form_end' ); ?>
					</form>
					
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
</div>

<div id="mes-adresses" class="my-account-details">
	<h2>Mes adresses</h2>
	<?php
	if ( ! defined( 'ABSPATH' ) ) {
		exit; // Exit if accessed directly
	}

	$customer_id = $user_id;

	if ( ! wc_ship_to_billing_address_only() && wc_shipping_enabled() ) {
		$get_addresses = apply_filters( 'woocommerce_my_account_get_addresses', array(
			'billing' => __( 'Billing address', 'woocommerce' ),
			'shipping' => __( 'Shipping address', 'woocommerce' ),
		), $user_id );
	} else {
		$get_addresses = apply_filters( 'woocommerce_my_account_get_addresses', array(
			'billing' => __( 'Billing address', 'woocommerce' ),
		), $user_id );
	}

	$oldcol = 1;
	$col    = 1;
	?>

	<p>
		<?php echo apply_filters( 'woocommerce_my_account_my_address_description', __( 'The following addresses will be used on the checkout page by default.', 'woocommerce' ) ); ?>
	</p>

	<?php if ( ! wc_ship_to_billing_address_only() && wc_shipping_enabled() ) : ?>
		<div class="u-columns woocommerce-Addresses col2-set addresses">
	<?php endif; ?>

	<?php foreach ( $get_addresses as $name => $title ) : ?>

		<div class="u-column<?php echo ( ( $col = $col * -1 ) < 0 ) ? 1 : 2; ?> col-<?php echo ( ( $oldcol = $oldcol * -1 ) < 0 ) ? 1 : 2; ?> woocommerce-Address">
			<header class="woocommerce-Address-title title">
				<h3><?php echo $title; ?></h3>
				<a href="<?php echo esc_url( wc_get_endpoint_url( 'edit-address', $name ) ); ?>" class="edit"><?php _e( 'Edit', 'woocommerce' ); ?></a>
			</header>
			<address><?php
				$address = wc_get_account_formatted_address( $name );
				echo $address ? wp_kses_post( $address ) : esc_html_e( 'You have not set up this type of address yet.', 'woocommerce' );
			?></address>
		</div>

	<?php endforeach; ?>

	<?php if ( ! wc_ship_to_billing_address_only() && wc_shipping_enabled() ) : ?>
		</div>
	<?php endif;?>
	
	<div class="row" style="margin-top: 20px;">
				<div class="col-sm-12 no-padding-left">
					<button type="button" class="btn btn-default .btn-sm btn-second" data-toggle="modal" data-target="#set-address-shipping">Modifier mes informations</button>	
				</div>
			</div>
	
	
	

	<div id="set-address-shipping" class="modal fade" role="dialog">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Modifier mes informations</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				
				<div style="padding: 50px;" class="modal-body">
				
					<?php 
					
					$load_address = 'billing';
					$page_title = 'Adresse de facturation'
					
					?>
					
					<?php $page_title = ( 'billing' === $load_address ) ? __( 'Billing address', 'woocommerce' ) : __( 'Shipping address', 'woocommerce' );
					
					var_dump( $load_address );
					var_dump( $page_title );


					 if ( ! $load_address ) : ?>
					
					<?php else : ?>

						<form method="post">

							<h3><?php echo apply_filters( 'woocommerce_my_account_edit_address_title', $page_title, $load_address ); ?></h3><?php // @codingStandardsIgnoreLine ?>

							<div class="woocommerce-address-fields">
								

								<div class="woocommerce-address-fields__field-wrapper">
								
								
									<?php
									
									
									
									echo $address['country_field'];
									
									foreach ( $address as $key => $field ) {
										if ( isset( $field['country_field'], $address[ $field['country_field'] ] ) ) {
											$field['country'] = wc_get_post_data_by_key( $field['country_field'], $address[ $field['country_field'] ]['value'] );
										}
										woocommerce_form_field( $key, $field, wc_get_post_data_by_key( $key, $field['value'] ) );
									}
									
									
									?>
									
									
								</div>

								<?php do_action( "woocommerce_after_edit_address_form_{$load_address}" ); ?>

								<p>
									<button type="submit" class="button" name="save_address" value="<?php esc_attr_e( 'Save address', 'woocommerce' ); ?>"><?php esc_html_e( 'Save address', 'woocommerce' ); ?></button>
									<?php wp_nonce_field( 'woocommerce-edit_address' ); ?>
									<input type="hidden" name="action" value="edit_address" />
								</p>
							</div>

						</form>

					<?php endif; ?>

					<?php do_action( 'woocommerce_after_edit_account_address_form' ); ?>
					
					
					
					
					
					
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>

	
</div>


<div id="verification" class="my-account-details">
	<h2>Vérification du profil</h2>
	
	<p>La vérification de votre profil sera visible sur votre <a style="color: #084399" target="_blank" href="<?php echo dokan_get_store_url( get_current_user_id() ); ?>">boutique en ligne</a>.</p>

	<div class="dokan-dashboard-wrap">
		<?php dokan_get_template( 'dashboard-nav.php', array( 'active_menu' => 'settings/verification' ) ); ?>

		<div class="dokan-dashboard-content dokan-verification-content">
		
			<?php
			if($dokan_Seller_Verification->e_msg) {
			?>
			<div class="dokan-alert dokan-alert-danger"><?php echo $dokan_Seller_Verification->e_msg; ?></div>
			<?php
			$dokan_Seller_Verification->e_msg = false;
			} ?>
			<div id="feedback" class=""></div>

			
			<?php

			$active_gateway     = dokan_get_option( 'active_gateway', 'dokan_verification_sms_gateways' );
			$active_gw_username = trim( dokan_get_option( $active_gateway . '_username', 'dokan_verification_sms_gateways' ) );
			$active_gw_pass     = trim( dokan_get_option( $active_gateway . '_pass', 'dokan_verification_sms_gateways' ) );

			if ( !empty( $active_gw_username ) || !empty( $active_gw_pass ) ) {
			?>
				<div class="dokan-panel dokan-panel-default dokan_v_phone">
					<div class="dokan-panel-heading">
						<strong><?php _e( 'Phone Verification', 'dokan' ); ?></strong>
					</div>

					<div class="dokan-panel-body">
						<div class="" id="d_v_phone_feedback"></div>

						<?php if ( $phone_status != 'verified' ) { ?>

							<div class="dokan_v_phone_box">
								<form method="post" id="dokan-verify-phone-form"  action="" class="dokan-form-horizontal">
									<?php wp_nonce_field( 'dokan_verify_action', 'dokan_verify_action_nonce' ); ?>
									<div class="dokan-form-group">
										<label class="dokan-w3 dokan-control-label" for="phone"><?php _e( 'Phone No', 'dokan' ); ?></label>
										<div class="dokan-w5">
											<input id="phone" value="<?php echo $phone; ?>" name="phone" placeholder="+123456.." class="dokan-form-control input-md" type="text">
										</div>

									</div>
									<div class="dokan-form-group">
										 <input type="submit" id='dokan_v_phone_submit' class="dokan-left dokan-btn dokan-btn-theme" value="<?php esc_attr_e( 'Submit', 'dokan' ); ?>">
									</div>
								</form>
							</div>

							<div class="dokan_v_phone_code_box dokan-hide">
								<form method="post" id="dokan-v-phone-code-form"  action="" class="dokan-form-horizontal">
									<?php wp_nonce_field( 'dokan_verify_action', 'dokan_verify_action_nonce' ); ?>

									<div class="dokan-form-group">
										<label class="dokan-w3 dokan-control-label" for="sms_code"><?php _e( 'SMS code', 'dokan' ); ?></label>
										<div class="dokan-w5">
											<input id="sms_code" value="" name="sms_code" placeholder="" class="dokan-form-control input-md" type="text">
										</div>
									</div>

									<div class="dokan-form-group">
										<input type="submit" id='dokan_v_code_submit' class="dokan-left dokan-btn dokan-btn-theme" value="<?php esc_attr_e( 'Submit', 'dokan' ); ?>">
									</div>
								</form>
							</div>

						<?php } elseif ( $phone_status === 'verified' ) { ?>

							<div class="dokan-alert dokan-alert-success">
								<p><?php _e('Your Verified Phone number is : ','dokan'); echo '<b>'.$phone_no.'</b>' ?></p>
							</div>

						<?php } ?>
					</div>
				</div>
			<?php } ?>

			<div class="dokan-panel dokan-panel-default">
				<div class="dokan-panel-heading clickable">
					<strong><?php _e( 'Social Profiles', 'dokan' ); ?></strong>
				</div>

				<div class="dokan-panel-body">
					<div class="dokan-verify-links">
						<?php

						$configured_providers = array();

						//facebook config from admin
						$fb_id     = dokan_get_option( 'fb_app_id', 'dokan_verification' );
						$fb_secret = dokan_get_option( 'fb_app_secret', 'dokan_verification' );
						if ( $fb_id != '' && $fb_secret != '' ) {
						   $configured_providers [] = 'facebook';
						}
						//google config from admin
						$g_id     = dokan_get_option( 'google_app_id', 'dokan_verification' );
						$g_secret = dokan_get_option( 'google_app_secret', 'dokan_verification' );
						if ( $g_id != '' && $g_secret != '' ) {
							$configured_providers [] = 'google';
						}
						//linkedin config from admin
						$l_id     = dokan_get_option( 'linkedin_app_id', 'dokan_verification' );
						$l_secret = dokan_get_option( 'linkedin_app_secret', 'dokan_verification' );
						if ( $l_id != '' && $l_secret != '' ) {
							$configured_providers [] = 'linkedin';
						}
						//Twitter config from admin
						$twitter_id     = dokan_get_option( 'twitter_app_id', 'dokan_verification' );
						$twitter_secret = dokan_get_option( 'twitter_app_secret', 'dokan_verification' );
						if ( $twitter_id != '' && $twitter_secret != '' ) {
							$configured_providers [] = 'twitter';
						}


						/**
						 * Filter the list of Providers connect links to display
						 *
						 * @since 1.0.0
						 *
						 * @param array $providers
						 */
						$providers = apply_filters( 'dokan_verify_provider_list', $configured_providers );
						$provider  = '';
						if ( !empty( $providers ) ) {
							foreach ( $providers as $provider ) {
								$provider_info = '';

								if ( isset( $seller_profile['dokan_verification'][$provider] ) ) {
									$provider_info = $seller_profile['dokan_verification'][$provider];
								}
								?>
								<?php if ( !isset( $provider_info ) || $provider_info == '' ) { ?>
									<a href="<?php echo add_query_arg( array( 'dokan_auth' => $provider ) ); ?>">
										<button class="btn btn-default .btn-sm btn-second">
											<?php
											_e( 'Connect ', 'dokan' );
											echo ucwords( $provider );
											?>
										</button>
									</a>
								<?php } else { ?>
									<div class="dokan-va-row">
										<div style="margin: 20px 0; background-color:#fafafa; padding: 10px" class="dokan-w12">
											<div class=""><h3><i class="fa fa-<?php echo strtolower( $provider ) ?>-square"></i> <?php echo ucwords( $provider ) ?></h3></div>
											<div class="">
												<div class="dokan-w4"><img style="border: solid 1px #515151;" src="<?php echo $provider_info['photoURL'] ?>"/></div>
												<div class="dokan-w8">
													<p style="display:inline-block">Nom d'utilisateur : </p>
													
													<a target="_blank" href="<?php echo $provider_info['profileURL'] ?>">
													
													<?php if ( $provider == 'twitter' ) { echo '@'; };
													
											  		echo $provider_info['displayName'] ?></a></div>
											  	
											  	<?php if ( !empty($provider_info['email']) ) {
														echo '<p style="display:inline-block">E-mail : </p>'; 
													}
											  	?>
												<div class="dokan-w8"><?php echo $provider_info['email'] ?></div>
											</div>

											<div class="dokan_verify_dc_button">
												<a href="<?php echo add_query_arg( array( 'dokan_auth_dc' => $provider ) ); ?>">
													<button class="discreet_button"><?php
														_e( 'Disconnect ', 'dokan' );
														echo ucwords( $provider );
														?>
													</button>
												</a>
											</div>
										</div>
									</div>
								<?php } ?>
							<?php } ?>
						<?php } else { ?>
							<div class="dokan-alert dokan-alert-info">
									<?php echo __( 'No Social App is configured by website Admin', 'dokan' ) ?>
							</div>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	
</div>

<div id="charte-bonne-conduite" class="my-account-details">
	<h2>Charte de bonne conduite</h2>
	<div class="container-fluid">
		<div class="row">
			<p style="display: inline-block">Charte de bonne conduite acceptée: </p>
				<?php 
					if ($user_meta['charte_bonne_conduite'][0] > 0) { 
						echo '<div id="non-newsletter" style="display: inline-block; margin-left: 5px;"><i style="color: #00DD03" class="fa fa-check" aria-hidden="true"></i> <p style="display: inline-block; ">Oui</p></div>'; 

					} else {
						echo '<div id="non-newsletter" style="display: inline-block; margin-left: 5px;"><i style="color: #DD0003" class="fa fa-times" aria-hidden="true"></i> <p style="display: inline-block;">Non</p></div>';
					} 
				?>	
		</div>
		
		<div class="row">
			<?php 
				if ($user_meta['charte_bonne_conduite'][0] > 0) { 
					echo '<a class="discret-link" href="#" title="Voir la charte"><i class="fa fa-eye" aria-hidden="true"></i> Voir la charte de bonne conduite</a>'; 

				} else {
					echo '<a class="discret-link" href="#" title="Signer la charte"><i class="fa fa-pencil" aria-hidden="true"></i> Signer la charte de bonne conduite</a>';
					} 
			?>
		</div>
	</div>		
</div>

<div id="infos-bancaires" class="my-account-details">
<h2>Mes informations bancaires</h2>
</div>

<div id="verification-mango" class="my-account-details">
	<h2>Vérification du profil mangopay</h2>

	<?php
	$mp = mpAccess::getInstance();
	$user_id = get_current_user_id();
	$mp_user_id = $mp->set_mp_user($user_id);

	if($mp->get_mp_user($mp_user_id)->KYCLevel == "REGULAR")
		echo '
		<div class="dokan-alert dokan-alert-success" id="d_v_address_feedback">
						Votre compte est verifié					</div>
		';
	else {
	?>
		<p>	Pour utiliser convenablement votre porte-feuille nous devons vérifier votre compte via Mangopay</p>
	<?php
		echo do_shortcode('[kyc_doc_user_infos]');

		echo do_shortcode('[kyc_doc_upload_form]');
	}
	?>
</div>



<div class="container-fluid">
	<div class="row" style="padding-bottom: 16px; padding-top: 20px;">
		<div class="col-sm-12 no-padding-left">
		
		<a class="btn btn-default .btn-sm btn-second" href="/desinscription" title="Me désinscrire">
			<i class="fa fa-trash" aria-hidden="true"></i> Supprimer mon compte
		</a>
		
		</div>
	</div>
</div>
		

<div >
	
	

</div>



