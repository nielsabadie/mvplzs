<nav class="nav-infos-compte">
  <ul class="navbar-infos-compte">
    <li><a href="#infos_personnelles">Profil</a></li>
    <li><a href="#verification">Vérification du profil</a></li>
    <li><a href="#mes-adresses">Mes adresses</a></li>
    <li><a href="#infos-bancaires">Informations bancaires</a></li>
  </ul>
</nav>

  <?php $user = wp_get_current_user();
	  $user_id = get_current_user_id();

	  $user_firstname = $user->user_firstname;
	  $user_lastname = $user->user_lastname;
	  $user_meta = get_user_meta ($user_id);
	$mango = mpAccess::getInstance();
	//var_dump($mango->get_mp_user($user_id));

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

do_action( 'woocommerce_before_edit_account_form' ); ?>

<div id="infos_personnelles" class="my-account-details">
	
	<h2>Mes informations personnelles</h2>
	
	<div class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
			<?php
				if ( is_user_logged_in() ):
					$current_user = wp_get_current_user();

				if ( ($current_user instanceof WP_User) ) {
					echo get_avatar( $current_user->ID, 64 );
				}
				endif;
			?>
			
    		<a href="/mon-compte/photo-profil" class="discreet_button" title="Modifier ma photo de profil">Modifier</a>
    	

    </div>
		
	<form class="woocommerce-EditAccountForm edit-account" action="" method="post">

		<?php do_action( 'woocommerce_edit_account_form_start' ); ?>
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

			               <input id="reg_billing_country" name="billing_country" type="hidden" value="FR">


		</fieldset>
		<div class="clear"></div>

		<?php do_action( 'woocommerce_edit_account_form' ); ?>
		<p>
			<label>
				<input type="checkbox" name="mc4wp-subscribe" value="1"
				<?php if ($user_meta['_mc4wp_review_notice_dismissed'][0] > 0) { echo 'checked'; } ?>/>
				Recevoir la lettre d'amour
			</label>
		</p>

		<p>
			<?php wp_nonce_field( 'save_account_details' ); ?>
			<input type="submit" class="woocommerce-Button button" name="save_account_details" value="<?php esc_attr_e( 'Save changes', 'woocommerce' ); ?>" />
			<input type="hidden" name="action" value="save_account_details" />
		</p>

		<?php do_action( 'woocommerce_edit_account_form_end' ); ?>
	</form>

	<?php do_action( 'woocommerce_after_edit_account_form' ); ?>
	
</div>

