<?php



abstract class DropDown

{

    public $arguments;

    public $template;

    public $labelText;

    public $dropdownIndex;



    public function __construct($dropdownIndex)

    {

        $this->arguments = array(

            'hierarchical' => 1,

            'hide_empty' => 0,

            'class' => 'product_cat dokan-form-control dokan-select2 product-category-dropdown',

            'echo' => 0,

            'show_option_none' => 'Veuillez faire un choix dans la liste',

            'name' => 'product_cat'

        );

        $this->dropdownIndex = $dropdownIndex;

        $this->labelText = 'Liste déroulante';

    }



    public function defineTemplate()

    {

        $template = '<div class="dokan-form-group category-dropdown" data-category-index="' . ($this->dropdownIndex + 1) . '">';

        $template .= '<label for="' . $this->arguments['name'] . '" class="dokan-form-label">' . $this->labelText . '</label>';

        $template .= wp_dropdown_categories(apply_filters('dokan_product_cat_dropdown_args', $this->arguments));

        $template .= '</div>';

        $this->template = $template;

    }



    public function renderJson()

    {

        $this->defineTemplate();

        $outPut = array('template' => $this->template, 'dropdownIndex' => $this->dropdownIndex);

        echo json_encode($outPut);

    }

}



class SubCategoryDropDown extends DropDown

{

    public function __construct($dropdownIndex, $categoryId)

    {

        parent::__construct($dropdownIndex);

        $this->arguments['parent'] = $categoryId;

        $this->arguments['taxonomy'] = 'product_cat';

        $this->defineDropdownLabelAndShowOption();

    }



    private function defineDropdownLabelAndShowOption()

    {

        if ($this->dropdownIndex === 0) {

            $this->labelText = 'Type de produit';

            $this->arguments['show_option_none'] = 'Sélectionnez un type';

        } elseif ($this->dropdownIndex === 1) {

            $this->labelText = 'Catégorie';

            $this->arguments['show_option_none'] = 'Sélectionnez une catégorie';

        } else {

            $this->labelText = 'Sous-catégorie';

            $this->arguments['show_option_none'] = 'Sélectionnez une sous-catégorie';

        }

    }

}



class CustomAttributeDropdown extends DropDown

{

    public function __construct($taxonomy, $productId = null)

    {

        parent::__construct(null);

        $this->arguments['parent'] = 0;

        $this->arguments['taxonomy'] = $taxonomy;

        $this->arguments['name'] = $taxonomy;

        if ($_GET['action'] === 'edit' && $productId) {

            $this->arguments['value_field'] = 'name';

            $this->arguments['selected'] = wc_get_product($productId)->get_attribute($taxonomy);

        }

    }



    public function defineTemplate()

    {

        $template = '<div class="dokan-form-group category-dropdown">';

        $template .= '<label for="' . $this->arguments['name'] . '" class="dokan-form-label">' . $this->labelText . '</label>';

        $template .= wp_dropdown_categories(apply_filters('dokan_product_cat_dropdown_args', $this->arguments));

        $template .= '</div>';

        $this->template = $template;

    }

}



/**

 * Ajax for subcategories dropdowns building

 *

 * @author Lucas Strübi <lucas.strubi@gmail.com>

 */

function get_product_subcategories()

{

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

 * @author Lucas Strübi <lucas.strubi@gmail.com>

 * @param $currentPostId

 */

function generateProductCategoriesDropDownTree($currentPostId)

{

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



function addProductCustomAttributes($category, $currentPostId = null)

{

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

 *

 * @author Lucas Strübi <lucas.strubi@gmail.com>

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



    setProductAttributes($productId, $attributes);

}



add_action('dokan_new_product_added', 'onProductChange', 10, 3);

add_action('save_post_product', 'onProductChange', 10, 3);



/**

 * Will loop on given attributes and "update post meta" => add attributes in case of woocommerce

 *

 * @author Lucas Strübi <lucas.strubi@gmail.com>

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

