<meta charset="utf-8"/>


<?php
/**
 * My Account Dashboard
 *
 * Shows the first intro screen on the account dashboard.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/dashboard.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @author      WooThemes
 * @package     WooCommerce/Templates
 * @version     2.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$user_id = get_current_user_id();
$seller_profile = dokan_get_store_info( $user_id );

$dokanDashboard = new Dokan_Template_Dashboard;
$dokanDashboardCount = $dokanDashboard->orders_count;
$dokanDashboardPosts = $dokanDashboard->post_counts;
//var_dump($dokanDashboard);
//var_dump($dokanDashboard->orders_count);
var_dump($dokanDashboardPosts);
?>

<div id="wrapper-my-account">
	<div class="container-left">
		<div class='account-user-info user-header'>
				
					
				<div id="hello-my-account">
					<div>
						<h1 style="display: inline-block; color: var(--dark-grey);">
						<!--Conditional Hello or Bonsoir-->
							<?php date_default_timezone_set("Europe/Paris");
							$hour_day = date('H');
								if( $hour_day >= 4 AND $hour_day < 17 ) {
									echo('👋 Hello ');
								}
								else {
									echo('🌔 Bonsoir ');
								} ?> 
						
						<span style="color: var(--secondary-color);"><?php echo $current_user->user_firstname ; ?></span>,
						</h1> 
					</div>
				</div>
			 </div>
	
			<p style="font-size: 0.95em; font-weight: 500;">
				Bienvenue sur votre espace personnel ! Faites comme chez-vous : <a style="font-size: 0.95em; font-weight: 600;" class="linkBlue" href="/ma-boutique/products/" title="Gérez vos annnonces">gérez vos annonces</a>, <a style="font-size: 0.95em; font-weight: 600;" class="linkBlue" href="/mon-compte/mes-achats/" title="Suivez vos commandes">suivez la livraison de vos commandes</a>, <a style="font-size: 0.95em; font-weight: 600;" class="linkBlue" href="/mon-compte/porte-monnaie/" title="Récupérer mon argent"></a>procédez à un virement sur votre compte bancaire et notez les autres membres.
				Vous avez vu quelque chose qui cloche ? <a style="font-size: 0.95em; font-weight: 600;" class="linkBlue" href="https://zetoolbox.typeform.com/to/DsYdIz" title="Donnez-nous votre feedback" rel="nofollow">Donnez-nous votre feedback</a> pour améliorer Luzus et agrandir notre communauté !
			</p>
			
		
			<ul id="dashboardMyAccount">
				<li>Annonces en ligne<br> 
					<span class="badge badge-primary">
						<?php echo number_format_i18n( $dokanDashboardPosts->{'publish'}, 0 ); ?>
					</span>
				</li>

				<li>Ventes Terminées<br> 
					<span class="badge badge-primary">
						<?php echo number_format_i18n( $dokanDashboardCount->{'wc-completed'}, 0 ); ?>
					</span>
				</li>

				<li>Ventes en cours<br>
					<span class="badge badge-primary">
						<?php echo number_format_i18n( $dokanDashboardCount->{'wc-processing'}, 0 ); ?>	
					</span>
				</li>
			</ul>
			
			
			<?php if (is_user_logged_in() &&  empty($seller_profile['dokan_verification']['facebook']) && (empty($seller_profile['dokan_verification']['google'])) && empty($seller_profile['dokan_verification']['twitter'])) { ?>
				<div id="verif-box">
					<a class="btn btn-default .btn-sm btn-second" href="/mon-compte/infos-compte/#verification" title="Vérifier mon compte"><i class="fa fa-check-circle-o" aria-hidden="true"></i> Vérifier mon compte</a> 
				</div>
			<?php } ?>
			
			
	</div>


	<div class='container-right'>
    	
    	
    	<div id="rex-form">
    		<h3>💡 Ça chauffe,</h3>
    		<p style="font-size:0.95em;">Une idée pour améliorer LUZUS ?<br>
    		Ou un feedback à nous donner ?</p>
    		
    		<a target="_blank" rel="nofollow" href="https://zetoolbox.typeform.com/to/DsYdIz" title="Donner mon avis !" class="btn btn-default .btn-sm btn-second">Donner mon avis !</a>
		</div>
		
		<div id="share-luzus">
			<?php echo do_shortcode('[TheChamp-Sharing title="🤖 Aidez-nous à réunir une armada de geeks !" total_shares="ON" url="https://luzus.fr"]') ?>
		</div>
	</div>
</div>



<?php
	/**
	 * My Account dashboard.
	 *
	 * @since 2.6.0
	 */
	do_action( 'woocommerce_account_dashboard' );

	/**
	 * Deprecated woocommerce_before_my_account action.
	 *
	 * @deprecated 2.6.0
	 */
	do_action( 'woocommerce_before_my_account' );

	/**
	 * Deprecated woocommerce_after_my_account action.
	 *
	 * @deprecated 2.6.0
	 */
	do_action( 'woocommerce_after_my_account' );

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
 