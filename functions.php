
<?php
/**
 * Techmarket Child
 *
 * @package techmarket-child
 */

/**
 * Include all your custom code here
 */
 

function redirectAfterAddNewProduct() {
	
	return 'https://www.luzus.fr/ma-boutique/products/';
}

add_filter ('dokan_add_new_product_redirect', 'redirectAfterAddNewProduct');


function wpMail_set_content_type(){

    return "text/html";

}
add_filter( 'wp_mail_content_type','wpMail_set_content_type' );



function testTemplateEmail () {

	include('wp-content/themes/techmarket-child/woocommerce/emails/customer-new-account.php');
	
}
add_shortcode('testTemplate', 'testTemplateEmail');



/* BACKOFFICE MODIFICATIONS */

	function remove_footer_credits_admin() {
		return '<a href="https://luzus.fr><i class="fa fa-rocket"></i>LUZUS.fr</a>';
	}

	add_filter('admin_footer_text', 'remove_footer_credits_admin');

/* END BACKOFFICE MODIFICATIONS */





/* SPECIFIC CSS FOR NO ADMIN */

	function no_admin_enqueue_styles() {

		if( !current_user_can('administrator') ) {
			wp_enqueue_style( 'noadmin', get_template_directory_uri().'-child/css/noadmin.css' );
		}
	}

	add_action( 'wp_enqueue_scripts', 'no_admin_enqueue_styles' );

/* END SPECIFIC CSS FOR NO ADMIN */






/*  SETTINGS MEDIA UPLOADER  */

		function limit_upload_size( $file ) { //restrict file upload size for no admin user

			if (!current_user_can('administrator')) {

				$file_size_limit = 1024*4; // 1MB in KB

				// exclude admins
				if ( ! current_user_can( 'manage_options' ) ) {

					$current_size = $file['size'];
					$current_size = $current_size / 1024; //get size in KB

					if ( $current_size > $file_size_limit ) {
						$file['error'] = sprintf( __( 'ðŸ˜± OUPS: Votre photo dÃ©passe la limite autorisÃ©e de %d KB.' ), $file_size_limit );
					}

				}

			}
			// Set the desired file size limit
			return $file;

		}
		add_filter ( 'wp_handle_upload_prefilter', 'limit_upload_size', 10, 1 );


		function restict_mime($mimes) { //restrict file type to upload for no admin user

			if(!current_user_can('administrator')){
				$mimes = array( 
							'jpg|jpeg|jpe' => 'image/jpeg', 
							'png' => 'image/png', 
				); 
			}
			return $mimes;
		}

		add_filter('upload_mimes','restict_mime'); 


		function wdm_custom_media_view_strings( $strings ) {
			if (!current_user_can('administrator')) {
				//unset($strings['mediaLibraryTitle']);
				//unset($strings['insertMediaTitle']);
				unset($strings['filterByDate']);
				unset($strings['filterByType']);
				unset($strings['searchMediaLabel']);
				//unset($strings['uploadFilesTitle']);
				unset($strings['dragInfo']);
				unset($strings['attachmentDetails']);
				unset($strings['setFeaturedImageTitle']);
				unset($strings['setFeaturedImage']);
				unset($strings['imageDetailsTitle']);
				unset($strings['imageReplaceTitle']);
				unset($strings['imageDetailsCancel']);
				unset($strings['editImage']);
				//unset($strings['']);
			}

			return $strings;
		}

		add_filter('media_view_strings', 'wdm_custom_media_view_strings');

/*  END SETTINGS MEDIA UPLOADER  */



/* SETTINGS CART WIDGET */

	remove_action( 'woocommerce_widget_shopping_cart_buttons', 'woocommerce_widget_shopping_cart_button_view_cart', 10 );
	remove_action( 'woocommerce_widget_shopping_cart_buttons', 'woocommerce_widget_shopping_cart_proceed_to_checkout', 20 );

	function button_checkout_cart () {
		echo '<a href="' . esc_url( wc_get_checkout_url() ) . '" class="btn btn-primary btn-cart">' . esc_html__( 'Checkout', 'woocommerce' ) . '</a>';
	}

	function button_view_cart_link () {
		echo '<a style="margin-top: 10px;" href="' . esc_url( wc_get_cart_url() ) . '" class="small-link">' . esc_html__( 'View cart', 'woocommerce' ) . '</a>';
	}

	add_action( 'woocommerce_widget_shopping_cart_buttons', 'button_checkout_cart', 10 );
	add_action( 'woocommerce_widget_shopping_cart_buttons', 'button_view_cart_link', 20 );


/* END SETTINGS CART WIDGET */


function woocommerce_template_loop_product_description () {

    global $product;	
    //var_dump($product);

    $productId = $product->get_id();
    $productTitle = $product->post->post_title;
    $productDescription = $product->post->post_content;
    $maxDescriptionLength = 200;
    $limitedDescription = substr($productDescription, 0, $maxDescriptionLength).' ...';
    $productUrl = get_permalink( $productId );
    $productTags = $product->get_tags( $product );

    echo 
        '<div class="productDescription" style="margin-top: 10px">
            <a href="' . $productUrl . '" title="' . $productTitle . '">'
            . esc_html($limitedDescription) . 
            '</a>
        </div>';

    return;
}

add_action( 'woocommerce_after_list_view_item_title', 'woocommerce_template_loop_product_description', 30 );


function woocommerce_template_loop_product_tags () {

    global $product;	

    // get product_tags of the current product
    $current_tags = get_the_terms( get_the_ID(), 'product_tag' );
    
    //only start if we have some tags
    if ( $current_tags && ! is_wp_error( $current_tags ) ) { 
    
        //create a list to hold our tags
        echo '<ul class="product_tags">';
    
        //for each tag we create a list item
        foreach ($current_tags as $tag) {
    
            $tag_title = $tag->name; // tag name
            $tag_link = get_term_link( $tag );// tag archive link
    
            echo '<li><a href="'.$tag_link.'">'.$tag_title.'</a></li>';
        }
    
        echo '</ul>';
    }
}

add_action( 'woocommerce_after_list_view_item_title', 'woocommerce_template_loop_product_tags', 50 );






/* HEADER TECHMARKET */

	function techmarket_secondary_navigation() {
		?>
		<nav id="secondary-navigation" class="secondary-navigation" aria-label="Secondary Navigation" data-nav="flex-menu">

			<ul id="menu-secondary-menu" class="nav"><li itemscope="itemscope" itemtype="https://www.schema.org/SiteNavigationElement" id="secondary-menu-item-5006" class="vendre menu-item menu-item-type-custom menu-item-object-custom menu-item-5006 animate-dropdown"><a title="VENDRE" href="/ma-boutique/new-product/">VENDRE</a></li>



				<?php
				if (is_user_logged_in() ) : ?>

					<li itemscope="itemscope" itemtype="https://www.schema.org/SiteNavigationElement" id="secondary-menu-item-6642" class="menu-item menu-item-type-post_type menu-item-object-page current-menu-item page_item page-item-2773 current_page_item current-menu-ancestor current-menu-parent current_page_parent current_page_ancestor menu-item-has-children menu-item-6642 animate-dropdown dropdown active"><a title=" Mon Compte" data-toggle="dropdown" class="dropdown-toggle" aria-haspopup="true" href="https://www.luzus.fr/mon-compte/"><i class="tm tm-login-register"></i> Mon Compte <span class="caret"></span></a>
						<ul role="menu" class=" dropdown-menu">
							<li itemscope="itemscope" itemtype="https://www.schema.org/SiteNavigationElement" id="secondary-menu-item-6647" class="menu-item menu-item-type-post_type menu-item-object-page current-menu-item page_item page-item-2773 current_page_item menu-item-6647 animate-dropdown active"><a title="Mon Compte" href="https://www.luzus.fr/mon-compte/"><i class="tm tm-login-register"></i> Mon Compte</a></li>
							<hr>
							<li itemscope="itemscope" itemtype="https://www.schema.org/SiteNavigationElement" id="secondary-menu-item-6643" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-6643 animate-dropdown"><a title="Ma boutique" href="https://www.luzus.fr/ma-boutique/"><i class="tm tm-best-brands"></i> Ma boutique</a></li>
							<li itemscope="itemscope" itemtype="https://www.schema.org/SiteNavigationElement" id="secondary-menu-item-6644" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-6644 animate-dropdown"><a title="Mes Messages" href="https://luzus.fr/mon-compte/support-tickets/"><i class="tm tm-feedback"></i> Mes Messages</a></li>
							<li itemscope="itemscope" itemtype="https://www.schema.org/SiteNavigationElement" id="secondary-menu-item-6645" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-6645 animate-dropdown"><a title="Mes Achats" href="https://luzus.fr/mon-compte/mes-achats/"><i class="tm tm-shopping-bag"></i> Mes Achats</a></li>
							<li itemscope="itemscope" itemtype="https://www.schema.org/SiteNavigationElement" id="secondary-menu-item-6646" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-6646 animate-dropdown"><a title="Mes informations" href="https://luzus.fr/mon-compte/infos-compte/"><i class="tm tm-listing-large"></i> Mes informations</a></li>
							<li itemscope="itemscope" itemtype="https://www.schema.org/SiteNavigationElement" id="secondary-menu-item-6646" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-6646 animate-dropdown"><a class="redLink" title="DÃ©connexion" href="https://luzus.fr/mon-compte/customer-logout/"><i class="tm tm-close"></i> DÃ©connexion</a></li>
						</ul>
					</li>

					<?php
				else : ?>

					<li class="menu-item"><a title="Inscription / Connexion" href="https://www.luzus.fr/mon-compte/"><i class="tm tm-laptop"></i>Inscription / Connexion</a></li>


					<?php
				endif; ?>

		</nav><!-- #secondary-navigation -->

		<div id="user-image-secondary-navigation">
			<?php
			if (is_user_logged_in() ) :
				$current_user = wp_get_current_user();

				if ( ($current_user instanceof WP_User) ) {
					echo get_avatar( $current_user->user_email, 25 );
				}

			endif;
			?>
		</div>
		<?php


	}

	add_action( 'techmarket_header_v1', 'techmarket_secondary_navigation', 30 );

