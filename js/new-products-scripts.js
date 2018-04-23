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


jQuery('document').ready(function($) {

    $('#formCategory').hover(
        function() { $('#formCategoryHover').delay(100).fadeIn(400); },
        function() { $('#formCategoryHover').fadeOut(100); }
    );

    $('#formBrand').hover(
        function() { $('#formBrandHover').delay(100).fadeIn(400); },
        function() { $('#formBrandHover').fadeOut(100); }
    );

    $('#formCondition').hover(
        function() { $('#formConditionHover').delay(100).fadeIn(400); },
        function() { $('#formConditionHover').fadeOut(100); }
    );

    $('#formSeniority').hover(
        function() { $('#formSeniorityHover').delay(100).fadeIn(400); },
        function() { $('#formSeniorityHover').fadeOut(100); }
    );


    $('#formTitle').hover(
        function() { $('#formTitleHover').delay(100).fadeIn(400); },
        function() { $('#formTitleHover').fadeOut(100); }
    );

    var marginToHeightFormDescription = $('#formTitle').outerHeight() + $('#descriptionTitle').outerHeight() + 60;

    $('#formDescription').hover(
        function() { $('#formDescriptionHover').css('marginTop', marginToHeightFormDescription).delay(100).fadeIn(400); },
        function() { $('#formDescriptionHover').fadeOut(100).css('marginTop', 0); }
    );


    $('#formOriginalPrice').hover(
        function() { $('#formOriginalPriceHover').delay(100).fadeIn(400); },
        function() { $('#formOriginalPriceHover').fadeOut(100); }
    );

    var marginToHeightFormYourPrice = $('#formYourPrice').outerHeight() + $('#PriceTitle').outerHeight() + 60;

    $('#formYourPrice').hover(
        function() { $('#formYourPriceHover').css('marginTop', marginToHeightFormYourPrice).delay(100).fadeIn(400); },
        function() { $('#formYourPriceHover').fadeOut(100).css('marginTop', 0); }
    );


    $('#formShippingMode').hover(
        function() { $('#formShippingModeHover').delay(100).fadeIn(400); },
        function() { $('#formShippingModeHover').fadeOut(100); }
    );


    $('#formShippingWeight').hover(
        function() { $('#formShippingWeightHover').delay(100).fadeIn(400); },
        function() { $('#formShippingWeightHover').fadeOut(100); }
    );


    $('#formPicture').hover(
        function() { $('#formPictureHover').delay(100).fadeIn(400); },
        function() { $('#formPictureHover').fadeOut(100); }
    );

    var options = $('#formBrand option');
    $(options[1468]).insertAfter($(options[0]));
    $("<hr>").insertAfter($(options[0]));

});