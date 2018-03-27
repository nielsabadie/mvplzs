<div id="tab-container" class='tab-container'> <!-- Only required for left/right tabs -->



    <ul class="dokan_tabs">

        <?php

        $terms = wp_get_object_terms($post->ID, 'product_type');

        $product_type = sanitize_title(current($terms)->name);

        $variations_class = ($product_type == 'simple') ? 'dokan-hide' : '';

        $dokan_product_data_tabs = apply_filters('dokan_product_data_tabs', array(



            'edit' => array(

                'label' => __('Edit', 'dokan'),

                'target' => 'edit-product',

                'class' => array('active'),

            ),

            'options' => array(

                'label' => __('Options', 'dokan'),

                'target' => 'product-options',

                'class' => array(),

            ),

            'inventory' => array(

                'label' => __('Inventory', 'dokan'),

                'target' => 'product-inventory',

                'class' => array(),

            ),

            'shipping' => array(

                'label' => __('Shipping', 'dokan'),

                'target' => 'product-shipping',

                'class' => array('hide_if_virtual'),

            ),

            'attributes' => array(

                'label' => __('Attributes', 'dokan'),

                'target' => 'product-attributes',

                'class' => array(),

            ),

            'variations' => array(

                'label' => __('Variations', 'dokan'),

                'target' => 'product-variations',

                'class' => array('show_if_variable'),

            ),



        ));



        foreach ($dokan_product_data_tabs as $key => $tab) { ?>

            <li class="<?php echo $key; ?>_options <?php echo $key; ?>_tab <?php echo implode(' ', $tab['class']); ?>">

                <a href="#<?php echo $tab['target']; ?>" data-toggle="tab"><?php echo esc_html($tab['label']); ?></a>

            </li>

            <?php

        }



        do_action('dokan_product_data_panel_tabs');

        ?>



    </ul>



    <div id="tabs_container">

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



                        <div class="instruction-inside<?php echo $instruction_class; ?>">

                            <input type="hidden" name="feat_image_id" class="dokan-feat-image-id" value="<?php echo $feat_image_id; ?>">



                            <i class="fa fa-cloud-upload"></i>

                            <a href="#" class="dokan-feat-image-btn btn btn-sm"><?php _e('Upload a product cover image', 'dokan'); ?></a>

                        </div>



                        <div class="image-wrap<?php echo $wrap_class; ?>">

                            <a class="close dokan-remove-feat-image">&times;</a>

                            <?php if ($feat_image_id) { ?>

                                <?php echo get_the_post_thumbnail($post_id, apply_filters('single_product_large_thumbnail_size', 'shop_single'), array('height' => '', 'width' => '')); ?>

                            <?php } else { ?>

                                <img height="" width="" src="" alt="">

                            <?php } ?>

                        </div>

                    </div>

                </div>



                <div class="content-half-part dokan-product-meta">



                    <div class="dokan-form-group">

                        <label for="post_title" class="dokan-form-label">Titre de l’annonce

                            <div class="infobulle">

                                <div class="infobulle">

                                    <i class="fa fa-question-circle" aria-hidden="true" data-title=""></i>

                                    <div class="infobulletext">

                                        <p>Un titre complet est composé des éléments suivants&nbsp;:<br><strong>Catégorie</strong> + <strong>Type</strong> + <strong>Marque</strong><br><br>



                                            Exemple : Drone aérien DJI Spark Mini en parfait état<br>

                                            Mauvais exemple : Super drone pas cher

                                        </p>

                                    </div>

                                </div>

                            </div>

                        </label>

                        <input type="hidden" name="dokan_product_id" id="dokan-edit-product-id" value="<?php echo $post_id; ?>"/>

                        <?php dokan_post_input_box($post_id, 'post_title', array('placeholder' => 'Product name..', 'value' => $post->post_title)); ?>

                    </div>



                    <div class="show_if_simple dokan-clearfix">

                        <div class="dokan-form-group">

                            <div class="dokan-input-group">

                                <span class="dokan-input-group-addon"><?php echo get_woocommerce_currency_symbol(); ?></span>

                                <?php dokan_post_input_box($post_id, '_regular_price', array('placeholder' => '0.00')); ?>

                            </div>

                        </div>

                    </div>



                    <div class="show_if_simple">

                        <div class="special-price-container">



                            <div class="dokan-form-group dokan-clearfix">

                                <div class="dokan-input-group">

                                    <span class="dokan-input-group-addon"><?php echo get_woocommerce_currency_symbol(); ?></span>

                                    <?php dokan_post_input_box($post_id, '_sale_price', array('placeholder' => __('Special Price', 'dokan'))); ?>

                                </div>

                                <!--<a href="#" class="sale-schedule dokan-right"><?php /*_e('Schedule', 'dokan'); */?></a>-->

                            </div>



                            <div class="sale-schedule-container<?php echo $show_schedule ? '' : ' dokan-hide'; ?>">

                                <div class="dokan-form-group">

                                    <div class="dokan-input-group">

                                        <span class="dokan-input-group-addon"><?php _e('From', 'dokan'); ?></span>

                                        <input type="text" name="_sale_price_dates_from" class="dokan-form-control datepicker" value="<?php echo esc_attr($_sale_price_dates_from); ?>" maxlength="10"

                                               pattern="[0-9]{4}-(0[1-9]|1[012])-(0[1-9]|1[0-9]|2[0-9]|3[01])" placeholder="YYYY-MM-DD">

                                    </div>

                                </div>



                                <div class="dokan-form-group">

                                    <div class="dokan-input-group">

                                        <span class="dokan-input-group-addon"><?php _e('To', 'dokan'); ?></span>

                                        <input type="text" name="_sale_price_dates_to" class="dokan-form-control datepicker" value="<?php echo esc_attr($_sale_price_dates_to); ?>" maxlength="10"

                                               pattern="[0-9]{4}-(0[1-9]|1[012])-(0[1-9]|1[0-9]|2[0-9]|3[01])" placeholder="YYYY-MM-DD">

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div> <!-- .show_if_simple -->



                    <?php if (dokan_get_option('product_category_style', 'dokan_selling', 'single') == 'single'): ?>

                    <?php generateProductCategoriesDropDownTree($post_id) ?>



                    <div id="custom-product-attributes">

                        <!--Will be filled with custom attributes-->

                    </div>



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



                    <div class="dokan-form-group">



                        <label for="product_at" class="dokan-form-label">

                            État de votre objet

                            <div class="infobulle">

                                <i class="fa fa-question-circle" aria-hidden="true" data-title=""></i>

                                <div class="infobulletext">



                                    <p><strong>Neuf :</strong> produit sous emballage d’origine, jamais ouvert.</p>

                                    <strong>Très bon état :</strong> produit intact absence de rayures, chocs et traces d’usures.</p>

                                    <p><strong>Bon état :</strong> présence de micro-rayures et légères traces d’usures (ex : frottement). Cet usure ne doit pas impacter le bon usage du produit.</p>

                                    <p><strong>État moyen :</strong> appareil entièrement fonctionnel. Présence de rayures, de légères déformations ou de traces d’usures prononcées.</p>

                                    <p><strong>Mauvais état :</strong> appareil présentant des dysfonctionnements ou ne fonctionnant pas peut importe l’état de l’enveloppe externe.</p>

                                </div>

                            </div>

                        </label>



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



                </div>

                <?php elseif (dokan_get_option('product_category_style', 'dokan_selling', 'single') == 'multiple'): ?>

                    <div class="dokan-form-group">

                        <label for="product_cat" class="form-label"><?php _e('Category', 'dokan'); ?></label>

                        <?php

                        $term = array();

                        $term = wp_get_post_terms($post_id, 'product_cat', array('fields' => 'ids'));

                        include_once DOKAN_LIB_DIR . '/class.taxonomy-walker.php';

                        $drop_down_category = wp_dropdown_categories(array(

                            'show_option_none' => __('', 'dokan'),

                            'hierarchical' => 1,

                            'hide_empty' => 0,

                            'name' => 'product_cat[]',

                            'id' => 'product_cat',

                            'taxonomy' => 'product_cat',

                            'title_li' => '',

                            'class' => 'product_cat dokan-form-control dokan-select2',

                            'exclude' => '',

                            'selected' => $term,

                            'echo' => 0,

                            'walker' => new DokanTaxonomyWalker()

                        ));



                        echo str_replace('<select', '<select data-placeholder="' . __('Select product category', 'dokan') . '" multiple="multiple" ', $drop_down_category);

                        ?>

                    </div>

                <?php endif; ?>



                <!--

                                            <div class="dokan-form-group">

                                                <?php

                /*                                                include_once DOKAN_LIB_DIR . '/class.taxonomy-walker.php';

                                                                $term = wp_get_post_terms($post_id, 'product_tag', array('fields' => 'ids'));

                                                                $selected = ($term) ? $term : array();

                                                                $drop_down_tags = wp_dropdown_categories(array(

                                                                    'show_option_none' => __('', 'dokan'),

                                                                    'hierarchical' => 1,

                                                                    'hide_empty' => 0,

                                                                    'name' => 'product_tag[]',

                                                                    'id' => 'product_tag',

                                                                    'taxonomy' => 'product_tag',

                                                                    'title_li' => '',

                                                                    'class' => 'product_tags dokan-form-control dokan-select2',

                                                                    'exclude' => '',

                                                                    'selected' => $selected,

                                                                    'echo' => 0,

                                                                    'walker' => new DokanTaxonomyWalker()

                                                                ));



                                                                echo str_replace('<select', '<select data-placeholder="' . __('Select product tags', 'dokan') . '" multiple="multiple" ', $drop_down_tags);

                                                                */?>

                                            </div>-->

            </div>

        </div>



        <div class="dokan-rich-text-wrap">

            <div class="dokan-form-group">

                <?php dokan_post_input_box($post_id, 'post_excerpt', array('placeholder' => 'Short description about the product...', 'value' => $post->post_excerpt), 'textarea'); ?>

            </div>



            <div>

                <?php wp_editor($post->post_content, 'post_content', array('editor_height' => 50, 'quicktags' => false, 'media_buttons' => false, 'teeny' => false, 'editor_class' => 'post_content')); ?>

            </div>

        </div>



        <?php do_action('dokan_product_edit_after_main'); ?>



    </div> <!-- #edit-product -->



    <div id="product-options">



        <?php dokan_get_template_part('products/edit/options', '', array('pro' => true, 'post' => $post, 'post_id' => $post_id, '_visibility' => $_visibility)); ?>

        <?php do_action('dokan_product_edit_after_options'); ?>



    </div> <!-- #product-options -->



    <div id="product-inventory">



        <?php dokan_get_template_part('products/edit/inventory', '', array('pro' => true, 'post' => $post, 'post_id' => $post_id, 'product_type' => $product_type)); ?>

        <?php do_action('dokan_product_edit_after_inventory'); ?>



    </div> <!-- #product-inventory -->



    <div id="product-shipping">



        <?php dokan_get_template_part('products/edit/shipping', '', array('pro' => true, 'post' => $post, 'post_id' => $post_id)); ?>

        <?php do_action('dokan_product_edit_after_shipping'); ?>



    </div>



    <!-- ===== Attributes ===== -->



    <div id="product-attributes">



        <?php

        dokan_get_template_part('products/edit/attributes', '', array('pro' => true, 'post' => $post, 'post_id' => $post_id));

        dokan_get_template_part('products/edit/templates-js', '', array('pro' => true, 'post' => $post, 'post_id' => $post_id));

        ?>



        <?php do_action('dokan_product_edit_after_attributes'); ?>



    </div> <!-- #product-attributes -->



    <div id="product-variations">



        <?php dokan_variable_product_type_options(); ?>



        <?php do_action('dokan_product_edit_after_variations'); ?>



    </div> <!-- #product-variations -->



    <?php do_action('dokan_product_tab_content', $post, $seller_id); ?>



</div>



<!--

                                            <div class="dokan-form-group">

                                                <?php

/*                                                include_once DOKAN_LIB_DIR . '/class.taxonomy-walker.php';

                                                $term = wp_get_post_terms($post_id, 'product_tag', array('fields' => 'ids'));

                                                $selected = ($term) ? $term : array();

                                                $drop_down_tags = wp_dropdown_categories(array(

                                                    'show_option_none' => __('', 'dokan'),

                                                    'hierarchical' => 1,

                                                    'hide_empty' => 0,

                                                    'name' => 'product_tag[]',

                                                    'id' => 'product_tag',

                                                    'taxonomy' => 'product_tag',

                                                    'title_li' => '',

                                                    'class' => 'product_tags dokan-form-control dokan-select2',

                                                    'exclude' => '',

                                                    'selected' => $selected,

                                                    'echo' => 0,

                                                    'walker' => new DokanTaxonomyWalker()

                                                ));



                                                echo str_replace('<select', '<select data-placeholder="' . __('Select product tags', 'dokan') . '" multiple="multiple" ', $drop_down_tags);

                                                */?>

                                            </div>-->