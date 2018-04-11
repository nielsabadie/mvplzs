/**

 * @file Manages javascripts for new-product page.

 *

 * @author Lucas Strübi <lucas.strubi@gmail.com>

 */



jQuery(document).on('change', '.product-category-dropdown', function() {

    checkForSubCategory($(this).val(), $(this).parent().data('category-index'));

});



/**

 * Delete subCategory tree

 *

 * @param currentCategoryIndex - dropdown's parent's category-index data attribute

 */

function cleanSubCategories(currentCategoryIndex) {



    // Get an array of data category indexes superior to current category index

    var $childCategories = $('.category-dropdown').filter(function() {

        return $(this).attr('data-category-index') > currentCategoryIndex;

    });



    // Remove each of those dropdowns

    $childCategories.each(function() {

        $(this).remove();

    });

}



/**

 * Toggles cursor style for AJAX asynchronous requests UX.

 *

 * @param wait {boolean} - if true sets mouse cursor to wait, otherwise set auto style

 */

function toggleCursorWaitStyle(wait) {

    $('html, body').css('cursor', wait ? 'wait' : 'auto');

}



/**

 * Calls AJAX and append new dropdown after its parent.

 *

 * @param categoryId

 * @param dropdownIndex

 */

function checkForSubCategory(categoryId, dropdownIndex) {

    toggleCursorWaitStyle(true);

    var ajaxParameters = {

        'action': 'get_product_subcategories',

        'param': {

            categoryId: categoryId,

            dropdownIndex: dropdownIndex

        }

    };



    cleanSubCategories(dropdownIndex);



    $.post(ajaxurl, ajaxParameters, function(response) {

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




/**

 * Display Helper Information Module on add new product form

 *

 */


$(function() {
    $('#newProductCategory').hover(function() { $('#hoverNewProductCategory').delay(100).fadeIn(400); }, function() { $('#hoverNewProductCategory').fadeOut(100); });

    $('#newProductCondition').hover(function() { $('#hoverNewProductCondition').delay(100).fadeIn(400); }, function() { $('#hoverNewProductCondition').fadeOut(100); });

    $('#newProductTitle').hover(function() { $('#hoverNewProductTitle').delay(100).fadeIn(400); }, function() { $('#hoverNewProductTitle').fadeOut(100); });

    $('#newProductDescription').hover(function() { $('#hoverNewProductDescription').delay(100).fadeIn(400); }, function() { $('#hoverNewProductDescription').fadeOut(100); });

    $('#newProductOriginalPrice').hover(function() { $('#hoverNewProductOriginalPrice').delay(100).fadeIn(400); }, function() { $('#hoverNewProductOriginalPrice').fadeOut(100); });

    $('#newProductYourPrice').hover(function() { $('#hoverNewProductYourPrice').delay(100).fadeIn(400); }, function() { $('#hoverNewProductYourPrice').fadeOut(100); });

    $('#newProductShippingMode').hover(function() { $('#hoverNewProductShippingMode').delay(100).fadeIn(400); }, function() { $('#hoverNewProductShippingMode').fadeOut(100); });

    var marginToHeight = $('#firstShippingZone').outerHeight();

    $('#newProductShippingWeight').hover(function() { $('#hoverNewProductShippingWeight').css('marginTop', marginToHeight).delay(100).fadeIn(400); }, function() { $('#hoverNewProductShippingWeight').fadeOut(100).css('marginTop', 0); });

    $('#newProductPicture').hover(function() { $('#hoverNewProductPicture').delay(100).fadeIn(400); }, function() { $('#hoverNewProductPicture').fadeOut(100); });
});