/**

 * @file Manages javascripts for new-product page.

 *

 * @author Lucas Strübi <lucas.strubi@gmail.com>

 */



jQuery(document).on('change', '.product-category-dropdown', function () {

  checkForSubCategory($(this).val(), $(this).parent().data('category-index'));

});



/**

 * Delete subCategory tree

 *

 * @param currentCategoryIndex - dropdown's parent's category-index data attribute

 */

function cleanSubCategories (currentCategoryIndex) {



  // Get an array of data category indexes superior to current category index

  var $childCategories = $('.category-dropdown').filter(function () {

    return $(this).attr('data-category-index') > currentCategoryIndex;

  });



  // Remove each of those dropdowns

  $childCategories.each(function () {

    $(this).remove();

  });

}



/**

 * Toggles cursor style for AJAX asynchronous requests UX.

 *

 * @param wait {boolean} - if true sets mouse cursor to wait, otherwise set auto style

 */

function toggleCursorWaitStyle (wait) {

  $('html, body').css('cursor', wait ? 'wait' : 'auto');

}



/**

 * Calls AJAX and append new dropdown after its parent.

 *

 * @param categoryId

 * @param dropdownIndex

 */

function checkForSubCategory (categoryId, dropdownIndex) {

  toggleCursorWaitStyle(true);

  var ajaxParameters = {

    'action': 'get_product_subcategories',

    'param': {

      categoryId: categoryId,

      dropdownIndex: dropdownIndex

    }

  };



  cleanSubCategories(dropdownIndex);



  $.post(ajaxurl, ajaxParameters, function (response) {

      toggleCursorWaitStyle(false);

      if (response) {

        response = JSON.parse(response);

        if (response.attributes || response.dropdownIndex < 2) {

          $('#custom-product-attributes').empty().append(response.attributes);

        }

        $('.category-dropdown[data-category-index="' + response.dropdownIndex + '"]').after(response.template);

        $('.dokan-select2').select2();

      }

    }

  );

}

