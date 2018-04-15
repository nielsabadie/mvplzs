<?php if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$dokan_Seller_Verification = Dokan_Seller_Verification::init();

$user = wp_get_current_user();
//var_dump($user->data);
$user_id = get_current_user_id();
$seller_profile = dokan_get_store_info( $user_id );
$user_data = get_userdata ($user_id);
$user_meta = get_user_meta ($user_id);

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
$user_nicename =  $user->user_nicename;

//var_dump($user_meta);


$user_pass = $user_data->user_pass;
//var_dump($user_data);
$user_birthday = date_i18n( get_option( 'date_format' ), strtotime( get_user_meta( $user_id, 'user_birthday', true ) ) );
$user_phone = $user_meta['billing_phone'][0];
$mango = mpAccess::getInstance();
//var_dump($mango->get_mp_user($user_id));
?>

<?php

do_action( 'woocommerce_before_edit_account_form' ); ?>

<div id="infos_personnelles" class="my-account-details">


	<?php
	//var_dump(get_template_directory_uri());
	//var_dump(get_user_meta($user_id));
	//var_dump(get_userdata ($user_id));
	//var_dump($user);
	//var_dump($user_data);		
	//print_r($user_meta);

	?>

	<h2 id="mes-infos">Mes informations personnelles</h2>



	<div class="container-fluid" id="mes-infos-list">

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
					<strong>Pseudo (public) : </strong><span id="user_pseudo"><?php echo esc_attr( $user->display_name ); ?></span>
				</p>
			</div>

			<div class="col-sm-6 no-padding-left">
				<p>
					<strong>E-mail : </strong><span id="user_email"><?php echo esc_attr( $user->user_email ); ?></span>
				</p>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-6 no-padding-left">
				<p>
					<strong>Prénom : </strong></strong><span id="user_first_name"><?php echo esc_attr($user_firstname); ?></span>
				</p>
			</div>

			<div class="col-sm-6 no-padding-left">
				<p>
					<strong>Nom : </strong><span id="user_last_name"><?php echo esc_attr($user_lastname); ?></span>
				</p>
			</div>

			<div class="col-sm-6 no-padding-left">
				<p>
					<strong>Téléphone : </strong><span id="billing_phone"><?php echo esc_attr($user_phone); ?></span>
				</p>
			</div>

			<div class="col-sm-6 no-padding-left">
				<p>
					<strong>Date de naissance : </strong><?php echo esc_attr($user_birthday); ?>
				</p>
			</div>

			<div class="col-sm-6 no-padding-left">
				<p>
					<strong>Mot de passe : </strong><span id="user_password">**********</span> <i class="fa fa-cogs link-label-luzus" data-toggle="modal" data-target="#set_password" id="set_new_password"></i>
				</p>
			</div>

			<div class="modal fade" id="set_password" role="dialog">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">Modifier mon mot de passe</h4>
						</div>
						<div class="modal-body">
							<div class="container">
								<form id="edit_password_form" method="POST">
									<div class="form-group">
										<label for="old_password">Mot de passe actuel</label>
										<div class="input-group">
											<input type="password" class="form-control" id="old_password">
										</div>
									</div>

									<div class="form-group">
										<label for="password">Nouveau mot de passe</label>
										<div class="input-group">
											<input type="password" name="password" class="form-control" id="password"  />
											<div class="icon-wrapper">
												<span toggle="#password" class="input-group-addon fa fa-eye field-icon toggle-password"></span>
											</div>
											<div class="password-wrapper">
												<div class="strength-lines">
													<div class="line"></div>
													<div class="line"></div>
													<div class="line"></div>
												</div>
											</div>
										</div>
									</div>

									<div class="form-group">
										<label for="confirm_password">Ressaisir le nouveau mot de passe</label>
										<div class="input-group">
											<input type="password" name="confirm_password" class="form-control"  id="confirm_password" />
										</div>
										<div id="alert_password"></div>
									</div>

									<div class="row">
										<div class="col-md-12" style="margin-top: 10px">
											<input type="submit" class="btn btn-default" value="Enregistrer" />
										</div>
									</div>

									<div class="row">
										<div class="col-md-12">
											<div id="banner-edit-password" class="alert" style="display: none; margin-top: 30px">
											</div>
										</div>
									</div>
								</form>
							</div>
						</div>

						<div class="modal-footer">
							<button type="button" class="btn btn-default .btn-sm btn-second" data-dismiss="modal">Annuler</button>
						</div>
					</div>
				</div>
			</div>

			<div style="margin-bottom: 30px; margin-top: 10px; background-color: #fafafa; padding:20px" class="col-sm-12 no-padding-left">
				<p><strong>À propos de moi (public) : </strong></p>
				<blockquote>
					<p><span id="user_description"><?php if (!empty($user_meta['user_description'][0])) { echo esc_attr($user_meta['user_description'][0]); } else { echo 'Vous n\'avez pas d\'histoire à nous raconter ? 🙀'; } ?></span></p>
				</blockquote>
			</div>


			<div class="col-sm-6 no-padding-left" >
				<p style="display: inline-block"><strong>Recevoir la lettre d'amour : </strong></p>
					
					<span id="user_newsletter">
						<?php
						//var_dump($user_meta['_mc4wp_review_notice_dismissed'] );

						if ($user_meta['_mc4wp_review_notice_dismissed'][0] > 0) {
							echo '
							<div id="oui-newsletter" style="display: inline-block;">
								<i style="color: #5BDDB9" class="fa fa-check" aria-hidden="true"></i> <p style="display: inline-block; ;">Yeah !</p>
							</div>';

						} else {
							echo '
							<div id="non-newsletter" style="display: inline-block;">
								<i style="color: #DD0003" class="fa fa-times" aria-hidden="true"></i> <p style="display: inline-block; ;">Non</p>
							</div>';
						}
						?>
					</span>
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

					<form id="edit_account_form" method="POST">

						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="user_nicename">Pseudo* <small>(public)</small></label>
									<input type="text" class="form-control" name="user_nicename" id="user_nicename" value="<?php echo esc_attr( $user->display_name ); ?>" required />
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group">
									<label for="user_email">E-mail*</label>
									<input type="email" class="form-control" name="user_email" id="user_email" value="<?php echo esc_attr( $user->user_email ); ?>" required/>
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group">
									<label for="first_name">Prénom*</label>
									<input type="text" class="form-control" name="first_name" id="first_name" value="<?php echo esc_attr( $user->first_name ); ?>" required/>
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group">
									<label for="last_name">Nom*</label>
									<input type="text" class="form-control" name="last_name" id="last_name" value="<?php echo esc_attr( $user->last_name ); ?>" required/>
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group">
									<label for="billing_phone">Téléphone</label>
									<input type="tel" class="form-control" name="billing_phone" id="billing_phone" value="<?php echo esc_attr( $user_phone ); ?>"/>
								</div>
							</div>

							<div class="col-md-12">
								<div class="form-group">
									<label for="user_description">À propos de moi <small>(public)</small></label>
									<textarea id="user_description" class="form-control" rows="5" maxlength="200"><?php echo esc_attr( $user_meta['user_description'][0] );?></textarea>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-12" style="margin-top: 10px">
								<div class="form-group">
									<?php// var_dump($user_meta['_mc4wp_review_notice_dismissed'][0] > 0) ?>
									<p style="display: inline-block; vertical-align: middle; margin-bottom: 0;">Recevoir la lettre d'amour :</p>


									<div class="btn-mes-infos">
										<input type="radio" name="mc4wp" value="1" <?php if ($user_meta['_mc4wp_review_notice_dismissed'][0] > 0) { echo 'checked'; } ?> id="button_yes" />
										<label for="button_yes">Oui</label>

										<input type="radio" name="mc4wp" value="0" <?php if ($user_meta['_mc4wp_review_notice_dismissed'][0] < 1) { echo 'checked'; } ?> id="button_no" />
										<label for="button_no">Non</label>
									</div>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-12" style="margin-top: 10px">
								<input type="submit" class="btn btn-default" value="Enregistrer" />
							</div>
						</div>

						<div class="row">
							<div class="col-md-12">
								<div id="banner-edit-account" class="alert" style="display: none; margin-top: 30px">
								</div>
							</div>
						</div>
					</form>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-default .btn-sm btn-second" data-dismiss="modal">Annuler</button>
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

					<a class="link-label-luzus" data-toggle="modal" data-target="<?php echo ($name == 'billing') ? '#billing-address' : (($name == 'shipping') ? '#shipping-address' : '#') ?>" class="edit">
						<?php _e( 'Edit', 'woocommerce' ); ?>
					</a>

				</header>
				<?php
				$address = wc_get_account_formatted_address( $name );
				if ($address == NULL) {
					esc_html_e( 'You have not set up this type of address yet.', 'woocommerce' );
				} else {

					if ($name == 'billing') {

						?>
						<div class="col-sm-6 no-padding-left">
							<ul style="margin-left: 0;">
								<li style="list-style: none;">
									<strong><span id="billing_first_name"><?php echo esc_attr( $user_meta["billing_first_name"][0] ); ?></span> <span id="billing_last_name"><?php echo esc_attr( $user_meta["billing_last_name"][0] ); ?></span></strong>
								</li>
								<li style="list-style: none;">
									<span id="billing_address_1"><?php echo esc_attr( $user_meta["billing_address_1"][0] ); ?></span>
								</li>
								<li style="list-style: none;">
									<span id="billing_address_2"><?php echo esc_attr( $user_meta["billing_address_2"][0] ); ?></span>
								</li>
								<li style="list-style: none;">
									<span id="billing_postcode"><?php echo esc_attr( $user_meta["billing_postcode"][0] ); ?></span> <span id="billing_city"><?php echo esc_attr( $user_meta["billing_city"][0] ); ?></span>
								</li>
							</ul>
						</div>
						<?php

					} elseif ($name == 'shipping') {
						?>
						<div class="col-sm-6 no-padding-left">
							<ul style="margin-left: 0;">
								<li style="list-style: none;">
									<strong><span id="shipping_first_name"><?php echo esc_attr( $user_meta["shipping_first_name"][0] ); ?></span> <span id="shipping_last_name"><?php echo esc_attr( $user_meta["shipping_last_name"][0] ); ?></span></strong>
								</li>
								<li style="list-style: none;">
									<span id="shipping_address_1"><?php echo esc_attr( $user_meta["shipping_address_1"][0] ); ?></span>
								</li>
								<li style="list-style: none;">
									<span id="shipping_address_2"><?php echo esc_attr( $user_meta["shipping_address_2"][0] ); ?></span>
								</li>
								<li style="list-style: none;">
									<span id="shipping_postcode"><?php echo esc_attr( $user_meta["shipping_postcode"][0] ); ?></span> <span id="shipping_city"><?php echo esc_attr( $user_meta["shipping_city"][0] ); ?></span>
								</li>
							</ul>
						</div>
						<?php

					} else {
						return;
					}
				}
				?>


			</div>

		<?php endforeach; ?>

		<?php if ( ! wc_ship_to_billing_address_only() && wc_shipping_enabled() ) : ?>
	</div>
