<?php

/**
 *  dokan_new_product_wrap_before hook
 *
 * @since 2.4
 */
do_action('dokan_new_product_wrap_before');
?>
    <div class="dokan-dashboard-wrap">

        <?php

        /**
         *  dokan_dashboard_content_before hook
         *  dokan_before_new_product_content_area hook
         *
         * @hooked get_dashboard_side_navigation
         * @since 2.4
         */
        do_action('dokan_dashboard_content_before');
        do_action('dokan_before_new_product_content_area');
        ?>


        <div class="dokan-dashboard-content">

            <?php

            /**
             *  dokan_before_new_product_inside_content_area hook
             *
             * @since 2.4
             */
            do_action('dokan_before_new_product_inside_content_area');
            ?>

            <header class="dokan-dashboard-header dokan-clearfix">
                <h1 class="entry-title">Créer une annonce</h1>
            </header><!-- .entry-header -->


            <div class="dokan-new-product-area">
                <?php if (Dokan_Template_Products::$errors) : ?>
                    <div class="dokan-alert dokan-alert-danger">
                        <a class="dokan-close" data-dismiss="alert">&times;</a>

                        <?php foreach (Dokan_Template_Products::$errors as $error) { ?>

                            <strong><?php _e('Error!', 'dokan-lite'); ?></strong> <?php echo $error ?>.<br>

                        <?php } ?>
                    </div>
                <?php endif; ?>

                <?php if (isset($_GET['created_product'])): ?>
                    <div class="dokan-alert dokan-alert-success">
                        <a class="dokan-close" data-dismiss="alert">&times;</a>
                        <strong><?php _e('Success!', 'dokan-lite'); ?></strong>
                        <?= sprintf(__('You have successfully created <a href="%s"><strong>%s</strong></a> product', 'dokan-lite'), dokan_edit_product_url(intval($_GET['created_product'])), get_the_title(intval($_GET['created_product']))); ?>
                    </div>
                <?php endif ?>

                <?php

                $can_sell = apply_filters('dokan_can_post', true);

                if ($can_sell) {
                    $posted_img = dokan_posted_input('feat_image_id');
                    $posted_img_url = $hide_instruction = '';
                    $hide_img_wrap = 'dokan-hide';

                    if (!empty($posted_img)) {
                        $posted_img = empty($posted_img) ? 0 : $posted_img;
                        $posted_img_url = wp_get_attachment_url($posted_img);
                        $hide_instruction = 'dokan-hide';
                        $hide_img_wrap = '';
                    }
                    if (dokan_is_seller_enabled(get_current_user_id())) { ?>

                        <form class="dokan-form-container" method="post">

                            

                                <div id="newProductViewContainer" class="container-fluid">
                                    <div class="row formRow">
                                        <div class="col col-sm-8 left">
                                        
                                        	<h2>Que vendez-vous ?</h2>
                                            <hr>
                                            <br>
                                        
                                            <div class="row formArea">
                                            	<div id="formCategory" class="col col-sm-12">
                                                	
                                                	<div class=" category-dropdown" data-category-index="1">
                
                                                        <label for="product_cat" class="dokan-form-label">Type de produit</label>
                                                        <?php
                                                        $selected_cat = dokan_posted_input('product_cat');
                                                        $category_args = array(
                                                            'show_option_none' => 'Sélectionnez un type',
                                                            'hierarchical'     => 1,
                                                            'hide_empty'       => 0,
                                                            'parent'           => 0,
                                                            'name'             => 'product_cat',
                                                            'taxonomy'         => 'product_cat',
                                                            'title_li'         => '',
                                                            'class'            => 'product_cat dokan-form-control
															dokan-select2 product-category-dropdown',
                                                            'exclude'          => '',
                                                            'selected'         => $selected_cat,
                                                        );
                
                                                        wp_dropdown_categories(apply_filters(
														'dokan_product_cat_dropdown_args', $category_args));
                                                        ?>
                
                                                    </div>
                
                                                    <div id="custom-product-attributes">
                                                        <!-- Will be filled with custom attributes -->
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="row formArea">
                                            	<div id="formBrand" class="dokan-form-group col col-sm-12">   
                                                    
                                                        <label for="product_brand" class="dokan-form-label">Marque</label>
            
                                                        <?php
                                                        $category_args = array(
                                                            'show_option_none' => 'Sélectionnez une marque',
                                                            'hierarchical'     => 1,
                                                            'hide_empty'       => 0,
                                                            'parent'           => 0,
                                                            'name'             => 'pa_brand',
                                                            'taxonomy'         => 'pa_brand',
                                                            'title_li'         => '',
                                                            'class'            => 'product_cat dokan-form-control dokan-select2',
                                                            'exclude'          => '',
                                                        );
            
                                                        wp_dropdown_categories(apply_filters('dokan_product_cat_dropdown_args', $category_args));
                                                        ?>
        										
                                                </div>   
                                            </div>  
                                            
                                            <div class="row formArea">
                                            	<div id="formSeniority" class="dokan-form-group col col-sm-12">   
                                                    
                                                        <label for="product_anciennete" class="dokan-form-label">Ancienneté</label>

														<?php
                                                        $category_args = array(
                                                            'show_option_none' => 'Âge de votre produit',
                                                            'hierarchical'     => 1,
                                                            'hide_empty'       => 0,
                                                            'parent'           => 0,
                                                            'name'             => 'pa_anciennete',
                                                            'taxonomy'         => 'pa_anciennete',
                                                            'title_li'         => '',
                                                            'class'            => 'product_cat dokan-form-control dokan-select2',
                                                            'exclude'          => '',
                                                        );
                
                                                        wp_dropdown_categories(apply_filters('dokan_product_cat_dropdown_args', $category_args));
                                                        ?>
        										
                                                </div>   
                                            </div>  

                                            <div class="row formArea">
                                            	<div id="formCondition" class="dokan-form-group col col-sm-12">   
                                                
                                                	<label for="product_at" class="dokan-form-label">État</label>
        
                                                    <?php
                                                    $selected_at = dokan_posted_input('pa_etat');
                                                    $drop_down_at = array(
                                                        'show_option_none' => 'Sélectionnez un état',
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
                                                    wp_dropdown_categories(apply_filters('dokan_product_at_dropdown_args', $drop_down_at));
                                                    ?>
                                                </div>
                                           	</div>
                                                                                     
                                        </div>
                                        
                                        <div class="col col-sm-4 right">
                                            
                                        </div>
                                        
                                    </div>
                                    
                                    <div class="row formRow">
 
                                        <div class="col col-sm-8 left">
                                        	
                                            <div id="descriptionTitle">
                                            	<h2>Décrivez votre produit</h2>
                                            	<hr>
                                            </div>
                                        
											<div id="formTitle" class="dokan-form-group col col-sm-12">  
                                            	
                                                	<label for="post_title" class="dokan-form-label infobulle">Titre de l’annonce</label>
                                                    <input class="dokan-form-control infobulle" name="post_title" id="post-title" type="text" placeholder="Ex : Drone aérien Parrot BeBop" required>	
                                                
                                            </div>
                                            
                                            <div id="formDescription" class="dokan-form-group col col-sm-12">
                                                    
                                                	<label for="post_content" class="control-label">Description détaillée</label>
													<textarea class="post_content wp-editor-area" style="height: 150px" cols="40" name="post_content" id="post_content" placeholder="Décrivez votre produit et ses caractéristiques techniques en détail. N’oubliez pas de mentionner les éventuels défauts existants !" value="<?= dokan_posted_textarea('post_content') ?>"></textarea>
                                             
                                            </div>
                                            
                                         </div>
                                         
                                         <div class="col col-sm-4 right">   
                                        
                                         	<div id="formTitleHover" class="col col-sm-12" style="display: none; position:absolute;">
                                                	<p><strong>Quel titre donner à mon produit ?</strong></p>
                                                    <p>Soyez bref, concis et lisible. N’utilisez qu’une majuscule en début de titre et allez à 							
                                                    l’essentiel. Un titre complet est composé de la marque, du modèle et d’un qualificatif clé 
                                                    comme l’état de l’objet par exemple. Mauvais exemple à ne pas reproduire chez vous : super 
                                                    drone PAS CHER !!!</p>
                                         	</div>
                                            
                                            <div id="formDescriptionHover" class="col col-sm-12" style="display: none; position:absolute;">
                                                	<p><strong>Que mettre dans la description de mon produit ?</strong></p>
                                        			<p>Dites-nous tout sur votre article : description précise, caractéristiques 		techniques, accessoires fournis, etc. Soyez toujours honnête sur l’état réel de votre produit et indiquez clairement les défauts éventuels. N’oubliez pas qu’un acheteur averti ne sera pas un acheteur déçu.</p>
                                         	</div>
                                          
                                         </div> 
                                    </div>
                                    
                                    
                               		<div class="row formRow">
 
                                        <div class="col col-sm-8 left">
                                        	
                                            <div id="priceTitle">
                                            	<h2>Fixez votre prix</h2>
                                            	<hr>
                                            </div>
                                        
											<div id="formOriginalPrice" class="dokan-form-group col col-sm-12">  
                                            	
                                                <label for="_regular_price" class="dokan-form-label">
													<?php _e('Price', 'dokan-lite'); ?>
                                                </label>
                                                
													<div class="dokan-input-group">
														<span class="dokan-input-group-addon"><?php echo get_woocommerce_currency_symbol(); ?></span>
														<input type="number" class="dokan-form-control dokan-product-regular-price" name="_regular_price" placeholder="Indiquer le prix auquel vous l'avez acheté" value="<?php echo dokan_posted_input('_regular_price') ?>" min="0" max="8000" step="any">
													</div>
                                                
                                            </div>
                                            
                                            <div id="formYourPrice" class="dokan-form-group col col-sm-12">
                                                    
                                                <label for="_sale_price" class="form-label">
													<?php _e('Discounted Price', 'dokan-lite'); ?>
												</label>

													<div class="dokan-input-group">
														<span class="dokan-input-group-addon"><?php echo get_woocommerce_currency_symbol(); ?></span>
														<input type="number" class="dokan-form-control dokan-product-sales-price" name="_sale_price" placeholder="Indiquer le prix auquel vous souhaitez le vendre" value="<?php echo dokan_posted_input('_sale_price') ?>" min="0" max="5000" step="any" required>
                                                               
													</div>
                                             
                                            </div>
                                            
                                         </div>
                                         
                                         <div class="col col-sm-4 right">   
                                        
                                         	<div id="formOriginalPriceHover" class="col col-sm-12" style="display: none; position:absolute;">
                                                <p><strong>Qu’est-ce que le prix d’origine ?</strong></p>
                                                <p>		
                                                Indiquez le prix auquel le même produit neuf est actuellement vendu sur internet ou en boutique. Vous pouvez récupérer facilement cette information sur le site officiel de la marque en question. N’oubliez pas que les acheteurs adorent faire de bonnes affaires !
                                                </p>
                                         	</div>
                                            
                                            <div id="formYourPriceHover" class="col col-sm-12" style="display: none; position:absolute;">
                                                <p><strong>Comment fixer mon prix de vente ?</strong></p>
                                                <p>		
                                                ➜ Neuf sous emballage d’origine : 60 à 70% du prix d’origine<br>
                                                ➜ Neuf ouvert : 50 à 60% du prix d’origine<br>
                                                ➜ Très bon état : 30 à 50% du prix d’origine<br>
                                                ➜ Bon état : 20 à 30% du prix d’origine<br>
                                                ➜ Etat moyen : 10 à 20% du prix d’origine
                                                </p>
                                         	</div>
                                          
                                         </div> 
                                    </div>
                                    
                                    
                                    <div class="row formRow">
 
                                        <div class="col col-sm-8 left">
                                        	
                                            <div id="shippingTitle">
                                            	<h2>Vous êtes plutôt pigeon voyageur ou drone ?</h2>
                                            	<hr>
                                            </div>
                                        
											<div id="formShippingMode" class="dokan-form-group col col-sm-12">  
                                            	
                                               	<div class="dokan-form-group-2">
													<input style="display: inline-block" type="checkbox" checked="checked" disabled="disabled"/>
													<label for="product_cat" style="font-weight: 500; font-size: 1.2em; margin-left: 3px" class="dokan-form-label">Colissimo</label>
													<p>Déposez votre produit dans le bureau de poste de votre choix et avancez les frais qui vous seront remboursés par votre acheteur.</p>
												</div>

												<!--<div class="dokan-form-group-2">
													<input style="display: inline-block" type="checkbox" name="pa_mondial_relay" onchange="$(this).val() === 'false' ? $(this).val('false') : $(this).val('true')"/>
													<label for="product_cat" style="font-weight: 500; font-size: 1.2em; margin-left: 3px" class="dokan-form-label">Mondial Relay</label>
													<p>Générez automatiquement votre étiquette d’envoi prépayée et déposez votre produit dans le point relais de votre choix.
</p>
												</div>-->

												<div class="dokan-form-group-2">
													<input style="display: inline-block" type="checkbox" name="pa_main_propre" onchange="$(this).val() === 'false' ? $(this).val('false') : $(this).val('true')"/>
													<label for="product_cat" style="font-weight: 500; font-size: 1.2em; margin-left: 3px" class="dokan-form-label">Remise en main propre</label>
													<p>Echangez vos coordonnées directement avec l’acheteur afin d’organiser un rendez-vous près de chez vous pour lui remettre le produit (paiement en ligne non disponible).</p>
												</div>
                                             
                                            </div>
                                            
                                            <div id="formShippingWeight" class="dokan-form-group col col-sm-12">
                                            	<label for="sel1">Quel est le poids du <span style="font-weight:700;">colis</span> à envoyer ?</label>
												<select class="product_cat dokan-form-control dokan-select2" id="sel1">
                                                    <option <?//= $product->get_weight() === '0.25' ? 'checked' : '' ?> value="0.25" id="value-250-g">250g</option>
                                                    <option <?//= $product->get_weight() === '0.50' ? 'checked' : '' ?> value="0.5" id="value-500-g">500g</option>
                                                    <option <?//= $product->get_weight() === '1' ? 'checked' : '' ?> value="1" id="value-1-kg">1kg</option>
                                                    <option <?//= $product->get_weight() === '2' ? 'checked' : '' ?> value="2" id="value-2-kg">2kg</option>
                                                    <option <?//= $product->get_weight() === '5' ? 'checked' : '' ?> value="5" id="value-5-kg">5kg</option>
                                                    <option <?//= $product->get_weight() === '10' ? 'checked' : '' ?> value="10" id="value-10-kg">10kg</option>
                                                    <option <?//= $product->get_weight() === '30' ? 'checked' : '' ?> value="30" id="value-30-kg">30kg max</option>
											  </select>	
                                            </div>
                                            
                                         </div>
                                         
                                         <div class="col col-sm-4 right">   
                                        
                                         	<div id="formShippingModeHover" class="col col-sm-12" style="display: none; position:absolute;">
                                                <p><strong>Quels modes de livraison choisir ?</strong></p>
                                                <p>		
                                                Plus vous sélectionnez de modes de livraison, plus vos chances de vendre rapidement sont élevées. Par défaut, le mode « Colissimo » est coché pour vous permettre de vendre dans toute la France métropolitaine. Les acheteurs apprécient avoir le choix dans les modes de livraison proposés, alors n’hésitez pas à tous les proposer !
                                                </p>
                                         	</div>
                                            
                                            <div id="formShippingWeightHover" class="col col-sm-12" style="display: none; position:absolute;">
                                                <p><strong>Comment définir le poids de mon colis ?</strong></p>
                                                <p>		
                                                ➜ 250 g : très petits objets à glisser dans une enveloppe (carte mémoire, coque, bracelet…).<br>
                                                ➜ 500 g : petits objets très légers comme un chargeur, jeux-vidéo, connectique…).<br>
                                                ➜ 1 kg : objets assez légers et transportables (smartphone, tablette, montre connectée…).<br>
                                                ➜ 2 kg : convient pour des produits standards accompagnés de divers accessoires (consoles + jeux-vidéo par exemple).<br>
                                                ➜ 5 kg : adapté aux produits relativement lourds (télévision, ordinateur tout-en-un…).<br>
                                                ➜ 10 kg : objets très lourds et volumineux (lots de plusieurs produits par exemple).<br>
                                                </p>	
                                         	</div>
                                          
                                         </div> 
                                    </div>
                                    
                                    
                                    <div class="row formRow">
 
                                        <div class="col col-sm-8 left">
                                        	
                                            <div id="pictureTitle">
                                            	<h2>Photos du produit</h2>
                                            	<hr>
                                            </div>
                                        
											<div id="formPicture" class="dokan-form-group col col-sm-12">  
                                            	
                                                <div class="product-edit-container dokan-clearfix">
												<div class="dokan-form-group">
													<label for="" class="control-label">Photos du produit
													</label>
												</div>

												<div class="content-half-part featured-image">
													<div class="featured-image">
														<div class="dokan-feat-image-upload">
															<div class="instruction-inside <?php echo $hide_instruction ?>">
																<input type="hidden" name="feat_image_id" class="dokan-feat-image-id" value="<?php echo $posted_img ?>">
																<i class="fa fa-cloud-upload"></i>
																<a href="#" class="dokan-feat-image-btn dokan-btn"><?php _e('Upload Product Image', 'dokan-lite'); ?></a>
															</div>

															<div class="image-wrap <?php echo $hide_img_wrap ?>">
																<a class="close dokan-remove-feat-image">&times;</a>
																<img src="<?php echo $posted_img_url ?>" alt="">
															</div>
														</div>
													</div>

													<div class="dokan-product-gallery">
														<div class="dokan-side-body" id="dokan-product-images">
															<div id="product_images_container">
																<ul class="product_images dokan-clearfix">
																	<?php
																	if (isset($_POST['product_image_gallery'])) {
																		$product_images = $_POST['product_image_gallery'];
																		$gallery = explode(',', $product_images);

																		if ($gallery) {
																			foreach ($gallery as $image_id) {
																				if (empty($image_id)) {
																					continue;
																				}

																				$attachment_image = wp_get_attachment_image_src($image_id, 'thumbnail');
																				?>
																				<li class="image" data-attachment_id="<?php echo $image_id; ?>">
																					<img src="<?php echo $attachment_image[0]; ?>" alt="">
																					<a href="#" class="action-delete" title="<?php esc_attr_e('Delete image', 'dokan-lite'); ?>">&times;</a>
																				</li>
																				<?php
																			}
																		}
																	}
																	?>
																	<li class="add-image add-product-images tips" data-title="<?php _e('Add gallery image', 'dokan-lite'); ?>">
																		<a href="#" class="add-product-images"><i class="fa fa-plus" aria-hidden="true"></i></a>
																	</li>
																</ul>
																<input type="hidden" id="product_image_gallery" name="product_image_gallery" value="">
															</div>
														</div>
													</div> <!-- .product-gallery -->
												</div>
											</div>
                                                
                                            </div>
                                            
                                        
                                            
                                         </div>
                                         
                                         
                                         <div class="col col-sm-4 right">   
                                        
                                         	<div id="formPictureHover" class="col col-sm-12" style="display: none; position:absolute;">
                                                	<p><strong>Comment réussir les photos de mon produit</strong></p>
													<p>Prenez votre produit en photo sous tous les angles. Privilégiez la lumière du jour et utilisez un arrière-plan neutre et clair. Ce sont vos photos qui aident les acheteurs à se décider. Alors révélez l’artiste qui est en vous !</p>
                                         	</div>
                                            
                                       
                                          
                                         </div> 
                                    </div>
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    		
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                             </div>
              


                            <?php do_action('dokan_new_product_form'); ?>

                           	<br>

                            <div class="dokan-form-group dokan-right">
                                <?php wp_nonce_field('dokan_add_new_product', 'dokan_add_new_product_nonce'); ?>
                                <button type="submit" name="add_product" class="btn btn-primary" value="create_new"><?php esc_attr_e('Create Product', 'dokan-lite'); ?></button>
                            </div>

                        </form>

                    <?php } else { ?>

                        <?php dokan_seller_not_enabled_notice(); ?>

                    <?php } ?>

                <?php } else { ?>

                    <?php do_action('dokan_can_post_notice'); ?>

                <?php } ?>
            </div>

            <?php

            /**
             *  dokan_after_new_product_inside_content_area hook
             *
             * @since 2.4
             */
            do_action('dokan_after_new_product_inside_content_area');
            ?>

        </div> <!-- #primary .content-area -->

        <?php

        /**
         *  dokan_dashboard_content_after hook
         *  dokan_after_new_product_content_area hook
         *
         * @since 2.4
         */
        do_action('dokan_dashboard_content_after');
        do_action('dokan_after_new_product_content_area');
        ?>

    </div><!-- .dokan-dashboard-wrap -->

<?php

/**
 *  dokan_new_product_wrap_after hook
 *
 * @since 2.4
 */
do_action('dokan_new_product_wrap_after');
?>