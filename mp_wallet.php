<?php if ( ! defined( 'ABSPATH' ) ) {
	exit;
}



function mpWallet() {
ob_start();

	$mp = mpAccess::getInstance();
    $user_id = get_current_user_id();
	$mp_user_id = $mp->set_mp_user($user_id);


	$wallets = $mp->set_mp_wallet( $mp_user_id );

    //var_dump($wallets);

    if($_GET["payin"] && $_GET["payin"] > 0) {
        $fees = $_GET["fees"];
        $redirect = $mp->card_payin_url(0, $user_id, $_GET["payin"], 'EUR', $fees, "https://www.luzus.fr/mon-compte/", "FR");
        if($redirect) {
            wp_redirect( $redirect["redirect_url"] );
        }
    }
   if($_GET["payout"] && $_GET["payout"] > 0) {
       $fees = $_GET["fees"];

       //var_dump($mp->mangoPayApi->Users->GetBankAccounts( $mp_user_id));

       //var_dump("TEST",$mp->payout($user_id, 43470981, 0, 'EUR', $_GET["payout"], $fees));
       $payout =$mp->payout($user_id, 43470981, 0, 'EUR', $_GET["payout"], $fees);
        if($payout) {
            wp_redirect("https://www.luzus.fr/mon-compte/porte-monnaie/");
        }

    }

    if(!$wallets) {
	return '<br><p>Aucun Wallet configuré</p>';

	}
	else {
	$customer_orders = get_posts( array(
    'numberposts' => -1,
    'meta_key'    => '_customer_user',
    'meta_value'  => get_current_user_id(),
    'post_type'   => wc_get_order_types(),
    'post_status' => array_keys( wc_get_order_statuses() ),
    ) );

    $seller_id    = dokan_get_current_user_id();
    $order_status = 'wc-processing';
    $paged        = isset( $_GET['pagenum'] ) ? absint( $_GET['pagenum'] ) : 1;
    $limit        = 100;
    $offset       = ( $paged - 1 ) * $limit;
    $order_date   = isset( $_GET['order_date'] ) ? sanitize_key( $_GET['order_date'] ) : NULL;
    $user_orders  = dokan_get_seller_orders( $seller_id, $order_status, $order_date, $limit, $offset );
/*
      echo "<pre>";
    var_dump($user_orders);
    echo '</pre>';*/

    $total = 0;
    foreach ( $user_orders as $customer_order ) {
        $order      = new WC_Order( $customer_order->order_id );
        $item_count = $order->get_item_count();
            $total += $order->get_total();
    }
		 ?>
<style>
.wallet-balance {
text-align: center;
    margin-bottom: 2em;
    border-radius: 10em;
    background: #074298;
    padding: 60px 12px;
    color: white;
    width: 12em;
    height: 12em;
    margin: 0 auto;
}
.wallet-balance span {
    font-size: 1.3em;
}
</style>

<!--   <table class="table table-condensed table-vendor-mp_wallets form-table">
                <thead>
                <tr>

                    <th class="mpw-balance-header"><?php /*_e( 'Solde Actuel', 'mangopay' ); */?></th>
                </tr>
                </thead>
                <tbody>-->

	<?php	if( $wallets && is_array($wallets) ) {
                foreach( $wallets as $wallet ) {
                    ?>
                    <div class="wallet-balance" style="text-align: center;color: white;margin-bottom: 2em;"> Solde actuel : <br>  <span><?= number_format_i18n( $wallet->Balance->Amount/100, 2 ) . ' ' . $wallet->Currency; ?></span></div>
                    <?php

                }
            } else {
            	echo '<p>' .
                __( 'No MANGOPAY wallets. Please check that all required fields have been completed in the user profile.', 'mangopay' ) .
                '</p>';
            }
    ?>
                </tbody>
    </table>
		  <?php
        /*if( $wallets && is_array($wallets) ) {
            foreach ($wallets as $wallet) {
                $dashboard_payout_url = $mp->getDBPayoutUrl($wallet->Id);
                $dashboard_payout_title = sprintf(__('Do a MANGOPAY payout for wallet #%s', 'mangopay'), $wallet->Id);
                $dashboard_payout_link = '<a target="_mp_db" href="' . $dashboard_payout_url . '" title="' . $dashboard_payout_title . '">';
                echo $dashboard_payout_link . __('Do a PayOut', 'mangopay') . '</a> ';

            }
        }*/
?>
<!--
    <div class="my-account-details" style="width: 50%;float: left;">
    <h2>Ajouter de l'argent sur mon wallet</h2>
        <form>
            montant :<input type="number" id="total-without-fees"> €<br>
            <p>commission luzus: <span id="fees">0,00</span> €</p>
            <p>total : <span id="total-with-fees">0,00</span>€</p>
            <input id="fees-hidden-payin" type="hidden" name="fees" value="0">
            <button disabled type="submit" name="payin" id="submit-payin" value="0">Ajouter</button>
        </form>
    </div>
    -->

    <div class="my-account-details" style="width: 50%;float: left;">
        <h3>Virer sur mon compte bancaire</h3>
        <form>
            <p>Montant à virer (minimum 2€) : <span style="float:right"><input type="number" min="2" step="0.01" id="total-without-fees-payout" style="width: 5em;"> €</span></p>
            <!--<div>Commission
               <div class="infobulle">
                    <div class="infobulle">
                        <i class="fa fa-question-circle" aria-hidden="true" data-title=""></i>
                        <div class="infobulletext">
                            <span>Nous prélevons systématiquement 1€ de frais fixes pour couvrir les frais bancaires liés au virement de vos fonds
                            </span>
                        </div>
                    </div>
                </div> :
                 <span style="float:right"><span id="fees-payout">1,00</span> €</span>
            </div>-->
            <p>Total viré : <span style="float:right"><span id="total-with-fees-payout">0,00</span> €</span></p>
            <input id="fees-hidden-payout" type="hidden" name="fees" value="0">
            <p style="text-align: center;"><button disabled type="submit" name="payout" id="submit-payout" value="0">Virer</button></p>
            <p style="text-align: center;"><button type="submit" name="payout" id="submit-payout-all" value="<?= ($wallet->Balance->Amount/100 - 1) ?>">Virer la totalité de mes fonds</button></p>

            <p style="text-align: center;"><a href="https://www.luzus.fr/mon-compte/infos-compte/#infos-bancaires"> Mes informations bancaires</a></p>
        </form>
    </div>

     <div class="my-account-details" style="width: 48%;float: right;">
        <p>Montant en attente : <span style="float:right;"><?= $total ?> €</span></p>
    </div>

<?php
    return ob_get_clean();
	}
}


add_shortcode('mp_wallet', 'mpWallet');