<?php endif;?>

	<div id="billing-address" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Mon adresse de facturation</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div style="padding: 50px;" class="modal-body">

					<form id="edit_billing_address_form" method="POST">

						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="billing_first_name">Prénom*</label>
									<input type="text" class="form-control" name="billing_first_name" id="billing_first_name" value="<?php echo esc_attr( $user_meta["billing_first_name"][0] ); ?>" required />
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group">
									<label for="billing_last_name">Nom*</label>
									<input type="text" class="form-control" name="billing_last_name" id="billing_last_name" value="<?php echo esc_attr( $user_meta["billing_last_name"][0] ); ?>" required />
								</div>
							</div>

							<div class="col-md-12">
								<div class="form-group">
									<label for="billing_address_1">Addresse ligne 1*</label>
									<input type="text" class="form-control" name="billing_address_1" id="billing_address_1" value="<?php echo esc_attr( $user_meta["billing_address_1"][0] ); ?>" required />
								</div>
							</div>

							<div class="col-md-12">
								<div class="form-group">
									<label for="billing_address_2">Addresse ligne 2</label>
									<input type="text" class="form-control" name="billing_address_2" id="billing_address_2" value="<?php echo esc_attr( $user_meta["billing_address_2"][0] ); ?>" />
								</div>
							</div>

							<div class="col-md-4">
								<div class="form-group">
									<label for="billing_postcode">Code postal*</label>
									<input type="text" class="form-control" name="billing_postcode" id="billing_postcode" value="<?php echo esc_attr( $user_meta["billing_postcode"][0] ); ?>" required/>
								</div>
							</div>

							<div class="col-md-8">
								<div class="form-group">
									<label for="billing_city">Ville*</label>
									<input type="text" class="form-control" name="billing_city" id="billing_city" value="<?php echo esc_attr( $user_meta["billing_city"][0] ); ?>" required/>
								</div>
							</div>

						</div>

						<div class="row">
							<div class="col-md-12" style="margin-top: 10px">
								<input type="submit" class="btn btn-default" value="Enregistrer" />
							</div>
						</div>

						<div class="row">
							<div class="col-md-12">
								<div id="banner-edit-billing" class="alert" style="display: none; margin-top: 30px">
								</div>
							</div>
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default .btn-sm btn-second" data-dismiss="modal">Annuler</button>
				</div>
			</div>
		</div>
	</div>

	<div id="shipping-address" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Mon adresse de livraison</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div style="padding: 50px;" class="modal-body">

					<form id="edit_shipping_address_form" method="POST">

						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="shipping_first_name">Prénom*</label>
									<input type="text" class="form-control" name="shipping_first_name" id="shipping_first_name" value="<?php echo esc_attr( $user_meta["shipping_first_name"][0] ); ?>" required />
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group">
									<label for="shipping_last_name">Nom*</label>
									<input type="text" class="form-control" name="shipping_last_name" id="shipping_last_name" value="<?php echo esc_attr( $user_meta["shipping_last_name"][0] ); ?>" required />
								</div>
							</div>

							<div class="col-md-12">
								<div class="form-group">
									<label for="shipping_address_1">Addresse ligne 1*</label>
									<input type="text" class="form-control" name="shipping_address_1" id="shipping_address_1" value="<?php echo esc_attr( $user_meta["shipping_address_1"][0] ); ?>" required />
								</div>
							</div>

							<div class="col-md-12">
								<div class="form-group">
									<label for="shipping_address_2">Addresse ligne 2</label>
									<input type="text" class="form-control" name="shipping_address_2" id="shipping_address_2" value="<?php echo esc_attr( $user_meta["shipping_address_2"][0] ); ?>" />
								</div>
							</div>

							<div class="col-md-4">
								<div class="form-group">
									<label for="shipping_postcode">Code postal*</label>
									<input type="text" class="form-control" name="shipping_postcode" id="shipping_postcode" value="<?php echo esc_attr( $user_meta["shipping_postcode"][0] ); ?>" required />
								</div>
							</div>

							<div class="col-md-8">
								<div class="form-group">
									<label for="shipping_city">Ville*</label>
									<input type="text" class="form-control" name="shipping_city" id="shipping_city" value="<?php echo esc_attr( $user_meta["shipping_city"][0] ); ?>" required/>
								</div>
							</div>

						</div>

						<div class="row">
							<div class="col-md-12" style="margin-top: 10px">
								<input type="submit" class="btn btn-default" value="Enregistrer" />
							</div>
						</div>

						<div class="row">
							<div class="col-md-12">
								<div id="banner-edit-shipping" class="alert" style="display: none; margin-top: 30px">
								</div>
							</div>
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default .btn-sm btn-second" data-dismiss="modal">Annuler</button>
				</div>
			</div>
		</div>
	</div>



