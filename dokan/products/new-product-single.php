<?php

global $post, $product;



wp_enqueue_script('dokan-tabs-scripts');



$post_id = $post->ID;

$product = wc_get_product($post_id);

$seller_id = get_current_user_id();

$from_shortcode = false;



if (isset($_GET['product_id'])) {

    $post_id = intval($_GET['product_id']);

    $post = get_post($post_id);

    $product = wc_get_product($post_id);

    $from_shortcode = true;

}



// bail out if not author

if ($post->post_author != $seller_id) {

    wp_die(__('Access Denied', 'dokan'));

}



$_regular_price = get_post_meta($post_id, '_regular_price', true);

$_sale_price = get_post_meta($post_id, '_sale_price', true);

$is_discount = ($_sale_price != '') ? true : false;

$_sale_price_dates_from = get_post_meta($post_id, '_sale_price_dates_from', true);

$_sale_price_dates_to = get_post_meta($post_id, '_sale_price_dates_to', true);



$_sale_price_dates_from = !empty($_sale_price_dates_from) ? date_i18n('Y-m-d', $_sale_price_dates_from) : '';

$_sale_price_dates_to = !empty($_sale_price_dates_to) ? date_i18n('Y-m-d', $_sale_price_dates_to) : '';

$show_schedule = false;



if (!empty($_sale_price_dates_from) && !empty($_sale_price_dates_to)) {

    $show_schedule = true;

}



$_featured = get_post_meta($post_id, '_featured', true);

$_weight = get_post_meta($post_id, '_weight', true);

$_length = get_post_meta($post_id, '_length', true);

$_width = get_post_meta($post_id, '_width', true);

$_height = get_post_meta($post_id, '_height', true);

$_downloadable = get_post_meta($post_id, '_downloadable', true);

$_is_lot_discount = get_post_meta($post_id, '_is_lot_discount', true);

$_lot_discount_quantity = get_post_meta($post_id, '_lot_discount_quantity', true);

$_lot_discount_amount = get_post_meta($post_id, '_lot_discount_amount', true);



$is_enable_op_discount = dokan_get_option('discount_edit', 'dokan_selling');

$is_enable_op_discount = $is_enable_op_discount ? $is_enable_op_discount : array();



$_stock_status = get_post_meta($post_id, '_stock_status', true);

$_visibility = (version_compare(WC_VERSION, '2.7', '>')) ? $product->get_catalog_visibility() : get_post_meta($post_id, '_visibility', true);

$_enable_reviews = $post->comment_status;



if (!$from_shortcode) {

    get_header();

}

?>



<?php



/**

 *  dokan_edit_product_wrap_before hook

 *

 * @since 2.4

 */

do_action('dokan_edit_product_wrap_before', $post, $post_id);

