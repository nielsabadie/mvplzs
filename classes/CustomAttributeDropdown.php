<?php



require_once 'Dropdown.php';



/**

 * Dropdown class for custom attributes.

 *

 * @author Lucas Strübi <lucas.strubi@gmail.com>

 */

class CustomAttributeDropdown extends DropDown

{



    public function __construct($taxonomy, $productId = null)

    {

        parent::__construct(null);

        $this->arguments['parent'] = 0;

        $this->arguments['taxonomy'] = $taxonomy;

        $this->arguments['name'] = $taxonomy;

        if ($productId) {

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

