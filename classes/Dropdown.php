<?php



/**

 * Dropdown abstract class.

 *

 * @author Lucas Strübi <lucas.strubi@gmail.com>

 */

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