</div>

<div id="verification" class="my-account-details">
	<h2>Vérification du profil</h2>

	<p>La vérification de votre profil sera visible sur votre <a style="color: #084399" target="_blank" href="<?php echo dokan_get_store_url( get_current_user_id() ); ?>">boutique</a>.</p>

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

	<?php
	$mp = mpAccess::getInstance();
	$user_id = get_current_user_id();
	$mp_user_id = $mp->set_mp_user($user_id);

	if ( $mp_user_id ) {


		if($mp->get_mp_user($mp_user_id)->KYCLevel == "REGULAR") {
			echo '
		<div class="dokan-alert dokan-alert-success" id="d_v_address_feedback">
			Votre compte est verifié
		</div>
		';

		} else {

			?>
			<p>	Pour utiliser convenablement votre porte-feuille nous devons vérifier votre compte via Mangopay</p>
			<?php
			echo do_shortcode('[kyc_doc_user_infos]');

			echo do_shortcode('[kyc_doc_upload_form]');
		}
	} ?>

</div>

<!--<div id="charte-bonne-conduite" class="my-account-details">
	<h2>Charte de bonne conduite</h2>
	<div class="container-fluid">
		<div class="row">
			<p style="display: inline-block">Charte de bonne conduite acceptée: </p>
			<?php/*
			if ($user_meta['charte_bonne_conduite'][0] > 0) {
				echo '<div id="non-newsletter" style="display: inline-block; margin-left: 5px;"><i style="color: #00DD03" class="fa fa-check" aria-hidden="true"></i> <p style="display: inline-block; ">Oui</p></div>';

			} else {
				echo '<div id="non-newsletter" style="display: inline-block; margin-left: 5px;"><i style="color: #DD0003" class="fa fa-times" aria-hidden="true"></i> <p style="display: inline-block;">Non</p></div>';
			}*/
			?>
		</div>

		<div class="row">
			<?php/*
			if ($user_meta['charte_bonne_conduite'][0] > 0) {
				echo '<a class="discret-link" href="#" title="Voir la charte"><i class="fa fa-eye" aria-hidden="true"></i> Voir la charte de bonne conduite</a>';

			} else {
				echo '<a class="discret-link" href="#" title="Signer la charte"><i class="fa fa-pencil" aria-hidden="true"></i> Signer la charte de bonne conduite</a>';
			}*/
			?>
		</div>
	</div>
