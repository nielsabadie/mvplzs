<?php



/**

 * Delivery class for Colissimo.

 *

 * @author Lucas Strübi <lucas.strubi@gmail.com>

 */

Class Delivery

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

        $key = "+XEomjeMKPpvF8wY/9cw88mtgS2E41Ay/uJhFnv5HhdNYeqwQwHssZOXOcdgoWMG";

        $request = wp_remote_get("https://api.laposte.fr/tarifenvoi/v1/?type=colis&poids=" . $weight, array(

            'headers' => array(

                'X-Okapi-Key' => $key,

                'Content-Type' => 'application/json; charset=utf-8'

            )

        ));

        $result = json_decode($request['body']);

        return $result[0]->price;

    }



}