/* END HEADER TECHMARKET */



/* FOOTER TECHMARKET */

	function techmarket_footer_site_info () {
		
		$website_title_with_url     = sprintf( '<a href="%s">%s</a>', esc_url( home_url( '/' ) ), get_bloginfo( 'name' ) );
		$footer_copyright_text      = apply_filters( 'techmarket_footer_copyright_text', sprintf( esc_html__( 'Copyright &copy; %s %s Theme. All rights reserved.', 'techmarket' ), date( 'Y' ), $website_title_with_url ) );
		$footer_credit_text         = apply_filters( 'techmarket_footer_credit_text', sprintf( esc_html__( 'Made with %s', 'techmarket' ), '<i class="fa fa-heart"></i>' ) );

		if ( apply_filters( 'techmarket_footer_site_info', true ) ) : ?>

			<div class="site-info">
			<div class="col-full">
				<div class="copyright">
					<?php echo 'Copyright Â© ' . date('Y') . ' <a href="https://luzus.fr" title="LUZUS.fr"/>LUZUS</a> | Tous droits rÃ©servÃ©s. ';?>
				</div>
				<div class="credit"><?php echo wp_kses_post( $footer_credit_text ); ?></div>
			</div>
			</div><?php

		endif;

	}

	add_action( 'techmarket_footer_v1', 'techmarket_footer_site_info', 50 );

/* END FOOTER TECHMARKET */


	add_filter( 'woocommerce_product_subcategories_hide_empty', 'hide_empty_categories', 10, 1 );
	function hide_empty_categories ( $hide_empty ) {
		$hide_empty  =  FALSE;
		// You can add other logic here too
		return $hide_empty;
	}



/* DOKAN PLUGIN*/

/* MENU NAVIGATION DASHBOARD */

/* MODIFY DOKAN MENU ITEMS */

function modify_menu_moncompte_dokan_add_seller_nav($urls) {

    $urls['dashboard']['icon'] = '<i class="fa fa-shopping-bag"></i>';
    $urls['products']['title'] = 'Mes annonces';
    //$urls['settings']['title'] = 'ParamÃ¨tres';
    //$urls['settings']['icon'] = '<i class="fa fa-cogs"></i>';
    $urls['products']['icon'] = '<i class="fa fa-desktop"></i>';
    $urls['orders']['title'] = 'Mes ventes';
    $urls['orders']['icon'] = '<i class="fa fa-list-ul "></i>';
    //$urls['support']['icon'] = '<i class="fa fa-commenting-o "></i>';
    //$urls['support']['title'] = 'Messages';

    return $urls;
}

add_filter('dokan_get_dashboard_nav', 'modify_menu_moncompte_dokan_add_seller_nav', 111);


/* END ADD DOKAN MENU ITEMS */
function moncompte_dokan_add_seller_nav($common_links) {

    $common_links = '<li class="dokan-common-links dokan-clearfix">
            <a title="' . __('Mon compte', 'dokan-lite') . '" class="tips" data-placement="top" href="' . dokan_get_navigation_url('mon-compte') . '"><i class="fa fa-arrow-left"></i></a>
        </li>';
	
	/*<a title="' . __('Visit Store', 'dokan-lite') . '" class="tips" data-placement="top" href="' . dokan_get_store_url(get_current_user_id()) . '" target="_blank"><i class="fa fa-eye"></i></a>
            
            <a title="' . __('Log out', 'dokan-lite') . '" class="tips" data-placement="top" href="' . wp_logout_url(home_url()) . '"><i class="fa fa-power-off"></i></a>*/


    return $common_links;
}

add_filter('dokan_dashboard_nav_common_link', 'moncompte_dokan_add_seller_nav');



/* REMOVE DOKAN MENU ITEMS */

function suppressions_menu_moncompte_dokan_add_seller_nav($urls)
{

    unset($urls['reviews']);
    unset($urls['reports']);
    unset($urls['coupons']);
    unset($urls['withdraw']);
    unset($urls ['support']);
    unset($urls ['settings']);

    return $urls;
}

add_filter('dokan_get_dashboard_nav', 'suppressions_menu_moncompte_dokan_add_seller_nav', 1111);

/* END REMOVE DOKAN MENU ITEMS */

/* REMOVE DOKAN SUBMENU ITEMS */

add_filter('dokan_get_dashboard_settings_nav', 'submenu_dashbaord_settings_nav', 11);

function submenu_dashbaord_settings_nav($sub_settings)
{

    unset($sub_settings['seo']);
    unset($sub_settings['social']);

    return $sub_settings;

}

/* END -> REMOVE DOKAN SUBMENU ITEMS */


/* MODIFY DOKAN SUBMENU ITEMS */

function modify_sub_settings_dokan_add_seller_nav($sub_settings)
{

    $sub_settings['payment']['title'] = 'Infos. bancaires';
    $sub_settings['payment']['icon'] = '<i class="fa fa-id-card"></i>';

    return $sub_settings;
}

add_filter('dokan_get_dashboard_settings_nav', 'modify_sub_settings_dokan_add_seller_nav');

/* END -> MODIFY DOKAN SUBMENU ITEMS */

/* END MENU NAVIGATION DASHBOARD */

/* END DOKAN PLUGIN */


/* WOOCOMMERCE PLUGIN */

/* ADD MA BOUTIQUE ITEM (Ma boutique) MY ACCOUNT MENU */

add_filter('woocommerce_account_menu_items', 'woocommerce_one_more_link');
function woocommerce_one_more_link($menu_links) {

    // we will hook "ma_boutique" later
    $new = array('ma_boutique' => 'Ma boutique');

    // array_slice() is good when you want to add an element between the other ones
    $menu_links = array_slice($menu_links, 0, 1, true) + $new + array_slice($menu_links, 1, null, true);


    return $menu_links;

}

add_filter('woocommerce_get_endpoint_url', 'woocommerce_new_link_hook_endpoint', 10, 4);

function woocommerce_new_link_hook_endpoint($url, $endpoint, $value, $permalink)
{

    if ($endpoint === 'ma_boutique') {

        // ok, here is the place for your custom URL, it could be external
        $url = site_url('/ma-boutique');

    }
    return $url;

}

/* END ADD MA BOUTIQUE ITEM (Ma boutique) MY ACCOUNT MENU */

/* ADD MA BOUTIQUE ITEM (Porte-Monnaie) MY ACCOUNT MENU */

function luzus_add_porte_monnaie_endpoint()
{
    add_rewrite_endpoint('porte-monnaie', EP_ROOT | EP_PAGES);
}

add_action('init', 'luzus_add_porte_monnaie_endpoint');


// ------------------
// 2. Add new query var

function porte_monnaie_query_vars($vars)
{
    $vars[] = 'porte-monnaie';
    return $vars;
}

add_filter('query_vars', 'porte_monnaie_query_vars', 0);


// ------------------
// 3. Insert the new endpoint into the My Account menu

function luzus_add_porte_monnaie_link_my_account($items)
{
    $items['porte-monnaie'] = 'Porte Monnaie';
    return $items;
}

add_filter('woocommerce_account_menu_items', 'luzus_add_porte_monnaie_link_my_account');


// ------------------
// 4. Add content to the new endpoint

function porte_monnaie_content()
{

    include 'wp-content/themes/techmarket-child/woocommerce/myaccount/porte-monnaie.php';
}

add_action('woocommerce_account_porte-monnaie_endpoint', 'porte_monnaie_content');

/* END ADD MA BOUTIQUE ITEM (Porte-monnaie) MY ACCOUNT MENU */


/*-----------------------------------------------------*/


/* ADD MA BOUTIQUE ITEM (Infos compte) MY ACCOUNT MENU */

function luzus_add_infos_compte_endpoint()
{
    add_rewrite_endpoint('infos-compte', EP_ROOT | EP_PAGES);
}

add_action('init', 'luzus_add_infos_compte_endpoint');


// ------------------
// 2. Add new query var

function infos_compte_query_vars($vars)
{
    $vars[] = 'infos-compte';
    return $vars;
}

add_filter('query_vars', 'infos_compte_query_vars', 0);


// ------------------
// 3. Insert the new endpoint into the My Account menu

function luzus_add_infos_compte_link_my_account($items)
{
    $items['infos-compte'] = 'Vos informations';
    return $items;
}

add_filter('woocommerce_account_menu_items', 'luzus_add_infos_compte_link_my_account');


// ------------------
// 4. Add content to the new endpoint

function infos_compte_content()
{

    include 'wp-content/themes/techmarket-child/woocommerce/myaccount/infos-compte.php';
}

add_action('woocommerce_account_infos-compte_endpoint', 'infos_compte_content');

/* END ADD MA BOUTIQUE ITEM (Infos compte) MY ACCOUNT MENU */


/* ADD MA BOUTIQUE ITEM (Support client) MY ACCOUNT MENU */

function luzus_add_luzus_support_endpoint()
{
    add_rewrite_endpoint('luzus-support', EP_ROOT | EP_PAGES);
}