</div>-->

<div id="infos-bancaires" class="my-account-details">
	<h2>Mes informations bancaires</h2>

	<?php
	$mp = mpAccess::getInstance();
	$user_id = get_current_user_id();
	$mp_user_id = $mp->set_mp_user($user_id);

	if ( $mp_user_id ) {

		//$bankAccounts = $mp->mangoPayApi->Users->GetBankAccounts( $mp_user_id);
		//var_dump($bankAccounts);

		$iban = $mp->get_bank_account($mp_user_id)[0];
	} ?>

	<div class="container-fluid" id="mes-infos-list">
		<div class="row">
			<div class="col-sm-12 no-padding-left">
				<p>
					<strong>Nom : </strong></strong><span id="user_first_name"><?php echo $iban->OwnerName ?></span>
				</p>
			</div>

			<div class="col-sm-6 no-padding-left">
				<p>
					<strong>Adresse ligne 1 : </strong><span id="user_last_name"><?php echo $iban->OwnerAddress->AddressLine1 ?></span>
				</p>
				
			</div>

			<div class="col-sm-6 no-padding-left">
				<p>
					<strong>Adresse ligne 2 : </strong><span id="user_last_name"><?php echo $iban->OwnerAddress->AddressLine2 ?></span>
				</p>
			</div>

			<div class="col-sm-6 no-padding-left">
				<p>
					<strong>Code Postal : </strong><span id="user_last_name"><?php echo $iban->OwnerAddress->PostalCode ?></span>
				</p>
			</div>

			<div class="col-sm-6 no-padding-left">
				<p>
					<strong>Ville : </strong><span id="user_last_name"><?php echo $iban->OwnerAddress->City ?></span>
				</p>
			</div>

			<div class="col-sm-12 no-padding-left">
				<p>
					<strong>IBAN : </strong><span id="billing_phone"><?php echo $iban->Details->IBAN?></span>
				</p>
			</div>

			<div class="col-sm-12 no-padding-left">
				<p>
					<strong>BIC : </strong><?php echo $iban->Details->BIC ?>
				</p>
			</div>
		</div>
	</div>

	<div class="row" style="margin-top: 20px;">
		<div class="col-sm-12 no-padding-left">
			<button type="button" class="btn btn-default .btn-sm btn-second" data-toggle="modal" data-target="#modif-infos-bank"><?php echo $iban ? "Modifier" : "Ajouter"?> mes informations bancaires</button>
		</div>

	</div>

	<div id="modif-infos-bank" class="modal fade" role="dialog">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Modifier mes informations</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div style="padding: 50px;" class="modal-body">
