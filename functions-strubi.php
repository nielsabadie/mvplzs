<?php



require_once 'classes/SubCategoryDropDown.php';

require_once 'classes/CustomAttributeDropdown.php';

require_once 'classes/Delivery.php';



/**

 * Ajax for subcategories dropdowns building

 *

 */

function get_product_subcategories() {

    $categoryId = $_POST['param']['categoryId'];

    $dropdownIndex = intval($_POST['param']['dropdownIndex'], 10);

    $currentProductCategoryChildrens = get_term_children($categoryId, 'product_cat');

    $currentCategory = get_term($categoryId, 'product_cat');



    if ($categoryId > 0) {



        if (!empty($currentProductCategoryChildrens)) {



            $categoryDropDown = new SubCategoryDropDown($dropdownIndex, $categoryId);

            $categoryDropDown->defineTemplate();

            $outPut = array('template' => $categoryDropDown->template, 'dropdownIndex' => $categoryDropDown->dropdownIndex);

        }



        $outPut['attributes'] = addProductCustomAttributes($currentCategory);

        echo json_encode($outPut);

    }

    die();

}



add_action('wp_ajax_get_product_subcategories', 'get_product_subcategories');

add_action('wp_ajax_nopriv_get_product_subcategories', 'get_product_subcategories');



/**

 * Generates current product categories dropdown tree.

 * Uses new-products-scripts.js on modification.

 *

 * @param $currentPostId

 */

function generateProductCategoriesDropDownTree($currentPostId) {

    $term = wp_get_post_terms($currentPostId, 'product_cat', array('fields' => 'all'));

    $term = $term[0];



    $productCategoriesArray = array(get_term($term->term_id, 'product_cat'));



    // Fill $productCategoriesArray with parent categories objects

    $category = get_term($term->term_id, 'product_cat');

    while ($category->parent) {

        $category = get_term($category->parent, 'product_cat');

        array_unshift($productCategoriesArray, $category);

    }



    $customAttributes = null;

    foreach ($productCategoriesArray as $index => $category) {



        if (!is_null(addProductCustomAttributes($category))) {

            $customAttributes = addProductCustomAttributes($category, $currentPostId);

        }



        $categoryDropDown = new SubCategoryDropDown($index, $category->parent);

        $categoryDropDown->arguments['selected'] = $category->term_id;

        $categoryDropDown->defineTemplate();

        echo $categoryDropDown->template;

    }



    if (!is_null($customAttributes)) {

        echo '<div id="custom-product-attributes">' . $customAttributes . '</div>';

    }

}