add_action('init', 'luzus_add_luzus_support_endpoint');


// ------------------
// 2. Add new query var

function luzus_support_query_vars($vars)
{
    $vars[] = 'luzus-support';
    return $vars;
}

add_filter('query_vars', 'luzus_support_query_vars', 0);


// ------------------
// 3. Insert the new endpoint into the My Account menu

function luzus_add_luzus_support_link_my_account($items)
{
    $items['luzus-support'] = 'Support LUZUS';
    return $items;
}

add_filter('woocommerce_account_menu_items', 'luzus_add_luzus_support_link_my_account');


// ------------------
// 4. Add content to the new endpoint

function luzus_support_content()
{
    ?>
    <div id="container-tickets">
        <div id="create-ticket">
            <?php echo do_shortcode('[contact-form-7 id="7560" title="Support Luzus"]'); ?>
        </div>
    </div>
    <?php
}

add_action('woocommerce_account_luzus-support_endpoint', 'luzus_support_content');

/* END ADD MA BOUTIQUE ITEM (Support client) MY ACCOUNT MENU */


/* START MODIFY ORDER MENU WOOCOMMERCE */

function woocommerce_menu_mon_compte()
{
    $moncompte = array(
        'mon-compte' => __('Mon compte', 'woocommerce'),
        'support-tickets' => __('Messages', 'woocommerce'),
        'ma_boutique' => __('Ma boutique', 'woocommerce'),
        'orders' => __('Mes achats', 'woocommerce'),
        //'porte-monnaie' => __('Mon porte-monnaie', 'woocommerce'),
        'infos-compte' => __('Mes informations', 'woocommerce'),
        'luzus-support' => __('Support LUZUS', 'woocommerce'),
        'customer-logout' => __('DÃ©connexion', 'woocommerce'),
    );
    return $moncompte;
}

add_filter('woocommerce_account_menu_items', 'woocommerce_menu_mon_compte');


/**
 * Bypass logout confirmation.
 */
function iconic_bypass_logout_confirmation()
{
    global $wp;

    if (isset($wp->query_vars['customer-logout'])) {
        wp_redirect(str_replace('&amp;', '&', wp_logout_url(wc_get_page_permalink('myaccount'))));
        exit;
    }
}

add_action('template_redirect', 'iconic_bypass_logout_confirmation');

/* END MODIFY ORDER MENU WOOCOMMERCE */


remove_action('woocommerce_order_details_after_order_table', 'woocommerce_order_again_button');


add_filter('woocommerce_product_tabs', 'woo_remove_product_tabs', 98);

function woo_remove_product_tabs($tabs)
{

    unset($tabs['more_seller_product']);
    unset($tabs['specification']);
    unset($tabs['reviews']);

    return $tabs;
}


/* END WOOCOMMERCE PLUGIN */


/* START ADD NICKNAME FIELD WITH POST FOR EDIT */


add_action('woocommerce_edit_account_form_start', 'pseudo_edit_account_form');

function pseudo_edit_account_form()
{

    $user_id = get_current_user_id();
    $user = get_userdata($user_id);
    $user_meta = get_user_meta($user_id);

    if (!$user) {
        return;
    }

    $nickname = get_user_meta($user_id, 'nickname', true);

    ?>
    <p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first">
        <label for="nickname"><?php _e('Pseudo', 'woocommerce'); ?> <span class="required">*</span> (public)</label>
        <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="nickname" id="nickname" value="<?php echo esc_attr($nickname); ?>"/>
    </p>

    <?php

} // end func

/**
 * This is to save user input into database
 * hook: woocommerce_save_account_details
 */
add_action('woocommerce_save_account_details', 'pseudo_save_account_details');

function pseudo_save_account_details($user_id)
{
    update_user_meta($user_id, 'nickname', htmlentities($_POST['nickname']));
} // end func

/**
 * To display additional field at My Account page
 * Once member login: edit account
 */
add_action('woocommerce_edit_account_form', 'my_woocommerce_edit_account_form');

