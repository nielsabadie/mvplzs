<?php
/**
 * Login Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-login.php.
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
 * @version 3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>

<?php wc_print_notices(); ?>

<?php do_action( 'woocommerce_before_customer_login_form' ); ?>

<?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) : ?>

<div class="u-columns col2-set" id="customer_login">

	<div class="u-column1 col-1">

<?php endif; ?>

		<h2><?php _e( 'Login', 'woocommerce' ); ?></h2>

		<form class="woocommerce-form woocommerce-form-login login" method="post">

			<?php do_action( 'woocommerce_login_form_start' ); ?>

			<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
				<label for="username"><?php _e( 'Username or email address', 'woocommerce' ); ?> <span class="required">*</span></label>
				<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( $_POST['username'] ) : ''; ?>" />
			</p>
			<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
				<label for="password"><?php _e( 'Password', 'woocommerce' ); ?> <span class="required">*</span></label>
				<input class="woocommerce-Input woocommerce-Input--text input-text" type="password" name="password" id="password" />
			</p>

			<?php do_action( 'woocommerce_login_form' ); ?>

			<p class="form-row">
				<?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
				<input type="submit" class="woocommerce-Button button" name="login" value="<?php esc_attr_e( 'Login', 'woocommerce' ); ?>" />
				<label class="woocommerce-form__label woocommerce-form__label-for-checkbox inline">
					<input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" /> <span><?php _e( 'Remember me', 'woocommerce' ); ?></span>
				</label>
			</p>
			<p class="woocommerce-LostPassword lost_password">
				<a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php _e( 'Lost your password?', 'woocommerce' ); ?></a>
			</p>

			<?php do_action( 'woocommerce_login_form_end' ); ?>

		</form>

<?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) : ?>

	</div>

	<div class="u-column2 col-2">

		<h2><?php _e( 'Register', 'woocommerce' ); ?></h2>

		<form method="post" class="register">

			<?php do_action( 'woocommerce_register_form_start' ); ?>

			<p class="form-row form-group type_account">
			    <label class="radio">
			        <input type="radio" id="individual" name="user_mp_status" value="individual" checked>
			        <?php _e( 'I am an individual', 'dokan-lite' ); ?> 
			    </label>

			    <label class="radio">
			        <input type="radio" id="professionnal" name="user_mp_status" value="professional">
			        <?php _e( 'I am a professional', 'dokan-lite' ); ?> 
			    </label>
		    
    		</p>

    		<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide" id="type-entreprise" style="display:none;">
            	<label for="type_professional">Type d'entreprise <span class="required">*</span></label>
            	<select name="type_professional" id="type_professional" value="<?php echo $type_professional; ?>" class="regular-text">
            	<option value="society" selected="selected">Societé</option>
            	<option value="auto-entreprise">Auto-entreprise</option>
            	<option value="association">Association</option>
            	</select>
        	</p>

			<?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>

				<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
					<label for="reg_username"><?php _e( 'Username', 'woocommerce' ); ?> (public) <span class="required">*</span></label>
					<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="reg_username" placeholder="Chucky40" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( $_POST['username'] ) : ''; ?>" />
				</p>

			<?php endif; ?>

			<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
				<label for="reg_firstname"><?php _e( 'First name', 'woocommerce' ); ?> <span class="required">*</span></label>
				<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="billing_first_name" id="reg_firstname" placeholder="Chuck" value="<?php echo ( ! empty( $_POST['billing_first_name'] ) ) ? esc_attr( $_POST['billing_first_name'] ) : ''; ?>" />
			</p>

			<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
				<label for="reg_lastname"><?php _e( 'Last name', 'woocommerce' ); ?> <span class="required">*</span></label>
				<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="billing_last_name" id="reg_lastname" placeholder="Norris" value="<?php echo ( ! empty( $_POST['billing_last_name'] ) ) ? esc_attr( $_POST['billing_last_name'] ) : ''; ?>" />
			</p>



		

			<p><br></p>

			
			<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
				<label for="reg_email"><?php _e( 'Email address', 'woocommerce' ); ?> <span class="required">*</span></label>
				<input type="email" class="woocommerce-Input woocommerce-Input--text input-text" name="email" id="reg_email" placeholder="chuck@norris.com" value="<?php echo ( ! empty( $_POST['email'] ) ) ? esc_attr( $_POST['email'] ) : ''; ?>" />
			</p>

			<?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>

				<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
					<label for="reg_password"><?php _e( 'Password', 'woocommerce' ); ?> <span class="required">*</span></label>
					<input type="password" class="woocommerce-Input woocommerce-Input--text input-text" name="password" placeholder="Je-suis-immortel-!$%" id="reg_password" />
				</p>

			<?php  endif; ?>

             
                <?php
                  $value = '';
                  if( ! empty( $_POST['user_birthday'] ) ) {
                      $value = esc_attr( $_POST['user_birthday'] );
                  }
                  if( $wp_user_id = get_current_user_id() ){
                      $value = date_i18n( $this->supported_format( get_option( 'date_format' ) ), strtotime( get_user_meta( $wp_user_id, 'user_birthday', true ) ) );
                  }
                  ?>
                  <?php // do_action( 'bp_user_birthday_errors' ); ?>
                  <p class="form-row form-row-wide">
                      <label for="reg_user_birthday"><?php _e( 'Birthday', 'mangopay' ); ?> <span class="required">*</span></label>
                      <input type="text" class="input-text calendar" name="user_birthday" id="reg_user_birthday" value="<?php echo $value; ?>" />
                  </p>

			 <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
            <label for="user_nationality">Pays <span class="required">*</span></label>
            <select name="user_nationality" id="user_nationality" value="<?php echo $user_nationality; ?>" class="regular-text">

                <?php
                $countries = array(
                    'FR' => 'France',
                    'AF' => 'Afghanistan',
                    'ZA' => 'Afrique du Sud',
                    'AX' => 'Åland, Îles',
                    'AL' => 'Albanie',
                    'DZ' => 'Algérie',
                    'DE' => 'Allemagne',
                    'AD' => 'Andorre',
                    'AO' => 'Angola',
                    'AI' => 'Anguilla',
                    'AQ' => 'Antarctique',
                    'AG' => 'Antigua-Et-Barbuda',
                    'SA' => 'Arabie Saoudite',
                    'AR' => 'Argentine',
                    'AM' => 'Arménie',
                    'AW' => 'Aruba',
                    'AU' => 'Australie',
                    'AT' => 'Autriche',
                    'AZ' => 'Azerbaïdjan',
                    'BS' => 'Bahamas',
                    'BH' => 'Bahreïn',
                    'BD' => 'Bangladesh',
                    'BB' => 'Barbade',
                    'BY' => 'Bélarus',
                    'BE' => 'Belgique',
                    'BZ' => 'Belize',
                    'BJ' => 'Bénin',
                    'BM' => 'Bermudes',
                    'BT' => 'Bhoutan',
                    'BO' => 'Bolivie',
                    'BQ' => 'Bonaire, Saint-Eustache et Saba',
                    'BA' => 'Bosnie-Herzégovine',
                    'BW' => 'Botswana',
                    'BV' => 'Bouvet, Île',
                    'BR' => 'Brésil',
                    'BN' => 'Brunei Darussalam',
                    'BG' => 'Bulgarie',
                    'BF' => 'Burkina Faso',
                    'BI' => 'Burundi',
                    'KY' => 'Caïmans, Îles',
                    'KH' => 'Cambodge',
                    'CM' => 'Cameroun',
                    'CA' => 'Canada',
                    'CV' => 'Cap-Vert',
                    'CF' => 'République Centrafricaine',
                    'CL' => 'Chili',
                    'CN' => 'Chine',
                    'CX' => 'Christmas, Île',
                    'CY' => 'Chypre',
                    'CC' => 'Cocos (Keeling), Îles',
                    'CO' => 'Colombie',
                    'KM' => 'Comores',
                    'CG' => 'Congo',
                    'CD' => 'Congo, République démocratique du',
                    'CK' => 'Cook, Îles',
                    'KR' => 'Corée du Sud',
                    'KP' => 'Corée du Nord',
                    'CR' => 'Costa Rica',
                    'CI' => 'Côte d\'Ivoire',
                    'HR' => 'Croatie',
                    'CU' => 'Cuba',
                    'CW' => 'Curaçao',
                    'DK' => 'Danemark',
                    'DJ' => 'Djibouti',
                    'DO' => 'République dominicaine',
                    'DM' => 'Dominique',
                    'EG' => 'Égypte',
                    'SV' => 'El Salvador',
                    'AE' => 'Émirats Arabes Unis',
                    'EC' => 'Équateur',
                    'ER' => 'Érythrée',
                    'ES' => 'Espagne',
                    'EE' => 'Estonie',
                    'US' => 'États-Unis',
                    'ET' => 'Éthiopie',
                    'FK' => 'Malouines, Îles',
                    'FO' => 'Féroé, Îles',
                    'FJ' => 'Fidji',
                    'FI' => 'Finlande',
                    'GA' => 'Gabon',
                    'GM' => 'Gambie',
                    'GE' => 'Géorgie',
                    'GS' => 'Géorgie du Sud-et-les Îles Sandwich du Sud',
                    'GH' => 'Ghana',
                    'GI' => 'Gibraltar',
                    'GR' => 'Grèce',
                    'GD' => 'Grenade',
                    'GL' => 'Groenland',
                    'GP' => 'Guadeloupe',
                    'GU' => 'Guam',
                    'GT' => 'Guatemala',
                    'GG' => 'Guernesey',
                    'GN' => 'Guinée',
                    'GW' => 'Guinée-Bissau',
                    'GQ' => 'Guinée équatoriale',
                    'GY' => 'Guyana',
                    'GF' => 'Guyane française',
                    'HT' => 'Haïti',
                    'HM' => 'Heard-et-MacDonald, Îles',
                    'HN' => 'Honduras',
                    'HK' => 'Hong Kong',
                    'HU' => 'Hongrie',
                    'IM' => 'Île De Man',
                    'UM' => 'Îles mineures éloignées des États-Unis',
                    'VG' => 'Îles Vierges britanniques',
                    'VI' => 'Îles Vierges des États-Unis',
                    'IN' => 'Inde',
                    'ID' => 'Indonésie',
                    'IR' => 'Iran',
                    'IQ' => 'Iraq',
                    'IE' => 'Irlande',
                    'IS' => 'Islande',
                    'IL' => 'Israël',
                    'IT' => 'Italie',
                    'JM' => 'Jamaïque',
                    'JP' => 'Japon',
                    'JE' => 'Jersey',
                    'JO' => 'Jordanie',
                    'KZ' => 'Kazakhstan',
                    'KE' => 'Kenya',
                    'KG' => 'Kirghizistan',
                    'KI' => 'Kiribati',
                    'KW' => 'Koweït',
                    'LA' => 'Laos',
                    'LS' => 'Lesotho',
                    'LV' => 'Lettonie',
                    'LB' => 'Liban',
                    'LR' => 'Libéria',
                    'LY' => 'Libye',
                    'LI' => 'Liechtenstein',
                    'LT' => 'Lituanie',
                    'LU' => 'Luxembourg',
                    'MO' => 'Macao',
                    'MK' => 'Macédoine',
                    'MG' => 'Madagascar',
                    'MY' => 'Malaisie',
                    'MW' => 'Malawi',
                    'MV' => 'Maldives',
                    'ML' => 'Mali',
                    'MT' => 'Malte',
                    'MP' => 'Mariannes du Nord, Îles',
                    'MA' => 'Maroc',
                    'MH' => 'Marshall, Îles',
                    'MQ' => 'Martinique',
                    'MU' => 'Maurice',
                    'MR' => 'Mauritanie',
                    'YT' => 'Mayotte',
                    'MX' => 'Mexique',
                    'FM' => 'Micronésie, États fédérés de',
                    'MD' => 'Moldavie',
                    'MC' => 'Monaco',
                    'MN' => 'Mongolie',
                    'ME' => 'Monténégro',
                    'MS' => 'Montserrat',
                    'MZ' => 'Mozambique',
                    'MM' => 'Myanmar',
                    'NA' => 'Namibie',
                    'NR' => 'Nauru',
                    'NP' => 'Népal',
                    'NI' => 'Nicaragua',
                    'NE' => 'Niger',
                    'NG' => 'Nigéria',
                    'NU' => 'Niué',
                    'NF' => 'Norfolk, Île',
                    'NO' => 'Norvège',
                    'NC' => 'Nouvelle-Calédonie',
                    'NZ' => 'Nouvelle-Zélande',
                    'IO' => 'Territoire britannique de l\'Océan Indien',
                    'OM' => 'Oman',
                    'UG' => 'Ouganda',
                    'UZ' => 'Ouzbékistan',
                    'PK' => 'Pakistan',
                    'PW' => 'Palaos',
                    'PS' => 'Palestine, Etat de',
                    'PA' => 'Panama',
                    'PG' => 'Papouasie-Nouvelle-Guinée',
                    'PY' => 'Paraguay',
                    'NL' => 'Pays-Bas',
                    'PE' => 'Pérou',
                    'PH' => 'Philippines',
                    'PN' => 'Pitcairn',
                    'PL' => 'Pologne',
                    'PF' => 'Polynésie française',
                    'PR' => 'Porto Rico',
                    'PT' => 'Portugal',
                    'QA' => 'Qatar',
                    'RE' => 'Réunion',
                    'RO' => 'Roumanie',
                    'GB' => 'Royaume-Uni',
                    'RU' => 'Russie',
                    'RW' => 'Rwanda',
                    'EH' => 'Sahara Occidental',
                    'BL' => 'Saint-Barthélemy',
                    'SH' => 'Sainte-Hélène',
                    'LC' => 'Sainte-Lucie',
                    'KN' => 'Saint-Kitts-Et-Nevis',
                    'SM' => 'Saint-Marin',
                    'MF' => 'Saint-Martin (Antilles françaises)',
                    'SX' => 'Saint-Martin (Royaume des Pays-Bas)',
                    'PM' => 'Saint-Pierre-Et-Miquelon',
                    'VA' => 'Vatican, État de la Cité du',
                    'VC' => 'Saint-Vincent-et-les Grenadines',
                    'SB' => 'Salomon, Îles',
                    'WS' => 'Samoa',
                    'AS' => 'Samoa américaines',
                    'ST' => 'Sao Tomé-et-Principe',
                    'SN' => 'Sénégal',
                    'RS' => 'Serbie',
                    'SC' => 'Seychelles',
                    'SL' => 'Sierra Leone',
                    'SG' => 'Singapour',
                    'SK' => 'Slovaquie',
                    'SI' => 'Slovénie',
                    'SO' => 'Somalie',
                    'SD' => 'Soudan',
                    'SS' => 'Soudan du Sud',
                    'LK' => 'Sri Lanka',
                    'SE' => 'Suède',
                    'CH' => 'Suisse',
                    'SR' => 'Suriname',
                    'SJ' => 'Svalbard et Jan Mayen',
                    'SZ' => 'Swaziland',
                    'SY' => 'Syrie',
                    'TJ' => 'Tadjikistan',
                    'TW' => 'Taïwan',
                    'TZ' => 'Tanzanie',
                    'TD' => 'Tchad',
                    'CZ' => 'République Tchèque',
                    'TF' => 'Terres australes et antarctiques françaises',
                    'TH' => 'Thaïlande',
                    'TL' => 'Timor Oriental',
                    'TG' => 'Togo',
                    'TK' => 'Tokelau',
                    'TO' => 'Tonga',
                    'TT' => 'Trinité-et-Tobago',
                    'TN' => 'Tunisie',
                    'TM' => 'Turkménistan',
                    'TC' => 'Turks-et-Caïcos, Îles',
                    'TR' => 'Turquie',
                    'TV' => 'Tuvalu',
                    'UA' => 'Ukraine',
                    'UY' => 'Uruguay',
                    'VU' => 'Vanuatu',
                    'VE' => 'Venezuela',
                    'VN' => 'Viêt Nam',
                    'WF' => 'Wallis et Futuna',
                    'YE' => 'Yémen',
                    'ZM' => 'Zambie',
                    'ZW' => 'Zimbabwe',
                );


                foreach ($countries as $country_code => $country_name) {

                    if ($user_nationality == $country_code) {

                        echo '<option value="' . $country_code . '" selected="selected">' . $country_name . '</option>';
                    } else {

                        echo '<option value="' . $country_code . '">' . $country_name . '</option>';
                    }
                }

                ?>
            </select>
        </p>

			<?php do_action( 'woocommerce_register_form' ); ?>

			<p class="form-row form-group form-row-wide">
				<label>
					<input type="checkbox" name="mc4wp-subscribe" value="1" />
					M'inscrire à la newsletter.
				</label>
			</p>


			<p class="woocommerce-FormRow form-row">
				<?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
				<input type="submit" class="woocommerce-Button button" id="register-button" name="register" value="<?php esc_attr_e( 'Register', 'woocommerce' ); ?>" />
			</p>

               <input id="reg_billing_country" name="billing_country" type="hidden" value="FR">
               

			<?php do_action( 'woocommerce_register_form_end' ); ?>

		</form>

	</div>

</div>
<?php endif; ?>

<?php do_action( 'woocommerce_after_customer_login_form' ); ?>
