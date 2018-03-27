<?php



require_once 'Dropdown.php';



/**

 * Dropdown class for categories;

 *

 * @author Lucas Strübi <lucas.strubi@gmail.com>

 */

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

