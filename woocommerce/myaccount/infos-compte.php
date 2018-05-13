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



<div class="container-fluid">
	<div class="row" style="padding-bottom: 16px; padding-top: 20px;">
		<div class="col-sm-12 no-padding-left">

			<a id="unsubscribe-link" class="btn btn-second" href="/desinscription" title="Me désinscrire">
				<i class="fa fa-trash" aria-hidden="true"></i> Supprimer mon compte
			</a>

		</div>
	</div>
</div>
		