function addProductCustomAttributes($category, $currentPostId = null) {

    $customAttributes = null;



    if ($category->slug === 'ordinateurs-portables') {



        $screenResolution = new CustomAttributeDropdown('pa_taille-ecran-ordi-portables', $currentPostId);

        $screenResolution->labelText = 'Taille de l\'écran';

        $screenResolution->arguments['show_option_none'] = 'Indiquez la taille de l\'écran';

        $screenResolution->defineTemplate();



        $cpu = new CustomAttributeDropdown('pa_processeur-ordi-portables', $currentPostId);

        $cpu->labelText = 'Sélectionnez le processeur';

        $cpu->arguments['show_option_none'] = 'Processeur';

        $cpu->defineTemplate();



        $customAttributes = $screenResolution->template . $cpu->template;



    } elseif ($category->slug === 'ordinateurs-fixes') {



        $cpu = new CustomAttributeDropdown('pa_processeur-ordi-bureau', $currentPostId);

        $cpu->labelText = 'Sélectionnez le processeur';

        $cpu->arguments['show_option_none'] = 'Processeur';

        $cpu->defineTemplate();



        $graphicCard = new CustomAttributeDropdown('pa_carte-graphique-ordi-bureau', $currentPostId);

        $graphicCard->labelText = 'Carte graphique';

        $graphicCard->arguments['show_option_none'] = 'Choisissez une carte graphique';

        $graphicCard->defineTemplate();



        $customAttributes = $cpu->template . $graphicCard->template;



    } elseif ($category->slug === 'cles-usb') {



        $usbCapacity = new CustomAttributeDropdown('pa_capacite-cles-usb', $currentPostId);

        $usbCapacity->labelText = 'Capacité';

        $usbCapacity->arguments['show_option_none'] = 'Indiquez la capacité de la clé usb';

        $usbCapacity->defineTemplate();



        $customAttributes = $usbCapacity->template;



    } elseif ($category->slug === 'stockage-interne-externe') {



        $hardDiskCapacity = new CustomAttributeDropdown('pa_capacite-ssd-dd-nas', $currentPostId);

        $hardDiskCapacity->labelText = 'Capacité';

        $hardDiskCapacity->arguments['show_option_none'] = 'Indiquez la capacité du disque';

        $hardDiskCapacity->defineTemplate();



        $customAttributes = $hardDiskCapacity->template;



    } elseif ($category->slug === 'ps4') {



        $ps4Capacity = new CustomAttributeDropdown('pa_capacite-ps4', $currentPostId);

        $ps4Capacity->labelText = 'Capacité';

        $ps4Capacity->arguments['show_option_none'] = 'Indiquez la capacité de la PS4';

        $ps4Capacity->defineTemplate();



        $ps4Color = new CustomAttributeDropdown('pa_couleur-ps4', $currentPostId);

        $ps4Color->labelText = 'Couleur';

        $ps4Color->arguments['show_option_none'] = 'Indiquez la couleur de la PS4';

        $ps4Color->defineTemplate();



        $customAttributes = $ps4Capacity->template . $ps4Color->template;



    } elseif ($category->slug === 'xbox-one') {



        $xboxOneCapacity = new CustomAttributeDropdown('pa_capacite-xbox-one', $currentPostId);

        $xboxOneCapacity->labelText = 'Capacité';

        $xboxOneCapacity->arguments['show_option_none'] = 'Indiquez la capacité de la XBOX ONE';

        $xboxOneCapacity->defineTemplate();



        $xboxOneColor = new CustomAttributeDropdown('pa_couleur-xbox-one', $currentPostId);

        $xboxOneColor->labelText = 'Couleur';

        $xboxOneColor->arguments['show_option_none'] = 'Indiquez la couleur de la XBOX ONE';

        $xboxOneColor->defineTemplate();



        $customAttributes = $xboxOneCapacity->template . $xboxOneColor->template;



    } elseif ($category->slug === 'reflex') {



        $reflexAttribute1 = new CustomAttributeDropdown('pa_boitier-nu', $currentPostId);

        $reflexAttribute1->labelText = 'Boîtier nu';

        $reflexAttribute1->defineTemplate();



        $reflexAttribute2 = new CustomAttributeDropdown('pa_nombre-de-declenchements', $currentPostId);

        $reflexAttribute2->labelText = 'Nombre de déclenchements';

        $reflexAttribute2->defineTemplate();



        $customAttributes = $reflexAttribute1->template . $reflexAttribute2->template;



    } elseif ($category->slug === 'hybrides' || $category->slug === 'compacts-bridges') {



        $hybridOrCompactBridgeAttribute1 = new CustomAttributeDropdown('pa_megapixels', $currentPostId);

        $hybridOrCompactBridgeAttribute1->labelText = 'Megapixels';

        $hybridOrCompactBridgeAttribute1->defineTemplate();



        $hybridOrCompactBridgeAttribute2 = new CustomAttributeDropdown('pa_zoom-optique', $currentPostId);

        $hybridOrCompactBridgeAttribute2->labelText = 'Zoom optique';

        $hybridOrCompactBridgeAttribute2->defineTemplate();



        $customAttributes = $hybridOrCompactBridgeAttribute1->template . $hybridOrCompactBridgeAttribute2->template;



    } elseif ($category->slug === 'objectifs-reflex' || $category->slug === 'objectifs-hybrides') {



        $objectivesAttribute1 = new CustomAttributeDropdown('pa_focale-minimale', $currentPostId);

        $objectivesAttribute1->labelText = 'Focale minimale';

        $objectivesAttribute1->defineTemplate();



        $objectivesAttribute2 = new CustomAttributeDropdown('pa_focale-maximale', $currentPostId);

        $objectivesAttribute2->labelText = 'Focale maximale';

        $objectivesAttribute2->defineTemplate();



        $customAttributes = $objectivesAttribute1->template . $objectivesAttribute2->template;



    } elseif ($category->slug === 'televiseurs') {



        $tvsAttribute1 = new CustomAttributeDropdown('pa_taille-de-lecran-tv', $currentPostId);

        $tvsAttribute1->labelText = 'Taille de l\'écran';

        $tvsAttribute1->defineTemplate();



        $tvsAttribute2 = new CustomAttributeDropdown('pa_norme-hd-4k', $currentPostId);

        $tvsAttribute2->labelText = 'Norme HD 4K';

        $tvsAttribute2->defineTemplate();



        $customAttributes = $tvsAttribute1->template . $tvsAttribute2->template;



    } elseif ($category->slug === 'smartphones') {



        $smartphoneAttributes1 = new CustomAttributeDropdown('pa_debloque-tout-operateur', $currentPostId);

        $smartphoneAttributes1->labelText = 'Débloqué tout opérateur';

        $smartphoneAttributes1->defineTemplate();



        $smartphoneAttributes2 = new CustomAttributeDropdown('pa_memoire-interne-smartphone', $currentPostId);

        $smartphoneAttributes2->labelText = 'Mémoire interne';

        $smartphoneAttributes2->defineTemplate();



        $customAttributes = $smartphoneAttributes1->template . $smartphoneAttributes2->template;



    } elseif ($category->slug === 'tablettes') {



        $tabletAttributes = new CustomAttributeDropdown('pa_capacite-du-disque-dur', $currentPostId);

        $tabletAttributes->labelText = 'Capacité du disque dur';

        $tabletAttributes->defineTemplate();



        $customAttributes = $tabletAttributes->template;



    }



    if ($category->slug === 'smartphones' || $category->slug === 'tablettes') {



        $colorAttribute = new CustomAttributeDropdown('pa_color', $currentPostId);

        $colorAttribute->defineTemplate();



        $customAttributes .= $colorAttribute->template;



    }



    return $customAttributes;

}



