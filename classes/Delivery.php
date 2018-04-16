<?php



/**

 * Delivery class for Colissimo.

 *

 * @author Lucas Strübi <lucas.strubi@gmail.com>

 */

class Delivery

{



    public static $prices;



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

        $key = "SbxLXcuev+lGeQzS74MSyYvw7ko3jJY/3DhgP4x4zEMiSGCah58QJ7ie4x0zmtCS";

        $request = wp_remote_get("https://api.laposte.fr/tarifenvoi/v1/?type=colis&poids=" . $weight*1000, array(

            'headers' => array(

                'X-Okapi-Key' => $key,

                'Content-Type' => 'application/json; charset=utf-8'

            )

        ));

        $result = json_decode($request['body']);
		
		
        return $result[0]->price;

    }



}