<div id="verification" class="my-account-details">
	<h2>Vérification du profil</h2>
	<p>La vérification de votre profil sera visible sur votre <a style="color: #084399" target="_blank" href="<?php echo dokan_get_store_url( get_current_user_id() ); ?>">boutique en ligne</a>.</p>
	
	<?php
	$dokan_Seller_Verification = Dokan_Seller_Verification::init();

	$current_user   = get_current_user_id();
	$seller_profile = dokan_get_store_info( $current_user );

	$gravatar       = isset( $seller_profile['dokan_verification']['info']['photo_id'] ) ? $seller_profile['dokan_verification']['info']['photo_id'] : 0;
	$phone          = isset( $seller_profile['dokan_verification']['info']['phone'] ) ? $seller_profile['dokan_verification']['info']['phone'] : '';
	$address        = isset( $seller_profile['dokan_verification']['info']['address'] ) ? $seller_profile['dokan_verification']['info']['address'] : '';
	$id_type        = isset( $seller_profile['dokan_verification']['info']['dokan_v_id_type'] ) ? $seller_profile['dokan_verification']['info']['dokan_v_id_type'] : 'passport';
	$id_type        = ( $id_type != '' ) ? $id_type : 'passport';
	$id_status      = isset( $seller_profile['dokan_verification']['info']['dokan_v_id_status'] ) ? $seller_profile['dokan_verification']['info']['dokan_v_id_status'] : '';
	$address_status = isset( $seller_profile['dokan_verification']['info']['store_address']['v_status'] ) ? $seller_profile['dokan_verification']['info']['store_address']['v_status'] : '';

	$phone_status   = isset( $seller_profile['dokan_verification']['verified_info']['phone_status'] ) ? $seller_profile['dokan_verification']['verified_info']['phone_status'] : '';
	$phone_no       = isset( $seller_profile['dokan_verification']['verified_info']['phone'] ) ? $seller_profile['dokan_verification']['verified_info']['phone'] : '';


	?>

	<div class="dokan-dashboard-wrap">
		<?php dokan_get_template( 'dashboard-nav.php', array( 'active_menu' => 'settings/verification' ) ); ?>

		<div class="dokan-dashboard-content dokan-verification-content">
			<header class="dokan-dashboard-header">
				<!--<h1 class="entry-title">
					<?php// _e( 'Verification', 'dokan' ); ?>

					<small>&rarr; <a href="<?php// echo dokan_get_store_url( get_current_user_id() ); ?>"><?php// _e( 'Visit Store', 'dokan' ); ?></a></small>
				</h1>-->
			</header>
			<?php
			if($dokan_Seller_Verification->e_msg) {
			?>
			<div class="dokan-alert dokan-alert-danger"><?php echo $dokan_Seller_Verification->e_msg; ?></div>
			<?php
			$dokan_Seller_Verification->e_msg = false;
			} ?>
			<div id="feedback" class=""></div>

			<div class="dokan-panel dokan-panel-default dokan_v_id" id="dokan_v_id">
				<div class="dokan-panel-heading">
					<strong><?php _e( 'ID Verification', 'dokan' ); ?></strong>
				</div>

				<div class="dokan-panel-body">
					<?php
					if ( $id_status != '' ) {
						$alert_class = 'dokan-alert-info';
						$cancel_btn_class = '';

						switch ( $id_status ) {
							case 'approved' :
								$alert_class = 'dokan-alert-success';
								$cancel_btn_class = 'dokan-hide';
								break;

							case 'rejected' :
								$alert_class = 'dokan-alert-danger';
								$cancel_btn_class = 'dokan-hide';
								break;

							case 'pending' :
								$alert_class = 'dokan-alert-warning';
								break;
						}
						?>
						<div class="dokan-alert <?php echo $alert_class ?>" id="dokan_v_id_feedback">
							<?php echo sprintf( __( 'Your ID verification request is %s', 'dokan' ), $id_status ); ?>
						</div>
					<?php } ?>

					<?php


					if ( $id_status == 'rejected' || $id_status == '' )
						$id_btn_class = '';
					else
						$id_btn_class = 'dokan-hide';

					?>

					<button class="dokan-btn dokan-btn-theme dokan-v-start-btn <?php echo esc_attr($id_btn_class)?>" id="dokan_v_id_click"><?php _e( 'Start Verification', 'dokan' ); ?></button>


					<div class="dokan_v_id_info_box dokan-hide">
							<form method="post" id="dokan-verify-id-form"  action="" class="dokan-form-horizontal">

								<h4><?php _e( 'Select ID type :', 'dokan' ); ?></h4>

								<label class="radio">
									<input type="radio" name="dokan_v_id_type" value="passport" <?php checked( $id_type, 'passport' ) ?> >
									<?php _e( 'Passport', 'dokan' ); ?>
								</label>

								<label class="radio">
									<input type="radio" name="dokan_v_id_type" value="national_id" <?php checked( $id_type, 'national_id' ) ?>>
									<?php _e( 'National ID Card', 'dokan' ); ?>
								</label>

								<label class="radio">
									<input type="radio" name="dokan_v_id_type" value="driving_license" <?php checked( $id_type, 'driving_license' ) ?>>
									<?php _e( 'Driving License', 'dokan' ); ?>
								</label>

								<div class="dokan-form-group dokan-verify-photo-id">
									<div class="dokan-w5 dokan-gravatar">
										<div class="dokan-left gravatar-wrap<?php echo $gravatar ? '' : ' dokan-hide'; ?>">
											<?php $gravatar_url = $gravatar ? wp_get_attachment_url( $gravatar ) : ''; ?>
											<input type="hidden" class="dokan-file-field" value="<?php echo $gravatar; ?>" name="dokan_gravatar">
											<img class="dokan-gravatar-img" src="<?php echo esc_url( $gravatar_url ); ?>">
											<a class="dokan-close dokan-remove-gravatar-image">&times;</a>
										</div>

										<div class="gravatar-button-area<?php echo $gravatar ? ' dokan-hide' : ''; ?>">
											<a href="#" class="dokan-gravatar-drag dokan-btn dokan-btn-default"><i class="fa fa-cloud-upload"></i> <?php _e( 'Upload Photo', 'dokan' ); ?></a>
										</div>

										<?php wp_nonce_field( 'dokan_verify_action', 'dokan_verify_action_nonce' ); ?>
										<input type="submit" id='dokan_v_id_submit' class="dokan-btn dokan-btn-theme" value="<?php esc_attr_e( 'Submit', 'dokan' ); ?>">
										<input type="button" id='dokan_v_id_cancel_form' class="dokan-btn dokan-btn-theme dokan-v-cancel-btn" value="<?php esc_attr_e( 'Cancel', 'dokan' ); ?>">

									</div>
								</div>
							</form>
					</div>
					<?php
					if ( !$id_status == 'pending' ) {
						$cancel_btn_class = 'dokan-hide';
					}
					?>
					<button class="dokan-btn dokan-btn-theme <?php echo esc_attr($cancel_btn_class); ?>" id="dokan_v_id_cancel"><?php _e( 'Cancel Request', 'dokan' ); ?></button>
				</div>
			</div>
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

			<?php
			// Extract Variables
			if ( !isset( $seller_profile['store_address'] ) ) {
				$seller_profile['store_address']['street_1']      = '';
				$seller_profile['store_address']['street_2']      = '';
				$seller_profile['store_address']['city']    = '';
				$seller_profile['store_address']['zip']     = '';
				$seller_profile['store_address']['country'] = '';
				$seller_profile['store_address']['state']   = '';
				$seller_profile['store_address']['dokan-v-state']   = array(
					'' => array( '' ),
				);
			}

			if ( isset( $seller_profile['dokan_verification']['info']['store_address'] ) ) {
				$seller_profile['store_address'] = $seller_profile['dokan_verification']['info']['store_address'];
			}

			extract( $seller_profile['store_address'] );

			$dv_street_1 = isset( $street_1 ) ? $street_1 : '';
			$dv_street_2 = isset( $street_2 ) ? $street_2 : '';
			$dv_city     = isset( $store_city ) ? $store_city : '';
			$dv_zip      = isset( $store_zip ) ? $store_zip : '';
			$country_id  = isset( $store_country ) ? $store_country : '';

			$state_id    = isset( $dokan_v_state[$country_id][0] ) ? isset( $dokan_v_state[$country_id][0] ) : '';

			?>

			<div class="dokan-panel dokan-panel-default">
				<div class="dokan-panel-heading">
					<strong><?php _e( 'Address Verification', 'dokan' ); ?></strong>
				</div>

				<div class="dokan-panel-body">
					<?php
					$alert_class = 'dokan-hide';
					$cancel_btn_class = '';
					if ( $address_status != '' ) {
						$alert_class = 'dokan-alert-info';

						switch ( $address_status ) {
							case 'approved' :
								$alert_class = 'dokan-alert-success';
								$cancel_btn_class = 'dokan-hide';
								break;
							case 'rejected' :
								$alert_class = 'dokan-alert-danger';
								$cancel_btn_class = 'dokan-hide';
								break;
							case 'pending' :
								$alert_class = 'dokan-alert-warning';
								break;
						}
					} ?>


					<div class="dokan-alert <?php echo $alert_class ?>" id="d_v_address_feedback">
						<?php echo sprintf( __( 'Your Address verification request is %s', 'dokan' ), $address_status ); ?>
					</div>

					<?php
					$addrs_btn_class = 'dokan-hide';

					if ( $address_status == 'rejected' || $address_status == '' ) {
						$addrs_btn_class = '';
					}
					?>
					<?php
					$btn_name = __( 'Start Verification', 'dokan' );
					if ( $address_status == 'approved' ) {

						$btn_name = __( 'Change Address', 'dokan' );
						$addrs_btn_class = '';

					} ?>
					<button class="dokan-btn dokan-btn-theme dokan-v-start-btn <?php echo esc_attr($addrs_btn_class); ?>" id="dokan_v_address_click"><?php echo $btn_name; ?></button>

						<div class="dokan_v_address_box dokan-hide">
							<form method="post" id="dokan-verify-address-form"  action="" class="dokan-form-horizontal">
								<?php dokan_seller_address_fields( false, true ); ?>

								<div class="dokan-form-group">
									<input type="submit" id='dokan_v_address_submit' class="dokan-left dokan-btn dokan-btn-theme" value="<?php esc_attr_e( 'Submit', 'dokan' ); ?>">
									<input type="button" id='dokan_v_address_cancel' class="dokan-left dokan-btn dokan-btn-theme" value="<?php esc_attr_e( 'Cancel', 'dokan' ); ?>">
									<input type="hidden" name="action" value="dokan_update_verify_info_insert_address" />
									<?php wp_nonce_field( 'dokan_verify_action_address_form', 'dokan_verify_action_address_form_nonce' ); ?>
								</div>
							</form>
						</div>
					<?php

					if ( !$address_status == 'pending' ) {
						$cancel_btn_class = 'dokan-hide';
					}
					?>
					<button class="btn btn-primary <?php echo esc_attr($cancel_btn_class); ?>" id="dokan_v_address_cancel"><?php _e( 'Cancel Request', 'dokan' ); ?></button>

				</div>
			</div>

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
										<button class="btn btn-primary">
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
</div>


