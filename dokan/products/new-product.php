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
						<div class="container-fluid">
							<form id="newProductForm" class="dokan-form-container" method="post">
                                <div class="row">
									<div class="col-sm-9 hoverHelperArea">
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


											<?php do_action('dokan_new_product_form'); ?>

											<hr>

											<div class="dokan-form-group dokan-right">
												<?php wp_nonce_field('dokan_add_new_product', 'dokan_add_new_product_nonce'); ?>
												<button type="submit" name="add_product" class="dokan-btn dokan-btn-default dokan-btn-theme" value="create_new"><?php esc_attr_e('Create Product', 'dokan-lite'); ?></button>
											</div>
                                    </div>
                                    <div class="col-sm-3 hoverHelper">
                                        <div class="">
                                                Nos conseils pour réussir vos photos :<br>
                                                - Utilisez un arrière-plan <strong>neutre et clair</strong><br>
                                                - Proposer <strong>plusieurs angles</strong> de vue<br>
                                                - Privilégier la <strong>lumière du jour</strong><br>
                                                - N’utilisez <strong>pas de filtres</strong><br>
                                                - Prenez vos <strong>propres photos</strong><br>
                                        </div>
                                    </div>
								</div>


								<div class="row">
									<div class="col-sm-9 hoverHelperArea">
										<div id="newProductTitle" class="dokan-form-group hoverHelperArea">
											<label for="post_title" class="dokan-form-label infobulle">Titre de l’annonce
												<div class="infobulle">
													<div class="infobulle">
														<i class="fa fa-question-circle" aria-hidden="true" data-title=""></i>
													</div>
												</div>
											</label>

											<input class="dokan-form-control infobulle" name="post_title" id="post-title" type="text" placeholder="Ex : Drone aérien DJI Spark Mini" required>
										</div>
									</div>

									<div class="col-sm-3 hoverHelper" style="display: none;">
										<div id="hoverNewProductTitle" class="infobulletext hoverHelper">
											<p>Un titre complet est composé des éléments suivants&nbsp;:<br><strong>Catégorie</strong> + <strong>Type</strong> + <strong>Marque</strong><br><br>

											Exemple : Drone aérien DJI Spark Mini en parfait état<br>
											Mauvais exemple : Super drone pas cher
											</p>
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-sm-9 hoverHelperArea">
										<div class="dokan-form-group hoverHelperArea">
											<label for="post_content" class="control-label">Description détaillée
											</label>
											<textarea class="post_content wp-editor-area" style="height: 150px" cols="40" name="post_content" id="post_content"
											placeholder="Décrivez votre produit et ses caractéristiques techniques en détail. N’oubliez pas de mentionner les éventuels défauts existants !"
											value="<?= dokan_posted_textarea('post_content') ?>"></textarea>
										</div>
									</div>
									<div class="col-sm-3 hoverHelper" style="display: none;">
									
                                        <div class="hoverHelper">
                                            <p>
                                                Nos conseils pour bien décrire votre produit :<br>
                                                - Saisissez les <strong>caractéristiques</strong> techniques (disponibles sur le site officiel de la marque)<br>
                                                - Indiquez les <strong>accessoires fournis</strong> (emballage, chargeur, batterie…)<br>
                                                - Si vous disposez toujours de la <strong>facture</strong> ou si le produit est encore <strong>sous garantie</strong>, mentionnez-le !<br>
                                                - Soyez toujours <strong>honnête</strong> sur l’état réel de votre produit et indiquez clairement les <strong>défauts éventuels</strong>
                                            </p>
                                        </div>
						
									</div>
								</div>

								<div class="row"><!--content-half-part dokan-product-meta-->
									<div class="col-sm-9 hoverHelperArea">
										<div class="dokan-form-group">
											<label for="product_brand" class="dokan-form-label">Marque</label>

											<?php
											$category_args = array(
												'show_option_none' => 'Sélectionnez une marque',
												'hierarchical' => 1,
												'hide_empty' => 0,
												'parent' => 0,
												'name' => 'pa_brand',
												'taxonomy' => 'pa_brand',
												'title_li' => '',
												'class' => 'product_cat dokan-form-control dokan-select2',
												'exclude' => '',
											);

											wp_dropdown_categories(apply_filters('dokan_product_cat_dropdown_args', $category_args));
											?>

										</div>
									</div>

									<div class="col-sm-3 hoverHelper">	
									</div>
								</div>

								<div class="row">
									<div class="col-sm-9 hoverHelperArea">
										<div class="dokan-form-group">

											<label for="product_at" class="dokan-form-label">
												État

											</label>

											<?php
											$selected_at = dokan_posted_input('pa_etat');
											$drop_down_at = array(
												'show_option_none' => 'Sélectionnez un état',
												'hierarchical' => 1,
												'hide_empty' => 0,
												'parent' => 0,
												'name' => 'pa_etat',
												'id' => 'pa_etat',
												'taxonomy' => 'pa_etat',
												'title_li' => '',
												'class' => 'product_cat dokan-form-control dokan-select2',
												'exclude' => '',
												'selected' => $selected_at,
											);
											wp_dropdown_categories(apply_filters('dokan_product_at_dropdown_args', $drop_down_at));
											?>

										</div>	
									</div>

									<div class="col-sm-3 hoverHelper" style="display: none">
                                        <div>
                                            <p><strong>Neuf :</strong> produit sous emballage d’origine, jamais ouvert.</p>
                                            <p><strong>Très bon état :</strong> produit intact absence de rayures, chocs et traces d’usures.</p>
                                            <p><strong>Bon état :</strong> présence de micro-rayures et légères traces d’usures (ex : frottement). Cet usure ne doit pas impacter le bon usage du produit.</p>
                                            <p><strong>État moyen :</strong> appareil entièrement fonctionnel. Présence de rayures, de légères déformations ou de traces d’usures prononcées.</p>
                                            <p><strong>Mauvais état :</strong> appareil présentant des dysfonctionnements ou ne fonctionnant pas peut importe l’état de l’enveloppe externe.</p>
                                        </div>
									</div>
								</div>

								<div class="row">
									<div class="col-sm-9 hoverHelperArea">
										<div class="dokan-form-group category-dropdown" data-category-index="1">
											<label for="product_cat" class="dokan-form-label">Type de produit</label>
											<?php
											$selected_cat = dokan_posted_input('product_cat');
											$category_args = array(
												'show_option_none' => 'Sélectionnez un type',
												'hierarchical' => 1,
												'hide_empty' => 0,
												'parent' => 0,
												'name' => 'product_cat',
												'taxonomy' => 'product_cat',
												'title_li' => '',
												'class' => 'product_cat dokan-form-control dokan-select2 product-category-dropdown',
												'exclude' => '',
												'selected' => $selected_cat,
											);

											wp_dropdown_categories(apply_filters('dokan_product_cat_dropdown_args', $category_args));
											?>
										</div>
									</div>
									<div class="col-sm-3 hoverHelper">
									</div>
								</div>

								<div class="row">
									<div class="col-sm-9 hoverHelperArea">
										<div class="dokan-form-group">
											<div class="dokan-form-group dokan-clearfix dokan-price-container">
												<div class="content-half-part">
													<label for="_regular_price" class="dokan-form-label"><?php _e('Price', 'dokan-lite'); ?></label>
													<div class="dokan-input-group">
														<span class="dokan-input-group-addon"><?php echo get_woocommerce_currency_symbol(); ?></span>
														<input type="number" class="dokan-form-control dokan-product-regular-price" name="_regular_price" placeholder="Indiquer le prix auquel vous l'avez acheté" value="<?php echo dokan_posted_input('_regular_price') ?>" min="0" step="any">
													</div>
												</div>

												<div class="content-half-part sale-price">
													<label for="_sale_price" class="form-label">
														<?php _e('Discounted Price', 'dokan-lite'); ?>
														<!--<a href="#" class="sale_schedule"><?php // _e( 'Schedule', 'dokan-lite' ); ?></a>
													<a href="#" class="cancel_sale_schedule dokan-hide"><?php // _e( 'Cancel', 'dokan-lite' ); ?></a>-->
													</label>

													<div class="dokan-input-group">
														<span class="dokan-input-group-addon"><?php echo get_woocommerce_currency_symbol(); ?></span>
														<input type="number" class="dokan-form-control dokan-product-sales-price" name="_sale_price" placeholder="Indiquer le prix auquel vous souhaitez le vendre"
															   value="<?php echo dokan_posted_input('_sale_price') ?>" min="0" step="any" required>
													</div>
												</div>
											</div>
										</div>						
									</div>
									<div class="col-sm-3 hoverHelper">
									</div>
								</div>

								<div class="row">
									<div class="col-sm-9 hoverHelperArea">
										<div style="padding: 20px 0 20px 0" class="shipping-mode">
											<h3>Modes de livraison</h3>
											<div class="dokan-form-group-2">
												<input style="display: inline-block" type="checkbox" checked="checked" disabled="disabled"/>
												<label for="product_cat" style="font-weight: 500; font-size: 1.2em; margin-left: 3px" class="dokan-form-label">Colissimo</label>
												<p>Déposez votre produit dans un bureau de poste de votre choix et avancez les frais qui vous seront remboursés par votre acheteur.</p>
											</div>

											<div class="dokan-form-group-2">
												<input style="display: inline-block" type="checkbox" name="pa_mondial_relay" onchange="$(this).val() === 'false' ? $(this).val('false') : $(this).val('true')"/>
												<label for="product_cat" style="font-weight: 500; font-size: 1.2em; margin-left: 3px" class="dokan-form-label">Mondial Relay</label>
												<p>Déposez votre produit dans un point relais de votre choix et avancez les frais qui vous seront remboursés par votre acheteur.</p>
											</div>

											<div class="dokan-form-group-2">
												<input style="display: inline-block" type="checkbox" name="pa_main_propre" onchange="$(this).val() === 'false' ? $(this).val('false') : $(this).val('true')"/>
												<label for="product_cat" style="font-weight: 500; font-size: 1.2em; margin-left: 3px" class="dokan-form-label">Remise en main propre</label>
												<p>Une fois la transaction effectuée, vous recevrez les coordonnées de l’acheteur afin d’organiser un rendez-vous près de chez vous.</p>
											</div>

											<div style="padding: 20px 0 20px 0" class="shipping-mode">
												<h3>Poids du colis</h3>

												<div class="form-group">
												  <label for="sel1">Select list (select one):</label>
												  <select class="form-control select2 select2-container select2-container--default" id="sel1">
													<option <?//= $product->get_weight() === '0.25' ? 'checked' : '' ?> value="0.25" id="value-250-g">250g</option>
													<option <?//= $product->get_weight() === '0.50' ? 'checked' : '' ?> value="0.5" id="value-500-g">500g</option>
													<option <?//= $product->get_weight() === '1' ? 'checked' : '' ?> value="1" id="value-1-kg">1kg</option>
													<option <?//= $product->get_weight() === '2' ? 'checked' : '' ?> value="2" id="value-2-kg">2kg</option>
													<option <?//= $product->get_weight() === '5' ? 'checked' : '' ?> value="5" id="value-5-kg">5kg</option>
													<option <?//= $product->get_weight() === '10' ? 'checked' : '' ?> value="10" id="value-10-kg">10kg</option>
													<option <?//= $product->get_weight() === '30' ? 'checked' : '' ?> value="30" id="value-30-kg">30kg max</option>
												  </select>
												</div>

												<!--<div class="dokan-form-group-2">
													<input type="radio" name="product_weight" value="1" id="value-1-kg" required/><label style="margin-left: 5px" for="value-1-kg"> 1 kg max.</label>
													<p>Convient parfaitement pour des petits objets comme un smartphone, une tablette, une montre connectée, etc.</p>
												</div>

												<div class="dokan-form-group-2">
													<input type="radio" name="product_weight" value="2" id="value-2-kg" required/><label style="margin-left: 5px" for="value-2-kg"> 2 kg max.</label>
													<p>Convient pour des produits standards accompagnés de plusieurs accessoires, comme par exemple un drone avec télécommande et caméra.</p>
												</div>

												<div class="dokan-form-group-2">
													<input type="radio" name="product_weight" value="5" id="value-5-kg" required/><label style="margin-left: 5px" for="value-5-kg"> 5 kg max.</label>
													<p>Convient pour des produits relativement lourd comme une grosse enceinte.</p>
												</div>

												<div class="dokan-form-group-2">
													<input type="radio" name="product_weight" value="10" id="value-10-kg" required/><label style="margin-left: 5px" for="value-10-kg"> 10 kg max.</label>
													<p>Convient pour des produits très lourds et volumineux.</p>
												</div>-->
											</div>
										</div>	
									</div>
									<div class="col-sm-3 hoverHelper">
									</div>
								</div>
							</form>
						</div>
                        

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




