<?php



/**

 * Delivery class for Colissimo.

 *

 * @author Lucas Strübi <lucas.strubi@gmail.com>

 */

class Delivery

{



    public static $prices;
	public static $getTracking;



    public static function getPrice($weight)

    {

        if (isset(self::$prices[$weight])) {

            return self::$prices[$weight];

        } else {

            self::$prices[$weight] = self::callColissimoApi($weight);

            return self::$prices[$weight];

        }

    }
	



    private static function callColissimoApi($weight)

    {

        $key = "eMnpWPnCY3RE84j0MGyUom2nN9yT56IZ1ayRfZjDfuuEBLWcx25GlFsa2Hm6nFAQ";

        $request = wp_remote_get("https://api.laposte.fr/tarifenvoi/v1/?type=colis&poids=" . $weight*1000, array(

            'headers' => array(

                'X-Okapi-Key' => $key,

                'Content-Type' => 'application/json; charset=utf-8'

            )

        ));

        $result = json_decode($request['body']);
		
		
        return $result[0]->price;

    }
	
	public static function getDeliveryTracking($trackingCode) {

    	self::$getTracking[$trackingCode] = self::callColissimoApiForDeliveryTracking($trackingCode);
		
		return self::$getTracking[$trackingCode];

    } //8Q53559575963 / 2M04308805923
	
	
	public static function getDeliveryStatutInformations () {
		/*var_dump($result);
		echo $result->date;
		echo $result->type;
		echo $result->statut;
		echo $result->message;*/
		return;
	}
	
	 public static function callColissimoApiForDeliveryTracking($trackingCode) {

        $key = "eMnpWPnCY3RE84j0MGyUom2nN9yT56IZ1ayRfZjDfuuEBLWcx25GlFsa2Hm6nFAQ";

        $request = wp_remote_get("https://api.laposte.fr/suivi/v1/?code=" . $trackingCode, array(

            'headers' => array(

                'X-Okapi-Key' => $key,

                'Content-Type' => 'application/json; charset=utf-8'

            )

        ));

        $result = json_decode($request['body']);
		$resultInArray = Array (
			'code'    => $result->code,
			'date'    => $result->date,
			'status'  => $result->status,
			'message' => $result->message,
			'type'    => $result->type,
		) ;
		 
		//var_dump($result); 
        return $result;

    }
	
	/*$deliveryCode = '2M04308805927';
		$DeliveryInfos = Delivery::getDeliveryTracking($deliveryCode); ?>
        
        
        <?php 
			if ( $DeliveryInfos->code == 'BAD_REQUEST' || $DeliveryInfos->code == 'RESOURCE_NOT_FOUND' ){ 
				echo '<p>' . $DeliveryInfos->message . '</p>';
				
			} elseif ( !empty($DeliveryInfos->code) ) {
				echo '<p>' . $DeliveryInfos->code . '</p>';
				echo '<p>' . $DeliveryInfos->status . '</p>';
				echo '<p>' . $DeliveryInfos->date . '</p>';
				echo '<p>' . $DeliveryInfos->message . '</p>';
				echo '<p>' . $DeliveryInfos->type . '</p>';
				
			} else { echo "Erreur"; }
		*/



}