/**

 * Function hooked on new product / product edition.

 * @param $productId

 */

function onProductChange($productId)

{

    $attributes = array();



    foreach ($_POST as $key => $value) {

        if (strpos($key, 'pa_') === 0) {

            $attribute = get_term_by('id', $_POST[$key], $key);



            // Make sure we get the term object...

            if (!$attribute) {

                $attribute = get_term_by('name', $_POST[$key], $key);

            }

            $attributes[$key] = $attribute->name;

        }

    }



    if (isset($_POST['product_weight'])) {

        update_post_meta($productId, '_weight', $_POST['product_weight']);

    }



    setProductAttributes($productId, $attributes);

}



add_action('dokan_new_product_added', 'onProductChange', 10, 3);

add_action('save_post_product', 'onProductChange', 10, 3);



/**

 * Will loop on given attributes and "update post meta" => add attributes in case of woocommerce

 *

 * @param $postId

 * @param $attributes {Array} [pa_attribute-slug] => 'value as name'

 */

function setProductAttributes($postId, $attributes)

{

    $i = 0;

    $product_attributes = null;

    foreach ($attributes as $name => $value) {

        $product_attributes[$i] = array(

            'name' => htmlspecialchars(stripslashes($name)),

            'value' => $value,

            'position' => 1,

            'is_visible' => 1,

            'is_variation' => 1,

            'is_taxonomy' => 0

        );

        $i++;

    }

    update_post_meta($postId, '_product_attributes', $product_attributes);

}



function productTabs($tabs)

{



    $tabs['delivery_tab'] = array(

        'title' => 'Livraison',

        'priority' => 1100,

        'callback' => 'deliveryTabContent'

    );



    $tabs['payement_tab'] = array(

        'title' => 'Paiement',

        'priority' => 1101,

        'callback' => 'payementTabContent'

    );

    return $tabs;

}



function deliveryTabContent()

{

    include('templates/product-tabs/delivery.php');

}



function payementTabContent()

{

    include('templates/product-tabs/payment.php');

}



add_filter('woocommerce_product_tabs', 'productTabs');



function colissimoPriceDefinition($weight)

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



function redefinePackageRatesPrice($rates, $package)

{

    $product = $package['contents'][key($package['contents'])]['data'];

    $productWeight = intval($product->get_weight(), 10);



    foreach ($rates as $key => &$rate) {



        if ($rate->get_label() === 'Colissimo') {



            $price = Delivery::getPrice($productWeight);

            $rate->set_cost($price);



        } /*elseif ($rate->get_label() === 'Mondial Relay') {



            if ($product->get_attribute('pa_mondial_relay') === 'false' || $product->get_attribute('pa_mondial_relay') === '') {

                unset($rates[$key]);

            }



            if ($productWeight === 1) {

                $rate->set_cost(5);

            } elseif ($productWeight === 2) {

                $rate->set_cost(2);

            } elseif ($productWeight === 5) {

                $rate->set_cost(23);

            } elseif ($productWeight === 10) {

                $rate->set_cost(6);

            }



        }*/



    }



    return $rates;

}


add_filter('woocommerce_package_rates', 'redefinePackageRatesPrice', 10, 2);

