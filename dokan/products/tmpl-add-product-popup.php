<script type="text/html" id="tmpl-dokan-add-new-product">
    <div id="dokan-add-new-product-popup" class="white-popup dokan-add-new-product-popup">
        <h2><i class="fa fa-briefcase">&nbsp;</i>&nbsp;<?php _e( 'Add New Product', 'dokan-lite' ); ?></h2>

        <form action="" method="post" id="dokan-add-new-product-form">
            <div class="product-form-container">
                <div class="content-half-part dokan-feat-image-content">
                    <div class="dokan-feat-image-upload">
                        <?php
                        $wrap_class        = ' dokan-hide';
                        $instruction_class = '';
                        $feat_image_id     = 0;
                        ?>
                        <div class="instruction-inside<?php echo $instruction_class; ?>">
                            <input type="hidden" name="feat_image_id" class="dokan-feat-image-id" value="<?php echo $feat_image_id; ?>">

                            <i class="fa fa-cloud-upload"></i>
                            <a href="#" class="dokan-feat-image-btn btn btn-sm"><?php _e( 'Upload a product cover image', 'dokan-lite' ); ?></a>
                        </div>

                        <div class="image-wrap<?php echo $wrap_class; ?>">
                            <a class="close dokan-remove-feat-image">&times;</a>
                            <img height="" width="" src="" alt="">
                        </div>
                    </div>

                    <div class="dokan-product-gallery">
                        <div class="dokan-side-body" id="dokan-product-images">
                            <div id="product_images_container">
                                <ul class="product_images dokan-clearfix">

                                    <li class="add-image add-product-images tips" data-title="<?php _e( 'Add gallery image', 'dokan-lite' ); ?>">
									
                                        <a href="#" class="add-product-images"><i class="fa fa-plus" aria-hidden="true"></i></a>
                                    </li>
                                </ul>
                                <input type="hidden" id="product_image_gallery" name="product_image_gallery" value="">
                            </div>
                        </div>
                    </div> <!-- .product-gallery -->
                </div>
				
				<div class="content-half-part dokan-product-meta">
                                <div class="dokan-form-group">
                                    <input class="dokan-form-control" name="post_title" id="post-title" type="text" placeholder="<?php esc_attr_e( 'Product name..', 'dokan-lite' ); ?>" value="<?php echo dokan_posted_input( 'post_title' ); ?>" required>
                                </div>

                                <div class="dokan-form-group">
									<div class="content-half-part sale-price">
                                            <label for="_sale_price" class="form-label">
                                                <?php _e( 'Discounted Price', 'dokan-lite' ); ?>
                                                <!--<a href="#" class="sale_schedule"><?php// _e( 'Schedule', 'dokan-lite' ); ?></a>
                                                <a href="#" class="cancel_sale_schedule dokan-hide"><?php// _e( 'Cancel', 'dokan-lite' ); ?></a>-->
                                            </label>

                                            <div class="dokan-input-group">
                                                <span class="dokan-input-group-addon"><?php echo get_woocommerce_currency_symbol(); ?></span>
                                                <input type="number" class="dokan-form-control dokan-product-sales-price" name="_sale_price" placeholder="Indiquer le prix auquel vous souhaitez le vendre" value="<?php echo dokan_posted_input('_sale_price') ?>" min="0" step="any" required>
                                            </div>
                                       </div>
								
								
								
                                    <div class="dokan-form-group dokan-clearfix dokan-price-container">
                                        <div class="content-half-part">
                                            <label for="_regular_price" class="dokan-form-label"><?php _e( 'Price', 'dokan-lite' ); ?></label>
                                           
                                            <div class="dokan-input-group">
                                                <span class="dokan-input-group-addon"><?php echo get_woocommerce_currency_symbol(); ?></span>
                                                <input type="number" class="dokan-form-control dokan-product-regular-price" name="_regular_price" placeholder="Indiquer le prix auquel vous l'avez acheté" value="<?php echo dokan_posted_input('_regular_price') ?>" min="0" step="any">
                                            </div>
                                        </div>

                                        
                                    </div>
				
				
               

                        
                    </div>
                </div>
                <div class="dokan-clearfix"></div>
                <div class="product-full-container">
                    <?php if ( dokan_get_option( 'product_category_style', 'dokan_selling', 'single' ) == 'single' ): ?>
                        <div class="dokan-form-group">
                            <?php
                            $product_cat = -1;
                            $category_args =  array(
                                'show_option_none' => __( '- Select a category -', 'dokan-lite' ),
                                'hierarchical'     => 1,
                                'hide_empty'       => 0,
                                'name'             => 'product_cat',
                                'id'               => 'product_cat',
                                'taxonomy'         => 'product_cat',
                                'title_li'         => '',
                                'class'            => 'product_cat dokan-form-control dokan-select2',
                                'exclude'          => '',
                                'selected'         => $product_cat,
                            );

                            wp_dropdown_categories( apply_filters( 'dokan_product_cat_dropdown_args', $category_args ) );
                        ?>
                        </div>
                    <?php elseif ( dokan_get_option( 'product_category_style', 'dokan_selling', 'single' ) == 'multiple' ): ?>
                        <div class="dokan-form-group">
                            <?php
                            $term = array();
                            include_once DOKAN_LIB_DIR.'/class.taxonomy-walker.php';
                            $drop_down_category = wp_dropdown_categories(  apply_filters( 'dokan_product_cat_dropdown_args', array(
                                'show_option_none' => __( '', 'dokan-lite' ),
                                'hierarchical'     => 1,
                                'hide_empty'       => 0,
                                'name'             => 'product_cat[]',
                                'id'               => 'product_cat',
                                'taxonomy'         => 'product_cat',
                                'title_li'         => '',
                                'class'            => 'product_cat dokan-form-control dokan-select2',
                                'exclude'          => '',
                                'selected'         => $term,
                                'echo'             => 0,
                                'walker'           => new DokanTaxonomyWalker()
                            ) ) );

                            echo str_replace( '<select', '<select data-placeholder="'.__( 'Select product category', 'dokan-lite' ).'" multiple="multiple" ', $drop_down_category );
                            ?>
                        </div>
                    <?php endif; ?>

                    <div class="dokan-form-group">
                        <?php
                        require_once DOKAN_LIB_DIR.'/class.taxonomy-walker.php';
                        $drop_down_tags = wp_dropdown_categories( array(
                            'show_option_none' => __( '', 'dokan-lite' ),
                            'hierarchical'     => 1,
                            'hide_empty'       => 0,
                            'name'             => 'product_tag[]',
                            'id'               => 'product_tag',
                            'taxonomy'         => 'product_tag',
                            'title_li'         => '',
                            'class'            => 'product_tags dokan-form-control dokan-select2',
                            'exclude'          => '',
                            'selected'         => array(),
                            'echo'             => 0,
                            'walker'           => new DokanTaxonomyWalker()
                        ) );

                        echo str_replace( '<select', '<select data-placeholder="'.__( 'Select product tags', 'dokan-lite' ).'" multiple="multiple" ', $drop_down_tags );
                        ?>
                    </div>

					
					<div class="dokan-form-group">
                                    <textarea style="height: 70px" name="post_excerpt" id="post-excerpt" rows="5" class="dokan-form-control" placeholder="<?php esc_attr_e( 'Le mot du vendeur', 'dokan-lite' ); ?>" required maxlength="140"><?php echo dokan_posted_textarea( 'post_excerpt' ); ?></textarea>
									
                                    <p style="font-size: 0.8em">Max. 140 caractères</p>
                    </div>
					
                </div>
				
				
				 <div class="dokan-form-group">
                                        
                                        <label for="product_cat" class="dokan-form-label">Famille d'appartenance de votre objet <i class="fa fa-question-circle tips" aria-hidden="true" data-title="Indiquez la famille à laquelle appartient votre produit. Nous nous chargerons d'optimiser son affichage sur le site."></i></label>
                                        

                                        <?php
                                        $selected_cat  = dokan_posted_input( 'product_cat' );
                                        $category_args =  array(
                                            'show_option_none' => __( '- Select a category -', 'dokan-lite' ),
                                            'hierarchical'     => 1,
                                            'hide_empty'       => 0,
											'parent'           => 0,
                                            'name'             => 'product_cat',
                                            'id'               => 'product_cat',
                                            'taxonomy'         => 'product_cat',
                                            'title_li'         => '',
                                            'class'            => 'product_cat dokan-form-control dokan-select2',
                                            'exclude'          => '',
                                            'selected'         => $selected_cat,
                                        );

                                        wp_dropdown_categories( apply_filters( 'dokan_product_cat_dropdown_args', $category_args ) );
								 
										?>
                          
                                    </div>
									
									<div class="dokan-form-group">
                                        
                                        <label for="product_at" class="dokan-form-label">
                                        	État de votre objet 
                                        	<div class="infobulle">
                                        		<i class="fa fa-question-circle" aria-hidden="true"  data-title=""></i>
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
                                        $selected_at  = dokan_posted_input( 'pa_etat' );
                                        $drop_down_at =  array(
                                            'show_option_none' => __( ' - État de votre objet - ', 'dokan-lite' ),
                                            'hierarchical'     => 1,
                                            'hide_empty'       => 0,
											'parent'           => 0,
                                            'name'             => 'pa_etat',
                                            'id'               => 'pa_etat',
                                            'taxonomy'         => 'pa_etat',
                                            'title_li'         => '',
                                            'class'            => 'product_cat dokan-form-control dokan-select2',
                                            'exclude'          => '',
                                            'selected'         => $selected_at,
                                        );

                                        wp_dropdown_categories( apply_filters( 'dokan_product_at_dropdown_args', $drop_down_at ) );
								 
										?>
        
                                    </div>
									
									
									<div class="dokan-form-group">
										<label for="post_content" class="control-label"><?php _e( 'Description', 'dokan-lite' ) ?> <i class="fa fa-question-circle tips" data-title="<?php _e( 'Add your product description', 'dokan-lite' ) ?>" aria-hidden="true"></i></label>
										<?php wp_editor( dokan_posted_textarea( 'post_content' ), 'post_content', array('editor_height' => 150, 'quicktags' => false, 'media_buttons' => false, 'teeny' => false, 'editor_class' => 'post_content', 'tinymce' => false) ); ?>
									</div>

									<div style="padding: 20px 0 20px 0" class="shipping-mode">
									<h3>Modes de livraison</h3>
										<div class="dokan-form-group-2">
											<input style="display: inline-block" type="checkbox" checked="checked" disabled="disabled"/>
											<label for="product_cat" style="font-weight: 500; font-size: 1.2em; margin-left: 3px" class="dokan-form-label">Colissimo</label>
											<p>Déposez votre produit dans un bureau de poste de votre choix et avancez les frais qui vous seront remboursés par votre acheteur.</p>
										</div>

										<div class="dokan-form-group-2">
											<input style="display: inline-block" type="checkbox" checked="checked" disabled="disabled"/>
											<label for="product_cat" style="font-weight: 500; font-size: 1.2em; margin-left: 3px" class="dokan-form-label">Mondial Relay</label>
											<p>Déposez votre produit dans un point relais de votre choix et avancez les frais qui vous seront remboursés par votre acheteur.</p>
										</div>

										<div class="dokan-form-group-2">
											<input style="display: inline-block" type="checkbox"/>
											<label for="product_cat" style="font-weight: 500; font-size: 1.2em; margin-left: 3px" class="dokan-form-label">Remise en main propre</label>
											<p>Une fois la transaction effectuée, vous recevrez les coordonnées de l’acheteur afin d’organiser un rendez-vous près de chez vous.</p>
										</div>

									<div style="padding: 20px 0 20px 0" class="shipping-mode">
										<h3>Poids du colis</h3>

										<div class="dokan-form-group-2">
											<input type="radio" name="shipping-weight" value="1" id="value-1-kg" required /><label style="margin-left: 5px" for="value-1-kg"> 1 kg max.</label>
											<p>Convient parfaitement pour des petits objets comme un smartphone, une tablette, une montre connectée, etc.</p>
										</div>

										<div class="dokan-form-group-2">
											<input type="radio" name="shipping-weight" value="2" id="value-2-kg" required /><label style="margin-left: 5px" for="value-2-kg"> 2 kg max.</label>
											<p>Convient pour des produits standards accompagnés de plusieurs accessoires, comme par exemple un drone avec télécommande et caméra.</p>
										</div>

										<div class="dokan-form-group-2">
											<input type="radio" name="shipping-weight" value="5" id="value-5-kg" required /><label style="margin-left: 5px" for="value-5-kg"> 5 kg max.</label>
											<p>Convient pour des produits relativement lourd comme une grosse enceinte.</p>
										</div>

										<div class="dokan-form-group-2">
											<input type="radio" name="shipping-weight" value="10" id="value-10-kg" required /><label style="margin-left: 5px" for="value-10-kg"> 10 kg max.</label>
											<p>Convient pour des produits très lourds et volumineux.</p>
										</div>
									</div>
                           		</div>
				
				
				
            </div>
            <div class="product-container-footer">
                <span class="dokan-show-add-product-error"></span>
                <span class="dokan-spinner dokan-add-new-product-spinner dokan-hide"></span>
                <input type="submit" id="dokan-create-new-product-btn" class="dokan-btn dokan-btn-default" data-btn_id="create_new" value="<?php _e( 'Create product', 'dokan-lite' ) ?>">
            </div>
        </form>
    </div>
</script>