function my_woocommerce_edit_account_form()
{

    $user_id = get_current_user_id();
    $user = get_userdata($user_id);

    if (!$user) {
        return;
    }

    //var_dump($user);

    $user_birthday = date_i18n( get_option( 'date_format' ), strtotime( get_user_meta( $user_id, 'user_birthday', true ) ) );
    $nickname = get_user_meta($user_id, 'nickname', true);
    $user_nationality = get_user_meta($user_id, 'user_nationality', true);


    ?>
    <fieldset>
        <legend>Informations complÃ©mentaires</legend>
        <div class="row">
            <div class="col-sm-12 form-group">

                <label for="reg_user_birthday">
                    <?php _e( 'Birthday', 'mangopay' ); ?> <span class="required">*</span>
                </label>

                <input type="text" class="form-control input-text calendar" name="user_birthday" id="reg_user_birthday" value="<?php echo $user_birthday; ?>" />

            </div>
        </div>

        <div class="row" id="user-nationality">
            <div class="col-sm-12 form-group">
                <label for="user_nationality">
                    NationalitÃ© / Lieu de naissance <span class="required">*</span>
                </label>

                <select id="dropdown-nationality" name="user_nationality" id="user_nationality" value="<?php echo $user_nationality; ?>" class="form-control dokan-form-control dokan-select2">

                    <?php
                    $countries = array(
                        'FR' => 'France',
                        'AF' => 'Afghanistan',
                        'ZA' => 'Afrique du Sud',
                        'AX' => 'Aland, ÃŽles',
                        'AL' => 'Albanie',
                        'DZ' => 'AlgÃ©rie',
                        'DE' => 'Allemagne',
                        'AD' => 'Andorre',
                        'AO' => 'Angola',
                        'AI' => 'Anguilla',
                        'AQ' => 'Antarctique',
                        'AG' => 'Antigua-Et-Barbuda',
                        'SA' => 'Arabie Saoudite',
                        'AR' => 'Argentine',
                        'AM' => 'ArmÃ©nie',
                        'AW' => 'Aruba',
                        'AU' => 'Australie',
                        'AT' => 'Autriche',
                        'AZ' => 'AzerbaÃ¯djan',
                        'BS' => 'Bahamas',
                        'BH' => 'BahreÃ¯n',
                        'BD' => 'Bangladesh',
                        'BB' => 'Barbade',
                        'BY' => 'BÃ©larus',
                        'BE' => 'Belgique',
                        'BZ' => 'Belize',
                        'BJ' => 'BÃ©nin',
                        'BM' => 'Bermudes',
                        'BT' => 'Bhoutan',
                        'BO' => 'Bolivie',
                        'BQ' => 'Bonaire, Saint-Eustache et Saba',
                        'BA' => 'Bosnie-HerzÃ©govine',
                        'BW' => 'Botswana',
                        'BV' => 'Bouvet, ÃŽle',
                        'BR' => 'BrÃ©sil',
                        'BN' => 'Brunei Darussalam',
                        'BG' => 'Bulgarie',
                        'BF' => 'Burkina Faso',
                        'BI' => 'Burundi',
                        'KY' => 'CaÃ¯mans, ÃŽles',
                        'KH' => 'Cambodge',
                        'CM' => 'Cameroun',
                        'CA' => 'Canada',
                        'CV' => 'Cap-Vert',
                        'CF' => 'RÃ©publique Centrafricaine',
                        'CL' => 'Chili',
                        'CN' => 'Chine',
                        'CX' => 'Christmas, ÃŽle',
                        'CY' => 'Chypre',
                        'CC' => 'Cocos (Keeling), ÃŽles',
                        'CO' => 'Colombie',
                        'KM' => 'Comores',
                        'CG' => 'Congo',
                        'CD' => 'Congo, RÃ©publique dÃ©mocratique du',
                        'CK' => 'Cook, ÃŽles',
                        'KR' => 'CorÃ©e du Sud',
                        'KP' => 'CorÃ©e du Nord',
                        'CR' => 'Costa Rica',
                        'CI' => 'CÃ´te d\'Ivoire',
                        'HR' => 'Croatie',
                        'CU' => 'Cuba',
                        'CW' => 'CuraÃ§ao',
                        'DK' => 'Danemark',
                        'DJ' => 'Djibouti',
                        'DO' => 'RÃ©publique dominicaine',
                        'DM' => 'Dominique',
                        'EG' => 'Ã‰gypte',
                        'SV' => 'El Salvador',
                        'AE' => 'Ã‰mirats Arabes Unis',
                        'EC' => 'Ã‰quateur',
                        'ER' => 'Ã‰rythrÃ©e',
                        'ES' => 'Espagne',
                        'EE' => 'Estonie',
                        'US' => 'Ã‰tats-Unis',
                        'ET' => 'Ã‰thiopie',
                        'FK' => 'Malouines, ÃŽles',
                        'FO' => 'FÃ©roÃ©, ÃŽles',
                        'FJ' => 'Fidji',
                        'FI' => 'Finlande',
                        'GA' => 'Gabon',
                        'GM' => 'Gambie',
                        'GE' => 'GÃ©orgie',
                        'GS' => 'GÃ©orgie du Sud-et-les ÃŽles Sandwich du Sud',
                        'GH' => 'Ghana',
                        'GI' => 'Gibraltar',
                        'GR' => 'GrÃ¨ce',
                        'GD' => 'Grenade',
                        'GL' => 'Groenland',
                        'GP' => 'Guadeloupe',
                        'GU' => 'Guam',
                        'GT' => 'Guatemala',
                        'GG' => 'Guernesey',
                        'GN' => 'GuinÃ©e',
                        'GW' => 'GuinÃ©e-Bissau',
                        'GQ' => 'GuinÃ©e Ã©quatoriale',
                        'GY' => 'Guyana',
                        'GF' => 'Guyane franÃ§aise',
                        'HT' => 'HaÃ¯ti',
                        'HM' => 'Heard-et-MacDonald, ÃŽles',
                        'HN' => 'Honduras',
                        'HK' => 'Hong Kong',
                        'HU' => 'Hongrie',
                        'IM' => 'ÃŽle De Man',
                        'UM' => 'ÃŽles mineures Ã©loignÃ©es des Ã‰tats-Unis',
                        'VG' => 'ÃŽles Vierges britanniques',
                        'VI' => 'ÃŽles Vierges des Ã‰tats-Unis',
                        'IN' => 'Inde',
                        'ID' => 'IndonÃ©sie',
                        'IR' => 'Iran',
                        'IQ' => 'Iraq',
                        'IE' => 'Irlande',
                        'IS' => 'Islande',
                        'IL' => 'IsraÃ«l',
                        'IT' => 'Italie',
                        'JM' => 'JamaÃ¯que',
                        'JP' => 'Japon',
                        'JE' => 'Jersey',
                        'JO' => 'Jordanie',
                        'KZ' => 'Kazakhstan',
                        'KE' => 'Kenya',
                        'KG' => 'Kirghizistan',
                        'KI' => 'Kiribati',
                        'KW' => 'KoweÃ¯t',
                        'LA' => 'Laos',
                        'LS' => 'Lesotho',
                        'LV' => 'Lettonie',
                        'LB' => 'Liban',
                        'LR' => 'LibÃ©ria',
                        'LY' => 'Libye',
                        'LI' => 'Liechtenstein',
                        'LT' => 'Lituanie',
                        'LU' => 'Luxembourg',
                        'MO' => 'Macao',
                        'MK' => 'MacÃ©doine',
                        'MG' => 'Madagascar',
                        'MY' => 'Malaisie',
                        'MW' => 'Malawi',
                        'MV' => 'Maldives',
                        'ML' => 'Mali',
                        'MT' => 'Malte',
                        'MP' => 'Mariannes du Nord, ÃŽles',
                        'MA' => 'Maroc',
                        'MH' => 'Marshall, ÃŽles',
                        'MQ' => 'Martinique',
                        'MU' => 'Maurice',
                        'MR' => 'Mauritanie',
                        'YT' => 'Mayotte',
                        'MX' => 'Mexique',
                        'FM' => 'MicronÃ©sie, Ã‰tats fÃ©dÃ©rÃ©s de',
                        'MD' => 'Moldavie',
                        'MC' => 'Monaco',
                        'MN' => 'Mongolie',
                        'ME' => 'MontÃ©nÃ©gro',
                        'MS' => 'Montserrat',
                        'MZ' => 'Mozambique',
                        'MM' => 'Myanmar',
                        'NA' => 'Namibie',
                        'NR' => 'Nauru',
                        'NP' => 'NÃ©pal',
                        'NI' => 'Nicaragua',
                        'NE' => 'Niger',
                        'NG' => 'NigÃ©ria',
                        'NU' => 'NiuÃ©',
                        'NF' => 'Norfolk, ÃŽle',
                        'NO' => 'NorvÃ¨ge',
                        'NC' => 'Nouvelle-CalÃ©donie',
                        'NZ' => 'Nouvelle-ZÃ©lande',
                        'IO' => 'Territoire britannique de l\'OcÃ©an Indien',
                        'OM' => 'Oman',
                        'UG' => 'Ouganda',
                        'UZ' => 'OuzbÃ©kistan',
                        'PK' => 'Pakistan',
                        'PW' => 'Palaos',
                        'PS' => 'Palestine, Etat de',
                        'PA' => 'Panama',
                        'PG' => 'Papouasie-Nouvelle-GuinÃ©e',
                        'PY' => 'Paraguay',
                        'NL' => 'Pays-Bas',
                        'PE' => 'PÃ©rou',
                        'PH' => 'Philippines',
                        'PN' => 'Pitcairn',
                        'PL' => 'Pologne',
                        'PF' => 'PolynÃ©sie franÃ§aise',
                        'PR' => 'Porto Rico',
                        'PT' => 'Portugal',
                        'QA' => 'Qatar',
                        'RE' => 'RÃ©union',
                        'RO' => 'Roumanie',
                        'GB' => 'Royaume-Uni',
                        'RU' => 'Russie',
                        'RW' => 'Rwanda',
                        'EH' => 'Sahara Occidental',
                        'BL' => 'Saint-BarthÃ©lemy',
                        'SH' => 'Sainte-HÃ©lÃ¨ne',
                        'LC' => 'Sainte-Lucie',
                        'KN' => 'Saint-Kitts-Et-Nevis',
                        'SM' => 'Saint-Marin',
                        'MF' => 'Saint-Martin (Antilles franÃ§aises)',
                        'SX' => 'Saint-Martin (Royaume des Pays-Bas)',
                        'PM' => 'Saint-Pierre-Et-Miquelon',
                        'VA' => 'Vatican, Ã‰tat de la CitÃ© du',
                        'VC' => 'Saint-Vincent-et-les Grenadines',
                        'SB' => 'Salomon, ÃŽles',
                        'WS' => 'Samoa',
                        'AS' => 'Samoa amÃ©ricaines',
                        'ST' => 'Sao TomÃ©-et-Principe',
                        'SN' => 'SÃ©nÃ©gal',
                        'RS' => 'Serbie',
                        'SC' => 'Seychelles',
                        'SL' => 'Sierra Leone',
                        'SG' => 'Singapour',
                        'SK' => 'Slovaquie',
                        'SI' => 'SlovÃ©nie',
                        'SO' => 'Somalie',
                        'SD' => 'Soudan',
                        'SS' => 'Soudan du Sud',
                        'LK' => 'Sri Lanka',
                        'SE' => 'SuÃ¨de',
                        'CH' => 'Suisse',
                        'SR' => 'Suriname',
                        'SJ' => 'Svalbard et Jan Mayen',
                        'SZ' => 'Swaziland',
                        'SY' => 'Syrie',
                        'TJ' => 'Tadjikistan',
                        'TW' => 'TaÃ¯wan',
                        'TZ' => 'Tanzanie',
                        'TD' => 'Tchad',
                        'CZ' => 'RÃ©publique TchÃ¨que',
                        'TF' => 'Terres australes et antarctiques franÃ§aises',
                        'TH' => 'ThaÃ¯lande',
                        'TL' => 'Timor Oriental',
                        'TG' => 'Togo',
                        'TK' => 'Tokelau',
                        'TO' => 'Tonga',
                        'TT' => 'TrinitÃ©-et-Tobago',
                        'TN' => 'Tunisie',
                        'TM' => 'TurkmÃ©nistan',
                        'TC' => 'Turks-et-CaÃ¯cos, ÃŽles',
                        'TR' => 'Turquie',
                        'TV' => 'Tuvalu',
                        'UA' => 'Ukraine',
                        'UY' => 'Uruguay',
                        'VU' => 'Vanuatu',
                        'VE' => 'Venezuela',
                        'VN' => 'ViÃªt Nam',
                        'WF' => 'Wallis et Futuna',
                        'YE' => 'YÃ©men',
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
            </div>
        </div>
    </fieldset>


    <?php

} // end func



function remove_product_page_skus( $enabled ) {
    if ( ! is_admin() && is_product() ) {
        return false;
    }

    return $enabled;
}
add_filter( 'wc_product_sku_enabled', 'remove_product_page_skus' );



function remove_product_page_dimensions( $enabled ) {
    if ( ! is_admin() && is_product() ) {
        return false;
    }

    return $enabled;
}
add_filter( 'wc_product_dimensions_enabled', 'remove_product_page_dimensions' );



function remove_product_page_weight( $enabled ) {
    if ( ! is_admin() && is_product() ) {
        return false;
    }

    return $enabled;
}
add_filter( 'wc_product_weight_enabled', 'remove_product_page_weight' );



add_action( 'techmarket_single_product_meta', 'techmarket_single_product_meta_description', 20 );

function techmarket_single_product_meta_description() {

}




/*add_action( 'woocommerce_single_product_summary', 'product_page_payment_services_details', 70 );

function product_page_payment_services_details() {
    echo '
    <div id="servicesLuzus">
        <img style="display: inline-block; margin-right:5px;" src="https://www.luzus.fr/wp-content/uploads/2018/03/check.svg" width="25px" title="Logo-Protection-Luzus"/>
        <a class="linkDark" style="display: inline-block; font-size: 1.1em; font-family: var(--font-family1); font-weight: bold;" href="/comment-ca-marche/" title="">Protection garantie par Luzus</a>
        <ul>
            <li>Achats en ligne 100% sÃ©curisÃ©s</li>
            <li>Paiement dÃ©clenchÃ© aprÃ¨s rÃ©ception du produit</li>
            <li>Remboursement intÃ©gral des objets non-conformes</li>
            <li>Service clients par chat ou email</li>
        </ul>
    </div>';
    return;
}*/



/* FORUM FUNCTIONS */

function show_forum_role($user_id) {

    $asgarosforum = new AsgarosForum;
    $countPostByUser = $asgarosforum->countPostsByUser($user_id);
    $countTopicsByUser = $countPostByUser - count($asgarosforum->getTopicsByUser($user_id));

    if ( AsgarosForumPermissions::getForumRole($user_id)==='Administrateur' ) :
        echo '<br><span class="forum_role" style="color:#084399; " ><a href="https://luzus.fr" title="LUZUS.fr"><img style="display: inline-block" src="https://www.luzus.fr/wp-content/uploads/2017/10/LUZUS-Logo.svg" width="20px" /></a> <p style="display: inline-block; font-family: Francois One, Oxygen, Arial;">Admin</p></span>';

    elseif ( AsgarosForumPermissions::getForumRole($user_id)==='Utilisateur' && $countTopicsByUser >= 20 && $countPostByUser >= 100 ) :
        echo '<br><span class="forum_role" style="color: #3ab5e7;" ><i class="fa fa-rocket"></i> lvl 5</span>';

    elseif ( AsgarosForumPermissions::getForumRole($user_id)==='Utilisateur' && $countTopicsByUser >= 15 && $countPostByUser >= 60 ) :
        echo '<br><span class="forum_role" style="color: #333333;" ><i class="fa fa-trophy"></i> lvl 4</span>';

    elseif ( AsgarosForumPermissions::getForumRole($user_id)==='Utilisateur' && $countTopicsByUser >= 5 && $countPostByUser >= 25 ) :
        echo '<br><span class="forum_role" style="color: #333333;" ><i class="fa fa-shield-alt"></i> lvl 3</span>';

    elseif ( AsgarosForumPermissions::getForumRole($user_id)==='Utilisateur' && $countTopicsByUser >= 1 && $countPostByUser >= 10 ) :
        echo '<br><span class="forum_role" style="color: #333333;" ><i class="fa fa-user-plus"></i> lvl 2</span>';

    elseif ( AsgarosForumPermissions::getForumRole($user_id)==='Utilisateur' && $countTopicsByUser >= 0 && $countPostByUser >= 0 ) :
        echo '<br><span class="forum_role" style="color: #333333;" ><i class="fa fa-user"></i> lvl 1</span>';

    else :

        return;

    endif;

}

add_action('asgarosforum_after_post_author', 'show_forum_role', 10, 2);



function show_user_profil_role($user_id) {

    $user_id = $_GET['id'];
    $nickname = get_userdata( $user_id ) -> nickname;
    $user_meta = get_user_meta ($user_id);

    if ( AsgarosForumPermissions::getForumRole($user_id)==='Administrateur' ) :
        $lvl = '<a href="https://luzus.fr" title="LUZUS.fr"><img style="display: inline-block" src="https://www.luzus.fr/wp-content/uploads/2017/10/LUZUS-Logo.svg" width="20px" /></a></span><span style=" display: table-cell;"><p style="font-family: Oxygen, Arial; margin-bottom:0; font-style: normal !important;">Admin</p></span>';

    elseif ( AsgarosForumPermissions::getForumRole($user_id)==='Utilisateur' && $countTopicsByUser >= 20 && $countPostByUser >= 100 ) :
        $lvl = '<i class="fa fa-rocket"></i></span><span style=" display: table-cell;"><p style="font-family: Oxygen, Arial; margin-bottom:0; font-style: normal !important;">lvl 5</p></span>';

    elseif ( AsgarosForumPermissions::getForumRole($user_id)==='Utilisateur' && $countTopicsByUser >= 15 && $countPostByUser >= 60 ) :
        $lvl = '<i class="fa fa-trophy"></i></span><span style=" display: table-cell;"><p style="font-family: Oxygen, Arial; margin-bottom:0; font-style: normal !important;">lvl 4</p></span>';

    elseif ( AsgarosForumPermissions::getForumRole($user_id)==='Utilisateur' && $countTopicsByUser >= 5 && $countPostByUser >= 25 ) :
        $lvl = '<i class="fa fa-shield"></i></span><span style=" display: table-cell;"><p style="font-family: Oxygen, Arial; margin-bottom:0; font-style: normal !important;">lvl 3</p></span>';

    elseif ( AsgarosForumPermissions::getForumRole($user_id)==='Utilisateur' && $countTopicsByUser >= 1 && $countPostByUser >= 10 ) :
        $lvl = '<i class="fa fa-user-plus"></i></span><span style=" display: table-cell;"><p style="font-family: Oxygen, Arial; margin-bottom:0; font-style: normal !important;">lvl 2</p></span>';

    elseif ( AsgarosForumPermissions::getForumRole($user_id)==='Utilisateur' && $countTopicsByUser >= 0 && $countPostByUser >= 0 ) :
        $lvl = '<i class="fa fa-user"></i></span><span style=" display: table-cell;"><p style="font-family: Oxygen, Arial; margin-bottom:0; font-style: normal !important;">lvl 1</p></span>';

    else :
        return;

    endif ;

    /* -- Ã¢Ë†â€  -- User Role -- Ã¢Ë†â€  -- */

    ?><hr style="margin-top: 20px;"><?php

    if ( AsgarosForumPermissions::getForumRole($user_id) === 'Administrateur' || AsgarosForumPermissions::getForumRole($user_id) === 'Utilisateur'  ) :

        echo '<div style="color:#333333; " ><span style=" width: 30px; display: table-cell; margin-right: 5px">' . $lvl . '</div>';

    endif ;


    /* -- Ã¢Ë†â€˜ -- End User Role -- Ã¢Ë†â€˜ -- */

    /* -- Ã¢Ë†â€  -- User City -- Ã¢Ë†â€  -- */

    if ( !empty($user_meta [billing_city][0] ) ) :

        echo '<span style=" width: 30px; display: table-cell; margin-right: 5px"><i class="fa fa-map-marker"></i></span><span style=" display: table-cell;">' . $user_meta [billing_city][0] . '</span>';

    endif;

    /* -- Ã¢Ë†â€˜ -- End User City -- Ã¢Ë†â€˜ -- */

    /* -- Ã¢Ë†â€  -- User Store -- Ã¢Ë†â€  -- */

    if ( AsgarosForumPermissions::getForumRole($user_id) === 'Utilisateur' ) :

        printf( '<div><span style=" width: 30px; display: table-cell; margin-right: 5px"><i id="shopping_bag_forum_profile" class="fa fa-shopping-bag"></i></span><span style=" display: table-cell;"><a style="font-style: normal !important" title="Voir la boutique de ' . $nickname . '" href="%s">%s</a>', dokan_get_store_url( $user_id ), 'Voir la boutique de ' . $nickname . '</span></div>' ) ;

    endif;

    /* -- Ã¢Ë†â€˜ -- End User Store -- Ã¢Ë†â€˜ -- */
}

add_action('asgarosforum_custom_profile_content', 'show_user_profil_role', 10, 2);



function auto_subscribe($postID, $topicID) {
    AsgarosForumNotifications::subscribeTopic();
}
add_action('asgarosforum_after_add_thread_submit', 'auto_subscribe', 10, 2);

/* END FORUM FUNCTIONS */














/**
 * Enqueue our Scripts and Styles Properly
 */
function theme_enqueue() {

    $theme_url  = get_template_directory_uri();     // Used to keep our Template Directory URL
    $ajax_url   = admin_url( 'admin-ajax.php' );        // Localized AJAX URL

    // Register Our Script for Localization
    wp_register_script(
        'um-modifications',                             // Our Custom Handle
        "{$theme_url}-child/js/edit-account.js",  // Script URL, this script is located for me in `theme-name/scripts/um-modifications.js`
        array( 'jquery' ),                              // Dependant Array
        '1.0',                                          // Script Version ( Arbitrary )
        true                                            // Enqueue in Footer
    );

    // Localize Our Script so we can use `ajax_url`
    wp_localize_script(
        'um-modifications',
        'ajax_url',
        $ajax_url
    );

    // Finally enqueue our script
    wp_enqueue_script( 'um-modifications' );
}
add_action( 'wp_enqueue_scripts', 'theme_enqueue' );



/**
 * AJAX Callback
 * Always Echos and Exits
 */
function um_modifications_callback() {

    // Ensure we have the data we need to continue
    if( ! isset( $_POST ) || empty( $_POST ) || ! is_user_logged_in() ) {

        // If we don't - return custom error message and exit
        header( 'HTTP/1.1 400 Empty POST Values' );
        echo 'Could Not Verify POST Values.';
        exit;
    }

    $user_id        = get_current_user_id();                            // Get our current user ID
    $user_nicename  = sanitize_user( $_POST['user_nicename'] );
    $first_name     = sanitize_text_field( $_POST['first_name'] );
    $last_name      = sanitize_text_field( $_POST['last_name'] );      // Sanitize our user meta value
    $user_email     = sanitize_email( $_POST['user_email'] );
    $billing_phone  = sanitize_text_field( $_POST['billing_phone'] );
    $user_description = sanitize_text_field( $_POST['user_description'] );

    if ( isset( $_POST['_mc4wp_review_notice_dismissed'] ) && $_POST['_mc4wp_review_notice_dismissed'] == 1 ) {
        $mc4wp_review = 1;
    } else {
        $mc4wp_review = 0;
    }

    if (!empty($user_id) && !empty($user_nicename) && !empty($first_name) && !empty($last_name) && !empty($user_email)) {

        // Sanitize our user email field

        update_user_meta( $user_id, 'nickname', ucfirst($user_nicename) );
        update_user_meta( $user_id, 'first_name', ucfirst($first_name) ); // Update our user meta
        update_user_meta( $user_id, 'last_name', ucfirst($last_name) );
        update_user_meta( $user_id, '_mc4wp_review_notice_dismissed', $mc4wp_review );
        update_user_meta( $user_id, 'billing_email', $user_email );
        update_user_meta( $user_id, 'billing_phone', $billing_phone );
        update_user_meta( $user_id, 'user_description', ucfirst($user_description) );

        wp_update_user( array(
            'ID'            => $user_id,
            'user_email'    => $user_email,
            'user_nicename' => $user_nicename,
            'display_name'  => ucfirst($user_nicename),
            '_mc4wp_review_notice_dismissed' => $mc4wp_review,
        ));

        $message = '<i class="fa fa-check"></i> Vos informations ont Ã©tÃ© mises Ã Â jour.';
        $return = array('message' => $message);
        wp_json_encode ($return, 1);
        return wp_send_json_success($return);

    } elseif (!empty($user_id) || !empty($user_nicename) || !empty($first_name) || !empty($last_name) || !empty($user_email)) {

        $message = '<i class="fa fa-times"></i> Veuillez remplir tous les champs requis marquÃ©s par un *';
        $return = array('message' => $message);
        wp_json_encode ($return, 1);
        return wp_send_json_error($return);
    }

    exit;
}
add_action( 'wp_ajax_nopriv_um_cb', 'um_modifications_callback' );
add_action( 'wp_ajax_um_cb', 'um_modifications_callback' );


function um_edit_billing_address_callback() {

    // Ensure we have the data we need to continue
    if( ! isset( $_POST ) || empty( $_POST ) || ! is_user_logged_in() ) {

        // If we don't - return custom error message and exit
        header( 'HTTP/1.1 400 Empty POST Values' );
        echo 'Could Not Verify POST Values.';
        exit;
    }

    $user_id        = get_current_user_id();
    $billing_first_name     = sanitize_text_field( $_POST['billing_first_name'] );
    $billing_last_name      = sanitize_text_field( $_POST['billing_last_name'] );
    $billing_address_1      = sanitize_text_field( $_POST['billing_address_1'] );
    $billing_address_2      = sanitize_text_field( $_POST['billing_address_2'] );
    $billing_postcode       = sanitize_text_field( $_POST['billing_postcode'] );
    $billing_city           = sanitize_text_field( $_POST['billing_city'] );

    if ( !empty($user_id) && !empty($billing_first_name) && !empty($billing_last_name) && !empty($billing_address_1) && !empty($billing_postcode) && !empty($billing_city) ){

        update_user_meta( $user_id, 'billing_first_name', ucfirst($billing_first_name) );
        update_user_meta( $user_id, 'billing_last_name', ucfirst($billing_last_name) );
        update_user_meta( $user_id, 'billing_address_1', ucfirst($billing_address_1) );
        update_user_meta( $user_id, 'billing_address_2', ucfirst($billing_address_2) );
        update_user_meta( $user_id, 'billing_postcode', $billing_postcode );
        update_user_meta( $user_id, 'billing_city', ucfirst($billing_city) );

        wp_update_user( array(
            'ID' => $user_id,
        ) );

        $message = '<i class="fa fa-check"></i> Vos informations ont Ã©tÃ© mises Ã  jour.';
        $return = array('message' => $message);
        wp_json_encode ($return, 1);
        return wp_send_json_success($return);

    } elseif (!empty($user_id) || !empty($billing_first_name) || !empty($billing_last_name) || !empty($billing_address_1) || !empty($billing_postcode) || !empty($billing_city) ) {

        $message = '<i class="fa fa-times"></i> Veuillez remplir tous les champs requis marquÃ©s par un *';
        $return = array('message' => $message);
        wp_json_encode ($return, 1);
        return wp_send_json_error($return);
    }

    exit;
}
add_action( 'wp_ajax_nopriv_um_edit_billing', 'um_edit_billing_address_callback' );
add_action( 'wp_ajax_um_edit_billing', 'um_edit_billing_address_callback' );


function um_edit_shipping_address_callback() {

    // Ensure we have the data we need to continue
    if( ! isset( $_POST ) || empty( $_POST ) || ! is_user_logged_in() ) {

        // If we don't - return custom error message and exit
        header( 'HTTP/1.1 400 Empty POST Values' );
        echo 'Could Not Verify POST Values.';
        exit;
    }

    $user_id        = get_current_user_id();
    $shipping_first_name     = sanitize_text_field( $_POST['shipping_first_name'] );
    $shipping_last_name      = sanitize_text_field( $_POST['shipping_last_name'] );
    $shipping_address_1      = sanitize_text_field( $_POST['shipping_address_1'] );
    $shipping_address_2      = sanitize_text_field( $_POST['shipping_address_2'] );
    $shipping_postcode       = sanitize_text_field( $_POST['shipping_postcode'] );
    $shipping_city           = sanitize_text_field( $_POST['shipping_city'] );


    if ( !empty($user_id) && !empty($shipping_first_name) && !empty($shipping_last_name) && !empty($shipping_address_1) && !empty($shipping_postcode) && !empty($shipping_city) ) {

        update_user_meta( $user_id, 'shipping_first_name', ucfirst($shipping_first_name) );
        update_user_meta( $user_id, 'shipping_last_name', ucfirst($shipping_last_name) );
        update_user_meta( $user_id, 'shipping_address_1', ucfirst($shipping_address_1) );
        update_user_meta( $user_id, 'shipping_address_2', ucfirst($shipping_address_2) );
        update_user_meta( $user_id, 'shipping_postcode', $shipping_postcode );
        update_user_meta( $user_id, 'shipping_city', ucfirst($shipping_city) );

        wp_update_user( array(
            'ID' => $user_id,
        ) );

        $message = '<i class="fa fa-check"></i> Vos informations ont Ã©tÃ© mises Ã Â  jour.';
        $return = array('message' => $message);
        wp_json_encode ($return, 1);
        return wp_send_json_success($return);

    } elseif ( !empty($user_id) || !empty($shipping_first_name) || !empty($shipping_last_name) || !empty($shipping_address_1) || !empty($shipping_postcode) || !empty($shipping_city) ) {
        $message = '<i class="fa fa-times"></i> Veuillez remplir tous les champs requis marquÃ©s par un *';
        $return = array('message' => $message);
        wp_json_encode ($return, 1);
        return wp_send_json_error($return);
    }
    
    exit;
}
add_action( 'wp_ajax_nopriv_um_edit_shipping', 'um_edit_shipping_address_callback' );
add_action( 'wp_ajax_um_edit_shipping', 'um_edit_shipping_address_callback' );


function um_edit_password_callback() {

    // Ensure we have the data we need to continue
    if( ! isset( $_POST ) || empty( $_POST ) || ! is_user_logged_in() ) {

        // If we don't - return custom error message and exit
        header( 'HTTP/1.1 400 Empty POST Values' );
        echo 'Could Not Verify POST Values.';
        exit;
    }


    $user_id      = get_current_user_id();
    $current_user = get_user_by( 'id', $user_id );
    $user_info = get_userdata($user_id);
    $save_pass    = true;
    $pass_cur     = !empty( $_POST['old_password'] ) ? $_POST['old_password'] : '';
    $pass1        = !empty( $_POST['password'] ) ? $_POST['password'] : '';
    $pass2        = !empty( $_POST['confirm_password'] ) ? $_POST['confirm_password'] : '';


    if ( !empty( $pass1 ) && !wp_check_password( $pass_cur, $current_user->user_pass, $current_user->ID ) ) {
        $message = '<i class="fa fa-times"></i> Votre mot de passe actuel est erronÃ©.';
        $return = array('message' => $message);

        wp_json_encode ($return, 1);
        return wp_send_json_error($return);
        $save_pass = false;
    }

    if ( empty( $pass_cur ) && empty( $pass1 ) && empty( $pass2 ) ) {
        $message = '<i class="fa fa-times"></i> Merci de renseigner tous les champs.';
        $return = array('message' => $message);

        wp_json_encode ($return, 1);
        return wp_send_json_error($return);
        $save_pass = false;

    } else if ( !empty( $pass_cur ) && empty( $pass1 ) && empty( $pass2 ) ) {
        $message = '<i class="fa fa-times"></i> Merci de renseigner tous les champs.';
        $return = array('message' => $message);

        wp_json_encode ($return, 1);
        return wp_send_json_error($return);
        $save_pass = false;
    } elseif ( !empty( $pass1 ) && empty( $pass_cur ) ) {
        $message = '<i class="fa fa-times"></i> Merci de renseigner votre mot de passe actuel.';
        $return = array('message' => $message);

        wp_json_encode ($return, 1);
        return wp_send_json_error($return);
        $save_pass = false;
    } elseif ( !empty( $pass1 ) && empty( $pass2 ) ) {
        $message = '<i class="fa fa-times"></i> Merci de ressaisir votre nouveau mot de passe.';
        $return = array('message' => $message);

        wp_json_encode ($return, 1);
        return wp_send_json_error($return);
        $save_pass = false;
    } elseif ( (!empty( $pass1 ) || !empty( $pass2 ) ) && $pass1 !== $pass2 ) {
        $message = '<i class="fa fa-times"></i> Les champs du nouveau mot de passe ne correspondent pas.';
        $return = array('message' => $message);

        wp_json_encode ($return, 1);
        return wp_send_json_error($return);
        $save_pass = false;
    }

    if ( $pass1 && $save_pass ) {

        if (preg_match('#^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).{8,}$#', $pass1)) {

            $user->user_pass = $pass1;

            wp_update_user( array(
                'ID' => $user_id,
                'user_pass' => $user->user_pass,
            ) );

            $message = '<i class="fa fa-check"></i> Votre mot de passe a Ã©tÃ© modifiÃ© avec succÃ¨s.';
            $return = array('message' => $message);
            wp_json_encode ($return, 1);
            return wp_send_json_success($return);

        } else {

            $message = '<i class="fa fa-times"></i> Votre nouveau mot de passe doit contenir :<ul><li>Minimum 8 caractÃ¨res</li><li>Au moins une minuscule</li><li>Au moins une majuscule</li><li>Au moins un chiffre</li></ul>';
            $return = array('message' => $message);
            wp_json_encode ($return, 1);
            return wp_send_json_error($return);
        }

    }

    exit;
}
add_action( 'wp_ajax_nopriv_um_edit_password', 'um_edit_password_callback' );
add_action( 'wp_ajax_um_edit_password', 'um_edit_password_callback' );


/**
 * This is to save user input into database
 * hook: woocommerce_save_account_details
 */
add_action('woocommerce_save_account_details', 'my_woocommerce_save_account_details');

function my_woocommerce_save_account_details($user_id)
{
    update_user_meta($user_id, 'user_birthday', htmlentities($_POST['user_birthday']));
    update_user_meta($user_id, 'user_nationality', htmlentities($_POST['user_nationality']));
} // end func

/**
 * Load DatePicker
 */
function enqueueDatePicker()
{

    wp_enqueue_script('jquery-ui-datepicker');
}

add_action('wp_enqueue_scripts', 'enqueueDatePicker', 100);

/**
 * Pass the required AJAX WordPress URL into scripts.
 *
 * @author Lucas StrÃ Â¼bi <lucas.strubi@gmail.com>
 */
function enqueueNewProductScripts()
{

    wp_enqueue_script('new-products-scripts', get_stylesheet_directory_uri() . '/js/new-products-scripts.js', array('jquery'), '', true);

    wp_localize_script('new-products-scripts', 'ajaxurl', admin_url('admin-ajax.php'));

    wp_enqueue_script('register_form_script', get_stylesheet_directory_uri() . '/js/register_form_script.js', array('jquery'), '', true);

    wp_enqueue_script('pay-in-wallet', get_stylesheet_directory_uri() . '/js/pay-in-wallet.js', array('jquery'), '', true);

}

add_action('wp_enqueue_scripts', 'enqueueNewProductScripts', 100);


/*
 * Mise Ã Â  jour de mangopay-woocommerce dÃ©sactivÃ©e
 */

function stop_plugin_update( $value ) {
    unset( $value->response['mangopay-woocommerce/mangopay-woocommerce.php'] );
    return $value;
}
add_filter( 'site_transient_update_plugins', 'stop_plugin_update' );

/*
 *  Gestion du formulaire d'inscription
 */


function wpblog_save_register_fields($customer_id)
{
    if (isset($_POST['username'])) {
        update_user_meta($customer_id, 'username', sanitize_text_field($_POST['username']));
        update_user_meta($customer_id, 'user_nicename', sanitize_text_field($_POST['username']));
        update_user_meta($customer_id, 'display_name', sanitize_text_field($_POST['username']));
        update_user_meta($customer_id, 'nickname', sanitize_text_field($_POST['username']));
        update_user_meta($customer_id, 'store_name', sanitize_text_field($_POST['username']));
    }
    if (isset($_POST['billing_first_name'])) {
        update_user_meta($customer_id, 'billing_first_name', sanitize_text_field($_POST['billing_first_name']));
    }
    if (isset($_POST['billing_last_name'])) {
        update_user_meta($customer_id, 'billing_last_name', sanitize_text_field($_POST['billing_last_name']));
    }
    if (isset($_POST['user_birthday'])) {
        update_user_meta($customer_id, 'user_birthday', sanitize_text_field($_POST['user_birthday']));
    }
    if (isset($_POST['user_mp_status'])) {
        update_user_meta($customer_id, 'user_mp_status', sanitize_text_field($_POST['user_mp_status']));
    }
}

add_action('woocommerce_created_customer', 'wpblog_save_register_fields');

remove_action('register_form', 'dokan_seller_reg_form_fields');

// validation formulaire

function wooc_validate_extra_register_fields( $username, $email, $validation_errors ) {
    extract( $_POST );

    $age = (time() - strtotime($user_birthday)) / 3600 / 24 / 365;

    $strtotime = strtotime($user_birthday);

    if(!preg_match( '`^\d{1,2}/\d{1,2}/\d{4}$`' , $user_birthday )) {
        $validation_errors->add( 'user_birthday_error', __('Veuillez entrer une date de naissance valide','woocommerce') );
    }
    if ($age < 18)
        $validation_errors->add( 'user_birthday_error', __('Vous devez Ãªtre majeur pour vous inscrire','woocommerce') );

    if ($user_nationality != "FR")
        $validation_errors->add( 'user_nationality_error', __('Vous devez rÃ©sider en France pour vous inscrire ' . $user_birthday,'woocommerce'));


    return $validation_errors;
}

add_action( 'woocommerce_register_post', 'wooc_validate_extra_register_fields', 10, 3 );

//suppression des validations de dokan sur l'inscription

remove_filter( 'woocommerce_process_registration_errors', 'dokan_seller_registration_errors');
remove_filter( 'woocommerce_registration_errors', 'dokan_seller_registration_errors' );


/*
 *  Gestion de la page 'myaccount'
 */

// suppression des champs par defaut
add_filter( 'woocommerce_save_account_details_required_fields' ,
    'smtl_edit_account_remove_required_names' );

function smtl_edit_account_remove_required_names( $fields ) {
    unset($fields['account_first_name']);
    unset($fields['account_last_name']);
    return $fields;
}

// add the action 
add_action( 'woocommerce_save_account_details', 'action_woocommerce_save_account_details', 10, 1 );


// injection du shortcode wallet
include('mp_wallet.php');

include('functions-strubi.php');



/* comission panier */

add_action( 'woocommerce_cart_calculate_fees','woocommerce_custom_surcharge' );
function woocommerce_custom_surcharge() {
    global $woocommerce;

    if ( is_admin() && ! defined( 'DOING_AJAX' ) )
        return;

    $percentage = 0.05;
    $surcharge = (( $woocommerce->cart->cart_contents_total + $woocommerce->cart->shipping_total ) * $percentage) + 0.75;
    //$surcharge =  $surcharge > 50 ? 50.00 : $surcharge;
    $woocommerce->cart->add_fee("Frais de service", $surcharge, true, '' );

}


/* redirection aprÃ¨s inscription/connexion */

function custom_registration_redirect_after_registration() {
    return home_url('/mon-compte');
}
add_action('woocommerce_registration_redirect', 'custom_registration_redirect_after_registration', 1);


function custom_login_redirect_after_login() {
    return home_url('/mon-compte');
}

add_filter('woocommerce_login_redirect', 'custom_login_redirect_after_login', 1);


/* woocommerce vente individuel */

/*function default_no_quantities( $individually, $product ){
    $individually = true;
    return $individually;
}
add_filter( 'woocommerce_is_sold_individually', 'default_no_quantities', 10, 2 );*/

/** * @desc Remove in all product type */
function woo_remove_all_quantity_fields( $return, $product ) {
    return true;
}
add_filter( 'woocommerce_is_sold_individually', 'woo_remove_all_quantity_fields', 10, 2 );



/* attribut produit vendu ou non */

function add_sold_attr($post_id) {
    update_post_meta($post_id, 'pa_sold', 'false');

}

add_action('dokan_new_product_added', 'add_sold_attr', 10, 3);


/* modification action ajout tracking order */
remove_action('wp_ajax_dokan_add_shipping_tracking_info', array( $this, 'add_shipping_tracking_info' ));
add_action('wp_ajax_dokan_add_shipping_tracking_info', 'new_action_add_shipping');

function new_action_add_shipping() {

    if ( isset( $_POST['dokan_security_nonce'] ) && !wp_verify_nonce( sanitize_key( $_POST['dokan_security_nonce'] ), 'dokan_security_action' ) ) {
        die(-1);
    }

    if ( !is_user_logged_in() ) {
        die(-1);
    }
    if ( ! current_user_can( 'dokan_manage_order_note' ) ) {
        die(-1);
    }

    $post_id           = absint( $_POST['post_id'] );
    $shipping_provider = $_POST['shipping_provider'];
    $shipping_number   = ( trim( stripslashes( $_POST['shipping_number'] ) ) );
    $shipped_date      = ( trim( $_POST['shipped_date'] ) );

    $ship_info = 'Ajout du numÃ©ro de suivi: ' . $shipping_number . '<br />';

    if ( $shipping_number == '' ){
        die();
    }

    if ( $post_id > 0 ) {
        $order      = wc_get_order( $post_id );
        //$comment_id = $order->add_order_note( $note, $is_customer_note );

        $time = current_time('mysql');

        $data = array(
            'comment_post_ID'      => $post_id,
            'comment_author'       => 'WooCommerce',
            'comment_author_email' => '',
            'comment_author_url'   => '',
            'comment_content'      => $ship_info,
            'comment_type'         => 'order_note',
            'comment_parent'       => 0,
            'user_id'              => dokan_get_current_user_id(),
            'comment_author_IP'    => $_SERVER['REMOTE_ADDR'],
            'comment_agent'        => $_SERVER['HTTP_USER_AGENT'],
            'comment_date'         => $time,
            'comment_approved'     => 1,
        );

        $comment_id = wp_insert_comment($data);

        update_comment_meta($comment_id, 'is_customer_note', true);

        do_action( 'woocommerce_new_customer_note', array( 'order_id' => dokan_get_prop( $order, 'id' ), 'customer_note' => $ship_info ) );

        update_post_meta($post_id, "shipping-track", $shipping_number);

        echo '<li rel="' . esc_attr( $comment_id ) . '" class="note ';
        //if ( $is_customer_note ) {
        echo 'customer-note';
        //}
        echo '"><div class="note_content">';
        echo wpautop( wptexturize( $ship_info ) );
        echo '</div><p class="meta"><a href="#" class="delete_note">'.__( 'Delete', 'dokan-lite' ).'</a></p>';
        echo '</li>';

        do_action( 'dokan_order_tracking_updated', $post_id, dokan_get_current_user_id() );
    }

    // Quit out
    die();
}

/* update bankwire mango ajax */

function updateAccountBankWire() {

    $mp = mpAccess::getInstance();
    $user_id = get_current_user_id();
    $mp_user_id = $mp->set_mp_user($user_id);


    $wallets = $mp->set_mp_wallet( $mp_user_id );

    $test = $mp->save_bank_account($mp_user_id,
        $user_id,
        0,
        "IBAN",
        $_POST['user_bank_name'],
        $_POST['user_bank_adress_f'],
        $_POST['user_bank_adress_s'],
        $_POST['user_bank_city'],
        $_POST['user_bank_postal'],
        $_POST['user_bank_city'],
        "FR",
        ["IBAN" => $_POST['user_bank_iban'], "BIC" => $_POST['user_bank_bic']],
        []
    );


    var_dump($test);

    die();
}

add_action( 'wp_ajax_update_account_bank_wire', 'updateAccountBankWire' );
add_action( 'wp_ajax_nopriv_update_account_bank_wire', 'updateAccountBankWire' );



function addCompareIconOnProductListing () {
    $yithCompare = new YITH_Woocompare_Frontend;
	//var_dump($yithCompare);
	global $product;
	$productId = $product->id;
    ?>
        <div class="yith-wcwl-add-to-wishlist compareIcon">
        <?php $yithCompare->add_compare_link($productId, array('button_or_link' => 'link', 'button_text' => '<i class="tm tm-compare"></i>')); ?>
        </div>
    <?php
}

add_action ( 'woocommerce_before_shop_loop_item_title', 'addCompareIconOnProductListing' );









/* HELP CENTER - CENTRE D'AIDE */


function addNavigationHelpCenter () {

    $helpCenterContent = Array (
        'title' => Array ( 
            'Vendre sur Luzus', 
            'Acheter sur Luzus', 
            'Envoi & Livraison', 
            'Paiement & Transfert', 
            'Retours & Annulations', 
            'Evaluation & Notation', 
            'Confiance & SÃ©curitÃ©', 
            'Mon compte', 
            'Inscription & Connexion', 
            'Forum', 
            'Contact' ),

        'infos' => Array ( 
            'Les tips pour optimiser vos ventes !', 
            'Comment dÃ©nicher la perle rare ?', 
            'Les infos sur la logistique.', 
            'Comment payer ou rÃ©cupÃ©rer son argent.', 
            'Un problÃ¨me avec un produit ?' , 
            'Les dÃ©tails sur les petites Ã©toiles.', 
            'Notre objectif c\'est votre satisfaction.', 
            'Les dÃ©tails sur le paramÃ©trage de votre compte Luzus.',
            'Comment s\'inscrire ou se connecter, c\'est par ici.',
            'Utiliser de maniÃ¨re efficace le Forum !', 
            'La rÃ©ponse Ã  vos questions les plus spÃ©cifiques.' ),

        'iconUrl'  => Array ( 
            'https://www.luzus.fr/wp-content/uploads/2018/03/open-store.svg',
            'https://www.luzus.fr/wp-content/uploads/2018/04/bag.svg', 
            'https://www.luzus.fr/wp-content/uploads/2018/04/truck.svg',
            'https://www.luzus.fr/wp-content/uploads/2018/04/credit-card2.svg', 
            'https://www.luzus.fr/wp-content/uploads/2018/04/road-indications.svg',
            'https://www.luzus.fr/wp-content/uploads/2018/03/star.svg', 
            'https://www.luzus.fr/wp-content/uploads/2018/03/Field.svg', 
            'https://www.luzus.fr/wp-content/uploads/2018/03/smartphone.svg',
            'https://www.luzus.fr/wp-content/uploads/2018/04/devices.svg', 
            'https://www.luzus.fr/wp-content/uploads/2018/04/conversation-bubbles.svg', 
            'https://www.luzus.fr/wp-content/uploads/2018/04/writing.svg' ),
    );

    $helpCenterLink = Array (
        'name' => Array ( 'Plus d\'infos' ),
        'url'  => Array( 'vendre', 'acheter', 'envoi-livraison', 'paiement-transfert', 'retours-annulations', 'evaluation-notation' , 'confiance-securite', 'mon-compte', 'inscription-connexion', 'forum', 'contact' ),
    );

    $helpCenterArray = Array (
        'content' => $helpCenterContent ,
        'link'    => $helpCenterLink,
    );

    ?>
    <nav id="helpCenterMenu" class="nav flex-column">
        <?php for ($i = 0 ; $i < count ( $helpCenterArray['content']['title'] ); $i++) {
           echo '<a class="nav-link" href="https://luzus.fr/centre-aide/' . $helpCenterArray['link']['url'][$i] . '/">' . $helpCenterArray['content']['title'][$i] . '</a>';
        }?>
    </nav>
    <?php
}
add_shortcode('NavigationHelpCenter', 'addNavigationHelpCenter');


function addHelpCenterCards () {

    $helpCenterContent = Array (
        'title' => Array ( 
            'Vendre sur Luzus', 
            'Acheter sur Luzus', 
            'Envoi & Livraison', 
            'Paiement & Transfert', 
            'Retours & Annulations', 
            'Evaluation & Notation', 
            'Confiance & SÃ©curitÃ©', 
            'Mon compte', 
            'Inscription & Connexion', 
            'Forum', 
            'Contact' ),

        'infos' => Array ( 
            'Les tips pour optimiser vos ventes !', 
            'Comment dÃ©nicher la perle rare ?', 
            'Les infos sur la logistique.', 
            'Comment payer ou rÃ©cupÃ©rer son argent.', 
            'Un problÃ¨me avec un produit ?' , 
            'Les dÃ©tails sur les petites Ã©toiles.', 
            'Notre objectif c\'est votre satisfaction.', 
            'Les dÃ©tails sur le paramÃ©trage de votre compte Luzus.',
            'Comment s\'inscrire ou se connecter, c\'est par ici.',
            'Utiliser de maniÃ¨re efficace le Forum !', 
            'La rÃ©ponse Ã  vos questions les plus spÃ©cifiques.' ),

        'iconUrl'  => Array ( 
            'https://www.luzus.fr/wp-content/uploads/2018/03/open-store.svg',
            'https://www.luzus.fr/wp-content/uploads/2018/04/bag.svg', 
            'https://www.luzus.fr/wp-content/uploads/2018/04/truck.svg',
            'https://www.luzus.fr/wp-content/uploads/2018/04/credit-card2.svg', 
            'https://www.luzus.fr/wp-content/uploads/2018/04/road-indications.svg',
            'https://www.luzus.fr/wp-content/uploads/2018/03/star.svg', 
            'https://www.luzus.fr/wp-content/uploads/2018/03/Field.svg', 
            'https://www.luzus.fr/wp-content/uploads/2018/03/smartphone.svg',
            'https://www.luzus.fr/wp-content/uploads/2018/04/devices.svg', 
            'https://www.luzus.fr/wp-content/uploads/2018/04/conversation-bubbles.svg', 
            'https://www.luzus.fr/wp-content/uploads/2018/04/writing.svg' ),
    );

    $helpCenterLink = Array (
        'name' => Array ( 'Plus d\'infos' ),
        'url'  => Array( 'vendre', 'acheter', 'envoi-livraison', 'paiement-transfert', 'retours-annulations', 'evaluation-notation' , 'confiance-securite', 'mon-compte', 'inscription-connexion', 'forum', 'contact' ),
    );

    $helpCenterArray = Array (
        'content' => $helpCenterContent ,
        'link'    => $helpCenterLink,
    );

    //var_dump ($helpCenterArray);
    ?>

    <div id="helpCenterCards" class="container">
        <div class="row">
            <?php for ($i = 0 ; $i < count ( $helpCenterArray['content']['title'] ); $i++) {?>
                <div class="card text-center col-lg-3 col-md-4 col-sm-6">
                    <a href="<?php echo $helpCenterArray['link']['url'][$i] ?>/">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $helpCenterArray['content']['title'][$i] ?></h5>
                            <img src="<?php echo $helpCenterArray['content']['iconUrl'][$i] ?>" alt="<?php echo $helpCenterArray['content']['title'][$i] ?>" width="50px"/>
                            <p class="card-text"><?php echo $helpCenterArray['content']['infos'][$i] ?></p>
                        </div>
                    </a>
                </div><?php
            }?>
        </div>
    </div><?php
}
add_shortcode('CardsHelpCenter', 'addHelpCenterCards');


/* END HELP CENTER - CENTRE D'AIDE */

function  addStoreButton() {
	$userId = get_current_user_id();

    return printf( '<a class="btn btn-primary" href="%s">%s</a>', dokan_get_store_url( $userId ),'Voir ma boutique' );
}

add_action( 'dokan_dashboard_left_widgets', 'addStoreButton', 90 );
add_action( 'myaccount_dashboard_after', 'addStoreButton' );


// define the woocommerce_review_order_after_submit callback
//function action_woocommerce_review_order_after_submit($data) {
/*	$mp = mpAccess::getInstance();
	$user_id = get_current_user_id();
	$mp_user_id = $mp->set_mp_user($user_id);

	$mp->create_pre_authorization();

	wp_redirect( "www.google.fr");
	exit;*/
//};

//add_action( 'woocommerce_review_order_after_submit', 'action_woocommerce_review_order_after_submit', 10, 0 );

