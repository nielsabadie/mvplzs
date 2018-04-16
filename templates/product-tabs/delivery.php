<?php global $product; 



?>

<h2>Livraison</h2>

<div class="delivery-tab">



    <p>Le vendeur vous propose les modes de livraison suivants :</p>



    <ul class="listDeliverySolutions">

        <li>
        	<img src="https://www.luzus.fr/wp-content/uploads/2018/03/Colissimo_Logo_ST.svg" title="Colissimo"/><span class="deliveryTitle">Colissimo (<?php echo Delivery::getPrice($product->get_weight());?> €)</span> : L'expédition se fait sous 5 jours par Colissimo avec suivi. Ainsi, vous pouvez suivre à tout moment l’état d’avancement de votre colis.
        </li>



        <?php if ($product->get_attribute('pa_mondial_relay') === 'true') : ?>

            <li>
				<img src="https://www.luzus.fr/wp-content/uploads/2018/03/mondial-relay-logo.png" title="Mondial Relay"/>
				<span class="deliveryTitle">Mondial Relay</span> : L'expédition se fait sous 5 jours par Mondial Relay avec suivi. Ainsi, vous pouvez suivre à tout moment l’état d’avancement de votre colis.
        	</li>

        <?php endif; ?>



        <?php if ($product->get_attribute('pa_main_propre') === 'true') : ?>

            <li>
				<img src="https://www.luzus.fr/wp-content/uploads/2018/03/delivery-box-on-a-hand.svg" title="Remise en main propre"/>
				Remise en main propre (non disponible avec le paiement en ligne)
            </li>

        <?php endif; ?>

    </ul>



    <p>Une fois le colis réceptionné, vous disposez de 48h pour demander le retour du produit.</p>



</div>