?>



    <div class="dokan-dashboard-wrap">



        <?php



        /**

         *  dokan_dashboard_content_before hook

         *  dokan_before_edit_product_content_area hook

         *

         * @hooked get_dashboard_side_navigation

         * @since 2.4

         */

        do_action('dokan_dashboard_content_before');

        do_action('dokan_before_edit_product_content_area');

        ?>



        <div id="edit-product-page" class="dokan-dashboard-content dokan-product-edit">



            <?php



            /**

             *  dokan_before_edit_product_inside_content_area hook

             *

             * @since 2.4

             */

            do_action('dokan_before_edit_product_inside_content_area');

            ?>



            <div class="dokan-product-edit-area">



                <header class="dokan-pro-edit-breadcrumb">

                    <h1 class="dokan-header-crumb">

                        <span class="dokan-breadcrumb"><a href="<?= dokan_get_navigation_url('products') ?>"><?php _e('Products', 'dokan'); ?></a> &rarr; </span>

                        <?= $post->post_title; ?>



                        <?php if ($_visibility == 'hidden') { ?>

                            <span class="dokan-label dokan-label-default"><?php _e('Hidden', 'dokan'); ?></span>

                        <?php } ?>



                        <?php if ($post->post_status == 'publish') { ?>

                            <span class="dokan-right">

								<a class="view-product dokan-btn dokan-btn-sm" href="<?= get_permalink($post->ID); ?>" target="_blank"><?php _e('View Product', 'dokan'); ?></a>



							<?php global $product;



								if ( $product->is_in_stock() ) {

									?><a class="view-product dokan-btn dokan-btn-sm" onclick="return confirm('Êtes-vous certain(e) de vouloir supprimer votre annonce ? ');" href="<?php echo wp_nonce_url( add_query_arg( array( 'action' => 'dokan-delete-product', 'product_id' => $post->ID ), dokan_get_navigation_url('products') ), 'dokan-delete-product' ); ?>">Supprimer</a><?php

								} else { ?>



									<a class="view-product dokan-btn dokan-btn-sm" onclick="return confirm('Attention ce produit a été commandé, êtes-vous certain(e) de vouloir le supprimer ? Ceci annulera votre vente.');" href="<?php echo wp_nonce_url( add_query_arg( array( 'action' => 'dokan-delete-product', 'product_id' => $post->ID ), dokan_get_navigation_url('products') ), 'dokan-delete-product' ); ?>">Supprimer</a>



								<?php } ?>





                        	</span>

                        <?php } ?>

                    </h1>

                </header>

				<div class="toggle-sidebar-container">

                    <div class="dokan-post-status dokan-toggle-sidebar">
                        <label for="post_status"><?php _e( 'Product Status:', 'dokan' ); ?> : </label>
                
                        <?php $pending_class = $post->post_status == 'pending' ? '  dokan-label dokan-label-warning': ''; ?>
                        <span style="font-weight: bold" class="dokan-toggle-selected-display<?php echo $pending_class; ?>"><?php echo dokan_get_post_status( $post->post_status ); ?></span>
                    </div>
                
                    <div class="product-type dokan-toggle-sidebar">
                        
                
                        <?php
                        $supported_types = apply_filters( 'dokan_product_type_selector', array(
                            'simple'    => __( 'Simple product', 'dokan' ),
                        ) );
                
                        if ( $terms = wp_get_object_terms( $post->ID, 'product_type' ) ) {
                            $product_type = sanitize_title( current( $terms )->name );
                        } else {
                            $product_type = 'simple';
                        }
                
                
                        if ( !array_key_exists( $product_type, $supported_types) ) {
                            $product_type = 'simple';
                        }
                        ?>
                    </div> <!-- .product-type -->
                </div>


                <?php if (dokan_is_seller_enabled(get_current_user_id())) { ?>



                <form class="dokan-form-container" role="form" method="post">

                    <?php wp_nonce_field('dokan_edit_product', 'dokan_edit_product_nonce'); ?>



                    <div class="product-edit-container dokan-clearfix">





                        <?php if (isset($_GET['message']) && $_GET['message'] == 'success') : ?>

                            <div class="dokan-message">

                                <button type="button" class="dokan-close" data-dismiss="alert">&times;</button>

                                <strong><?php _e('Success!', 'dokan'); ?></strong> <?php _e('The product has been updated successfully.', 'dokan'); ?>



                                <?php if ($post->post_status == 'publish') : ?>

                                    <a href="<?= get_permalink($post_id); ?>" target="_blank"><?php _e('View Product &rarr;', 'dokan'); ?></a>



                                <?php endif; ?>

                            </div>

                        <?php endif ?>



                        <!-- Product errors -->

                        <?php if (Dokan_Template_Products::$errors) : ?>

                            <div class="dokan-alert dokan-alert-danger">

                                <a class="dokan-close" data-dismiss="alert">&times;</a>



                                <?php foreach (Dokan_Template_Products::$errors as $error) : ?>

                                    <strong><?php _e('Error!', 'dokan'); ?></strong> <?= $error ?>.<br>

                                <?php endforeach; ?>



                            </div>

                        <?php endif; ?>

                        <!-- end Product errors -->



                        <div id="edit-product">



                            <?php do_action('dokan_product_edit_before_main'); ?>



                            <div class="dokan-clearfix">

                                <div class="content-half-part featured-image">

                                    <div class="dokan-feat-image-upload">

                                        <?php

                                        $wrap_class = ' dokan-hide';

                                        $instruction_class = '';

                                        $feat_image_id = 0;



                                        if (has_post_thumbnail($post_id)) {

                                            $wrap_class = '';

                                            $instruction_class = ' dokan-hide';

                                            $feat_image_id = get_post_thumbnail_id($post_id);

                                        }

                                        ?>



                                        <div class="instruction-inside<?= $instruction_class; ?>">

                                            <input type="hidden" name="feat_image_id" class="dokan-feat-image-id" value="<?= $feat_image_id; ?>">



                                            <i class="fa fa-cloud-upload"></i>

                                            <a href="#" class="dokan-feat-image-btn btn btn-sm"><?php _e('Upload a product cover image', 'dokan'); ?></a>

                                        </div>



                                        <div class="image-wrap<?= $wrap_class; ?>">

                                            <a class="close dokan-remove-feat-image">&times;</a>

                                            <?php if ($feat_image_id) { ?>

                                                <?= get_the_post_thumbnail($post_id, apply_filters('single_product_large_thumbnail_size', 'shop_single'), array('height' => '', 'width' => '')); ?>

                                            <?php } else { ?>

                                                <img height="" width="" src="" alt="">

                                            <?php } ?>

                                        </div>

                                    </div>

                                </div>



                                <div class="content-half-part dokan-product-meta">



                                    <!-- Product title -->

                                    <div class="dokan-form-group">

                                        <label for="post_title" class="dokan-form-label">Titre de l’annonce</label>

                                        <input type="hidden" name="dokan_product_id" id="dokan-edit-product-id" value="<?= $post_id; ?>" maxlength="55"/>

                                        <?php dokan_post_input_box($post_id, 'post_title', array('placeholder' => 'Product name..', 'value' => $post->post_title)); ?>

                                    </div>

                                    <!-- end Product title -->



                                    <!-- Product description -->

                                    <div class="dokan-form-group">

                                        <label for="post_content" class="control-label">Description détaillée</label>

                                        <textarea class="post_content wp-editor-area" style="height: 150px" cols="40" name="post_content" id="post_content" placeholder="Décrivez votre produit et ses caractéristiques techniques en détail. N’oubliez pas de mentionner les éventuels défauts existants !" maxlength="1600"><?= $post->post_content ?></textarea>

                                    </div>

                                    <!-- end Product description -->



                                    <!-- Product brand -->

                                    <div class="dokan-form-group">

                                        <label for="product_brand" class="dokan-form-label">Marque</label>



                                        <?php

                                        $category_args = array(

                                            'show_option_none' => __('- Sélectionnez une marque -', 'dokan-lite'),

                                            'hierarchical' => 1,

                                            'hide_empty' => 0,

                                            'parent' => 0,

                                            'name' => 'pa_brand',

                                            'taxonomy' => 'pa_brand',

                                            'title_li' => '',

                                            'class' => 'product_cat dokan-form-control dokan-select2',

                                            'exclude' => '',

                                        );



                                        $category_args['selected'] = get_term_by('name', $product->get_attribute('pa_brand'), 'pa_brand')->term_id;

                                        wp_dropdown_categories(apply_filters('dokan_product_cat_dropdown_args', $category_args));

                                        ?>

                                    </div>

                                    <!-- end Product brand -->



                                    <!-- Product seniority -->

                                    <div class="dokan-form-group">

                                        <label for="product_seniority" class="dokan-form-label">Ancienneté</label>

                                        <?php

                                        $category_args = array(
                                            'show_option_none' => '- Âge de votre produit -',
                                            'hierarchical'     => 1,
                                            'hide_empty'       => 0,
                                            'parent'           => 0,
                                            'name'             => 'pa_anciennete',
                                            'taxonomy'         => 'pa_anciennete',
                                            'title_li'         => '',
                                            'class'            => 'product_cat dokan-form-control dokan-select2',
                                            'exclude'          => '',
                                        );

                                        $category_args['selected'] = get_term_by('name', $product->get_attribute('pa_anciennete'), 'pa_anciennete')->term_id;

                                        wp_dropdown_categories(apply_filters('dokan_product_cat_dropdown_args', $category_args));

                                        ?>

                                    </div>

                                    <!-- end Product seniority -->



                                    <!-- Product etat -->

                                    <div class="dokan-form-group">

                                        <label for="product_at" class="dokan-form-label">État de votre objet</label>

                                        <?php

                                        $selected_at = dokan_posted_input('pa_etat');

                                        $category_args = array(

                                            'show_option_none' => __(' - État de votre objet - ', 'dokan-lite'),

                                            'hierarchical' => 1,

                                            'hide_empty' => 0,

                                            'parent' => 0,

                                            'name' => 'pa_etat',

                                            'taxonomy' => 'pa_etat',

                                            'class' => 'product_cat dokan-form-control dokan-select2',

                                        );



                                        $category_args['selected'] = get_term_by('name', $product->get_attribute('pa_etat'), 'pa_etat')->term_id;

                                        wp_dropdown_categories(apply_filters('dokan_product_at_dropdown_args', $category_args));

                                        ?>

                                    </div>

                                    <!-- end Product etat -->



                                    <?php generateProductCategoriesDropDownTree($post_id) ?>



                                    <div id="custom-product-attributes">

                                        <!-- Will be filled with custom attributes -->

                                    </div>



                                    <!-- Product price -->

                                    <div class="dokan-form-group">

                                        <div class="dokan-form-group dokan-clearfix dokan-price-container">

                                            <label for="_regular_price" class="dokan-form-label"><?php _e('Price', 'dokan-lite'); ?></label>

                                            <div class="dokan-input-group">

                                                <span class="dokan-input-group-addon"><?= get_woocommerce_currency_symbol(); ?></span>

                                                <?php dokan_post_input_box($post_id, '_regular_price', array('placeholder' => '0.00')); ?>

                                            </div>

                                        </div>

                                    </div>



                                    <div class="dokan-form-group">

                                        <div class="dokan-form-group dokan-clearfix dokan-price-container">

                                            <label for="_sale_price" class="form-label"><?php _e('Discounted Price', 'dokan-lite'); ?></label>

                                            <div class="dokan-input-group">

                                                <span class="dokan-input-group-addon"><?= get_woocommerce_currency_symbol(); ?></span>

                                                <?php  dokan_post_input_box($post_id, '_sale_price', array('placeholder' => __('Special Price', 'dokan'))) ?>

                                            </div>

                                        </div>

                                    </div>

                                    <!-- end Product price -->



                                    <div style="padding: 20px 0 20px 0" class="shipping-mode">

                                        <h3>Modes de livraison</h3>

                                        <div class="dokan-form-group-2">

                                            <input style="display: inline-block" type="checkbox" checked="checked" disabled="disabled"/>

                                            <label for="product_cat" style="font-weight: 500; font-size: 1.2em; margin-left: 3px" class="dokan-form-label">Colissimo</label>

                                            <p>Déposez votre produit dans le bureau de poste de votre choix et avancez les frais qui vous seront remboursés par votre acheteur.</p>

                                        </div>



                                        <div class="dokan-form-group-2">

                                            <input style="display: inline-block" onchange="$(this).val() === 'false' ? $(this).val('false') : $(this).val('true')" type="checkbox" name="pa_main_propre" value="true" <?= $product->get_attribute('pa_main_propre') === 'true' ? 'checked' : '' ?>/>

                                            <label for="product_cat" style="font-weight: 500; font-size: 1.2em; margin-left: 3px" class="dokan-form-label">Remise en main propre</label>

                                            <p>Echangez vos coordonnées directement avec l’acheteur afin d’organiser un rendez-vous près de chez vous pour lui remettre le produit (paiement en ligne non disponible).</p>

                                        </div>



                                        <div style="padding: 20px 0 20px 0" class="shipping-mode">

                                            <h3>Poids du colis</h3>
                                            
                                            <div class="form-group">
                                                <select class="product_cat dokan-form-control dokan-select2" id="sel1">
                                                    <option <? $product->get_weight() === '0.25' ? 'selected' : '' ?> name="product_weight" value="0.25" id="value-250-g">< 250g</option>
                                                    <option <? $product->get_weight() === '0.50' ? 'selected' : '' ?> name="product_weight" value="0.5" id="value-500-g">< 500g</option>
                                                    <option <? $product->get_weight() === '1' ? 'selected' : '' ?> name="product_weight" value="1" id="value-1-kg">< 1kg</option>
                                                    <option <? $product->get_weight() === '2' ? 'selected' : '' ?> name="product_weight" value="2" id="value-2-kg">< 2kg</option>
                                                    <option <? $product->get_weight() === '5' ? 'selected' : '' ?> name="product_weight" value="5" id="value-5-kg">< 5kg</option>
                                                    <option <? $product->get_weight() === '10' ? 'selected' : '' ?> name="product_weight" value="10" id="value-10-kg">< 10kg</option>
                                                    <option <? $product->get_weight() === '30' ? 'selected' : '' ?> name="product_weight" value="30" id="value-30-kg">< 30kg max</option>
											    </select>	
											</div>



                                      <!--    <div class="dokan-form-group-2">

                                                <input type="radio" name="product_weight" <?//= $product->get_weight() === '1' ? 'checked' : '' ?> value="1" id="value-1-kg"    required/><label style="margin-left: 5px" for="value-1-kg"> 1 kg max.</label>

                                                <p>Convient parfaitement pour des petits objets comme un smartphone, une tablette, une montre connectée, etc.</p>

                                            </div>



                                            <div class="dokan-form-group-2">

                                                <input type="radio" name="product_weight" <?//= $product->get_weight() === '2' ? 'checked' : '' ?> value="2" id="value-2-kg" required/><label style="margin-left: 5px" for="value-2-kg"> 2 kg max.</label>

                                                <p>Convient pour des produits standards accompagnés de plusieurs accessoires, comme par exemple un drone avec télécommande et caméra.</p>

                                            </div>



                                            <div class="dokan-form-group-2">

                                                <input type="radio" name="product_weight" <?//= $product->get_weight() === '5' ? 'checked' : '' ?> value="5" id="value-5-kg" required/><label style="margin-left: 5px" for="value-5-kg"> 5 kg max.</label>

                                                <p>Convient pour des produits relativement lourd comme une grosse enceinte.</p>

                                            </div>



                                            <div class="dokan-form-group-2">

                                                <input type="radio" name="product_weight" <?//= $product->get_weight() === '10' ? 'checked' : '' ?> value="10" id="value-10-kg" required/><label style="margin-left: 5px" for="value-10-kg"> 10 kg max.</label>

                                                <p>Convient pour des produits très lourds et volumineux.</p>

                                            </div> -->

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

        <hr>



        <!-- #################### Sidebar ######################### -->



            <div class="dokan-product-edit-right dokan-edit-sidebar">



                <?php dokan_get_template_part('products/edit/sidebar', '', array('pro' => true, 'post' => $post, 'post_id' => $post_id)); ?>



            </div> <!-- .dokan-edit-sidebar -->

            </form>



        <?php } else { ?>



            <?php dokan_seller_not_enabled_notice(); ?>



        <?php } ?>



        </div> <!-- .row -->



        <?php



        /**

         *  dokan_after_edit_product_inside_content_area hook

         *

         * @since 2.4

         */

        do_action('dokan_after_edit_product_inside_content_area');

        ?>



    </div> <!-- #primary .content-area -->



<?php



/**

 *  dokan_dashboard_content_after hook

 *  dokan_after_edit_product_content_area hook

 *

 * @hooked get_dashboard_side_navigation

 * @since 2.4

 */

do_action('dokan_dashboard_content_after');

do_action('dokan_after_edit_product_content_area');

?>



    </div><!-- .dokan-dashboard-wrap -->



<?php



/**

 *  dokan_edit_product_wrap_after hook

 *

 * @since 2.4

 */

do_action('dokan_edit_product_wrap_after', $post, $post_id);

?>





    <script>

      (function ($) {

        $(document).ready(function () {

          $('#tab-container').easytabs({

            animate: true,

            animationSpeed: 10,

            updateHash: false,

          });

        });

      })(jQuery);

    </script>



<?php

wp_reset_postdata();



if (!$from_shortcode) {

    get_footer();

}