<!--					<form method="post">-->
<!--
					<?php /*do_action("wcvendors_settings_after_paypal");*/?>

					--><?php /*do_action("wcvendors_shop_settings_saved") ;*/?>

					<form id="edit_bank_form" method="POST">
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label for="user_bank_name">Nom</label>
									<input type="tel" class="form-control" name="user_bank_name" id="user_bank_name" value="<?php echo $iban->OwnerName ?>"/>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="user_bank_adress_f">Adresse 1* <small>(public)</small></label>
									<input type="text" class="form-control" name="user_bank_adress_f" id="user_bank_adress_f" value="<?php echo $iban->OwnerAddress->AddressLine1 ?>" required />
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group">
									<label for="user_bank_adress_s">Adresse 2*</label>
									<input type="text" class="form-control" name="user_bank_adress_s" id="user_bank_adress_s" value="<?php echo $iban->OwnerAddress->AddressLine2 ?>" required/>
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group">
									<label for="user_bank_postal">Code postal*</label>
									<input type="text" class="form-control" name="user_bank_postal" id="user_bank_postal" value="<?php echo $iban->OwnerAddress->PostalCode ?>" required/>
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group">
									<label for="user_bank_city">Ville*</label>
									<input type="text" class="form-control" name="user_bank_city" id="user_bank_city" value="<?php echo $iban->OwnerAddress->City ?>" required/>
								</div>
							</div>

							<div class="col-md-12">
								<div class="form-group">
									<label for="user_bank_iban">Numéro IBAN*</label>
									<input type="text" class="form-control" name="user_bank_iban" id="user_bank_iban" value="<?php echo $iban->Details->IBAN?>" required/>
								</div>
							</div>

							<div class="col-md-12">
								<div class="form-group">
									<label for="user_bank_bic">Numéro BIC*</label>
									<input type="text" class="form-control" name="user_bank_bic" id="user_bank_bic" value="<?php echo $iban->Details->BIC ?>" required/>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-12" style="margin-top: 10px">
								<input type="submit" class="btn btn-default" value="Enregistrer" />
							</div>
						</div>

						<div class="row">
							<div class="col-md-12">
								<div id="banner-edit-bankwire" class="alert" style="display: none; margin-top: 30px">
								</div>
							</div>
						</div>
					</form>
				</div>
				<!--<input type="submit" class="btn btn-inverse btn-small" style="float:none;" name="vendor_application_submit"
					   value="<?php /*_e( 'Save', 'wcvendors' ); */?>"/>-->
				<div class="modal-footer">
					<button type="button" class="btn btn-default .btn-sm btn-second" data-dismiss="modal">Fermer</button>
				</div>

<!--				</form>-->
			</div>
		</div>
	</div>
</div>

<div class="container-fluid">
	<div class="row" style="padding-bottom: 16px; padding-top: 20px;">
		<div class="col-sm-12 no-padding-left">

			<a id="unsubscribe-link" class="btn btn-default .btn-sm btn-second" href="/desinscription" title="Me désinscrire">
				<i class="fa fa-trash" aria-hidden="true"></i> Supprimer mon compte
			</a>

		</div>
	</div>
</div>
		