<div id="infos-bancaires" class="my-account-details">
<h2>Mes informations bancaires</h2>
<?php 
$instance_dokan_infos = new Dokan_Template_Settings ();
$call_payment_content = $instance_dokan_infos->load_payment_content();?>

<?php do_action( 'dokan_payment_settings_before_form', $current_user, $profile_info ); ?>

<form method="post" id="payment-form"  action="" class="dokan-form-horizontal">

    <?php wp_nonce_field( 'dokan_payment_settings_nonce' ); ?>

    <?php foreach ( $methods as $method_key ) {
        $method = dokan_withdraw_get_method( $method_key );
        ?>
        <fieldset class="payment-field-<?php echo $method_key; ?>">
            <div class="dokan-form-group">
                <label class="dokan-w3 dokan-control-label" for="dokan_setting"><?php echo $method['title'] ?></label>
                <div class="dokan-w6">
                    <?php if ( is_callable( $method['callback'] ) ) {
                        call_user_func( $method['callback'], $profile_info );
                    } ?>
                </div> <!-- .dokan-w6 -->
            </div>
        </fieldset>
    <?php } ?>

    <?php
   
/**
 * @since 2.2.2 Insert action after social settings form
 */
do_action( 'dokan_payment_settings_after_form', $current_user, $profile_info ); ?>
</form>

</div>


<div id="delete-account">
	
	<div><a class="btn btn-primary" href="/desinscription" title="Me désinscrire"><i class="fa fa-trash" aria-hidden="true"></i> Supprimer mon compte</a></div>

</div>



