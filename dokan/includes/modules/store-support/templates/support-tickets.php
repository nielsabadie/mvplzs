<?php

function print_support_conversation_topic( $topic, $topic_b ) {
		$dss = Dokan_Store_Support::init();
        global $wp;

        $is_customer = 1;
        $back_url = trailingslashit( dokan_get_page_url( 'myaccount', 'woocommerce' ). 'support-tickets/' );

        if ( isset($wp->query_vars['support-tickets']) || isset($wp->query_vars['support'])) {
           $is_customer = 1;
           $back_url = trailingslashit( dokan_get_page_url( 'myaccount', 'woocommerce' ). 'support-tickets/' );
        }
		

        if ( $topic->have_posts() ) {
            while ( $topic->have_posts() ) : $topic->the_post();
            ?>
        <a href="<?php echo $back_url ?>">&larr; <?php _e( 'Back to Tickets' , 'dokan' ); ?></a>
            <div class="dokan-support-single-title">
                <h1><?php the_title() ?></h1>
                <?php
                    $Order_id = get_post_meta( get_the_ID(), 'order_id', true );

                    if ( $Order_id ) {
                    ?>
                    <span class="order-reference" >
                        <h3>
                            <?php echo '<a href="' . wp_nonce_url( add_query_arg( array( 'order_id' => $Order_id ), dokan_get_navigation_url( 'orders' ) ), 'dokan_view_order' ) . '"><strong>' . sprintf( __( 'Referenced Order #%s', 'dokan' ), esc_attr( $Order_id) ). '</strong></a>'; ?>
                        </h3>
                    </span>
                    <?php
                    }
                ?>
            </div>
            <div class="dokan-suppport-topic-body dokan-clearfix">
                <div class="dokan-support-user-image dokan-w3">
                    <?php echo get_avatar( get_the_author_meta( 'ID' ), 90 ); ?>

                    <div class="dokan-support-user-name">
                        <h4><?php the_author() ?></h4>
                        <p class="dokan-support-date-time"><?php the_date( 'F j, Y \a\t g:i a' ); ?></p>
                    </div>
                </div>
                <div class="dokan-support-reply dokan-w9">
                    <p><?php the_content(); ?></p>
                </div>
            </div>

            <ul class="dokan-support-commentlist">
                <?php
                $ticket_status = get_post_status( get_the_ID());
                //Gather comments for a specific page/post
                $comments = get_comments( array(
                    'post_id' => get_the_ID(),
                    'status'  => 'approve' //Change this to the type of comments to be displayed
                ) );

                //Display the list of comments
                wp_list_comments( array(
                        'max_depth'         => 0,
                        'page'              => 1,
                        'per_page'          => 5, //Allow comment pagination
                        'reverse_top_level' => true, //Show the latest comments at the top of the list
                        'format'            => 'html5',
                        'callback'          => array( $dss, 'support_comment_format' ),
                    ), $comments );
                    ?>
            </ul>
                <?php
            endwhile;
            ?>

            <div class="dokan-panel dokan-panel-default">
                <div class="dokan-panel-heading">
                    <?php
                    $heading = $ticket_status == 'open' ? __( 'Add Reply' , 'dokan' ) : __( 'Ticket Closed' , 'dokan' );
                    ?>
                    <strong><?php echo $heading ?></strong>

                    <?php if ( ! $is_customer && $ticket_status == 'closed' ) {
                        echo '<em>' . __( '(Adding reply will re-open the ticket)', 'dokan' ) . '</em>';
                    } ?>
                </div>

                <div class="dokan-panel-body dokan-support-reply-form">
                    <?php
                    if ( $ticket_status === 'open' || ! $is_customer ) {
                        $comment_textarea = '<p class="comment-form-comment"><label for="Reply ">' . //_x( 'Give Reply ', 'dokan' ) .
                                            '</label><textarea class="comment-textarea" required="required" id="comment" name="comment" rows="3" aria-required="true">' .' '.
                                            '</textarea></p>';
                        $select_topic_status = '<select class="dokan-support-topic-select dokan-form-control dokan-w3" name="dokan-topic-status-change">
                                                    <option value="0">'.  __( '-- Change Status --', 'dokan' ).'</option>
                                                    <option value="1">'. __( 'Close Ticket', 'dokan' ).'</option>
                                                </select>';

                        $comment_field = $comment_textarea;

                        if ( ! $is_customer ) {
                            $comment_field = $comment_textarea . $select_topic_status.'<div class="clearfix"></div>';
                        }

                        $comment_args = array(
                            'id_form'              => 'dokan-support-commentform',
                            'id_submit'            => 'submit',
                            'class_submit'         => 'submit dokan-btn dokan-btn-theme',
                            'name_submit'          => 'submit',
                            'title_reply'          => __( 'Leave a Reply', 'dokan' ),
                            'title_reply_to'       => '',
                            'cancel_reply_link'    => __( 'Cancel Reply', 'dokan' ),
                            'label_submit'         => __( 'Submit Reply', 'dokan' ),
                            'format'               => 'html5',
                            'comment_field'        => $comment_field,
                            'must_log_in'          => '<p class="must-log-in">' .
                                sprintf( __( 'You must be <a href="%s">logged in</a> to post a comment.' ), wp_login_url( apply_filters( 'the_permalink', get_permalink() ) ) ) . '</p>',
                            'logged_in_as'         => '',
                            'comment_notes_before' => '',
                            'comment_notes_after'  => '',
                        );
                        comment_form( $comment_args, get_the_ID() );
                    } else {
                        ?>
                        <div class="dokan-alert dokan-alert-warning">
                            <?php _e( 'This ticket has been closed. Open a new support ticket if you have any further query.', 'dokan' ); ?>
                        </div>
                        <?php
                    }
                    wp_reset_query();
                    ?>
                </div>
            </div>
        <?php
        } elseif ( $topic_b->have_posts() ) {
            while ( $topic_b->have_posts() ) : $topic_b->the_post();
            ?>
        <a href="<?php echo $back_url ?>">&larr; <?php _e( 'Back to Tickets' , 'dokan' ); ?></a>
            <div class="dokan-support-single-title">
                <h1><?php the_title() ?></h1>
                <?php
                    $Order_id = get_post_meta( get_the_ID(), 'order_id', true );

                    if ( $Order_id ) {
                    ?>
                    <span class="order-reference" >
                        <h3>
                            <?php echo '<a href="' . wp_nonce_url( add_query_arg( array( 'order_id' => $Order_id ), dokan_get_navigation_url( 'orders' ) ), 'dokan_view_order' ) . '"><strong>' . sprintf( __( 'Referenced Order #%s', 'dokan' ), esc_attr( $Order_id) ). '</strong></a>'; ?>
                        </h3>
                    </span>
                    <?php
                    }
                ?>
            </div>
            <div class="dokan-suppport-topic-body dokan-clearfix">
                <div class="dokan-support-user-image dokan-w3">
                    <?php echo get_avatar( get_the_author_meta( 'ID' ), 90 ); ?>

                    <div class="dokan-support-user-name">
                        <h4><?php the_author() ?></h4>
                        <p class="dokan-support-date-time"><?php the_date( 'F j, Y \a\t g:i a' ); ?></p>
                    </div>
                </div>
                <div class="dokan-support-reply dokan-w9">
                    <p><?php the_content(); ?></p>
                </div>
            </div>

            <ul class="dokan-support-commentlist">
                <?php
                $ticket_status = get_post_status( get_the_ID());
                //Gather comments for a specific page/post
                $comments = get_comments( array(
                    'post_id' => get_the_ID(),
                    'status'  => 'approve' //Change this to the type of comments to be displayed
                ) );

                //Display the list of comments
                wp_list_comments( array(
                        'max_depth'         => 0,
                        'page'              => 1,
                        'per_page'          => 5, //Allow comment pagination
                        'reverse_top_level' => true, //Show the latest comments at the top of the list
                        'format'            => 'html5',
                        'callback'          => array( $dss, 'support_comment_format' ),
                    ), $comments );
                    ?>
            </ul>
                <?php
            endwhile;
            ?>

            <div class="dokan-panel dokan-panel-default">
                <div class="dokan-panel-heading">
                    <?php
                    $heading = $ticket_status == 'open' ? __( 'Add Reply' , 'dokan' ) : __( 'Ticket Closed' , 'dokan' );
                    ?>
                    <strong><?php echo $heading ?></strong>

                    <?php if ( ! $is_customer && $ticket_status == 'closed' ) {
                        echo '<em>' . __( '(Adding reply will re-open the ticket)', 'dokan' ) . '</em>';
                    } ?>
                </div>

                <div class="dokan-panel-body dokan-support-reply-form">
                    <?php
                    if ( $ticket_status === 'open' || ! $is_customer ) {
                        $comment_textarea = '<p class="comment-form-comment"><label for="Reply ">' . //_x( 'Give Reply ', 'dokan' ) .
                                            '</label><textarea class="comment-textarea" required="required" id="comment" name="comment" rows="3" aria-required="true">' .' '.
                                            '</textarea></p>';
                        $select_topic_status = '<select class="dokan-support-topic-select dokan-form-control dokan-w3" name="dokan-topic-status-change">
                                                    <option value="0">'.  __( '-- Change Status --', 'dokan' ).'</option>
                                                    <option value="1">'. __( 'Close Ticket', 'dokan' ).'</option>
                                                </select>';

                        $comment_field = $comment_textarea;

                        if ( ! $is_customer ) {
                            $comment_field = $comment_textarea . $select_topic_status.'<div class="clearfix"></div>';
                        }

                        $comment_args = array(
                            'id_form'              => 'dokan-support-commentform',
                            'id_submit'            => 'submit',
                            'class_submit'         => 'submit dokan-btn dokan-btn-theme',
                            'name_submit'          => 'submit',
                            'title_reply'          => __( 'Leave a Reply', 'dokan' ),
                            'title_reply_to'       => '',
                            'cancel_reply_link'    => __( 'Cancel Reply', 'dokan' ),
                            'label_submit'         => __( 'Submit Reply', 'dokan' ),
                            'format'               => 'html5',
                            'comment_field'        => $comment_field,
                            'must_log_in'          => '<p class="must-log-in">' .
                                sprintf( __( 'You must be <a href="%s">logged in</a> to post a comment.' ), wp_login_url( apply_filters( 'the_permalink', get_permalink() ) ) ) . '</p>',
                            'logged_in_as'         => '',
                            'comment_notes_before' => '',
                            'comment_notes_after'  => '',
                        );
                        comment_form( $comment_args, get_the_ID() );
                    } else {
                        ?>
                        <div class="dokan-alert dokan-alert-warning">
                            <?php _e( 'This ticket has been closed. Open a new support ticket if you have any further query.', 'dokan' ); ?>
                        </div>
                        <?php
                    }
                    wp_reset_query();
                    ?>
                </div>
            </div>
        <?php
		
		} else { ?>
            <div class="dokan-error">
                <?php _e( 'Topic not found' , 'dokan' ) ?>
            </div>
        <?php
        }
    }

function print_support_topics_list( $customer_id ) {
	
	$dss      = Dokan_Store_Support::init();
	$query = $dss->get_support_topics_by_seller( $customer_id );
	$query_b = $dss->get_topics_by_customer( $customer_id );
	
        ?>
        <div class="dokan-support-topics-list">
             <?php
                if ( $query->posts || $query_b->posts ) : ?>
            <table class="dokan-table dokan-support-table">
                <thead>
                    <tr>
                        <!--<th><?php// _e( 'Topic', 'dokan' ) ?></th>-->
                        <th><?php _e( 'Title', 'dokan' ) ?></th>
                        <th><?php _e( 'Expéditeur', 'dokan' ) ?></th>
                        <!--<th><?php// _e( 'Status', 'dokan' ) ?></th>-->
                        <th><?php _e( 'Date', 'dokan' ) ?></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                
                <?php
                    foreach ( $query->posts as $topic ) :
                        $topic_url = trailingslashit( dokan_get_page_url( 'myaccount', 'woocommerce' ). 'support-tickets/'  . '' . $topic->ID );
                        ?>
                <tr>
                     
                            <!--<td>
                                <a href="<?php// echo $topic_url; ?>"
                                   <strong>
                                       <?php// echo '#'.$topic->ID ?>
                                    </strong>
                                </a>
                            </td>-->
                            <td>
                                <a href="<?php echo $topic_url ?>">
                                    <?php echo $topic->post_title; ?>
                                </a>
                            </td>
                            <td>
                               <?php
										$store_info = dokan_get_store_info( $topic->post_author);
										
										$store_name = isset( $store_info['store_name'] ) ? $store_info['store_name'] : get_user_meta( $topic->post_author, 'nickname', true );
										$store_url = dokan_get_store_url( $topic->post_author );
									
								?>
								<a href="<?php echo $store_url ?>">
									<div class="dokan-support-customer-name">
										<?php echo get_avatar( $topic->post_author, 50 ) ?>
										<strong><?php  echo get_user_meta( $topic->post_author, 'nickname', true ); ?></strong>
									</div>
								</a>
                            </td>
                            
                            
                            
                             <?php
                                switch ( $topic->post_status ) {
                                    case 'open':
                                        $c_status = 'closed';
                                        $btn_icon = 'fa-close';
                                        $topic_status = 'dokan-label-success';
                                        $btn_title = __( 'close topic' , 'dokan' );
                                        break;
                                    case 'closed':
                                        $c_status = 'open';
                                        $btn_icon = 'fa-file-o';
                                        $topic_status = 'dokan-label-danger';
                                        $btn_title = __( 're-open topic' , 'dokan' );
                                        break;

                                    default:
                                        $c_status = 'closed';
                                        $btn_icon = 'fa-close';
                                        $topic_status = 'dokan-label-success';
                                        $btn_title = __( 'close topic' , 'dokan' );
                                        break;
                                }
                                ?>
                            <!--<td><span class="dokan-label <?php// echo $topic_status ?>"><?php// echo $topic->post_status; ?></span></td>-->
                            <td class="dokan-order-date"><span><?php echo get_the_date( 'j F Y \à G:i a' , $topic->ID )?></span></td>
                            <td>
                               	<a class="dokan-btn dokan-btn-default dokan-btn-sm tips dokan-support-status-change" href="<?php echo $topic_url ?>" data-original-title="Voir la conversation"  title="" ><i class="fa fa-eye">&nbsp;</i></a>
                               	
                                <a class="dokan-btn dokan-btn-default dokan-btn-sm tips dokan-support-status-change" onclick="return confirm('Are you sure?');" href="<?php echo wp_nonce_url( add_query_arg( array( 'action' => 'dokan-support-topic-status', 'topic_id' => $topic->ID, 'ticket_status' => $c_status ), dokan_get_navigation_url('support') ), 'dokan-change-topic-status' ); ?>" title="" data-changing_post_id="<?php echo $topic->ID ?>" data-original-title="<?php echo $btn_title ?>"><i class="fa <?php echo $btn_icon ?>">&nbsp;</i></a>
                            </td>
                          
					</tr>
            
              <?php endforeach;
              
	
              
              foreach ( $query_b->posts as $topic ) :
                        $topic_url = trailingslashit( dokan_get_page_url( 'myaccount', 'woocommerce' ). 'support-tickets/'  . '' . $topic->ID );
                        ?>
                        <tr>
                            <!--<td>
                                <a href="<?php// echo $topic_url; ?>"
                                   <strong>
                                       <?php// echo '#'.$topic->ID ?>
                                    </strong>
                                </a>
                            </td>-->
                            <td>
                                <a href="<?php echo $topic_url ?>">
                                    <?php echo $topic->post_title; ?>
                                </a>
                            </td>
                            <td>
                            	<?php
									$store_info = dokan_get_store_info( $topic->post_author);
										
									$store_name = isset( $store_info['store_name'] ) ? $store_info['store_name'] : get_user_meta( $topic->post_author, 'nickname', true );
									$store_url = dokan_get_store_url( $topic->post_author );
										
								?>
								<a href="<?php echo $store_url ?>">
									<div class="dokan-support-customer-name">
										<?php echo get_avatar( $topic->post_author, 50 ) ?>
										<strong><?php  echo get_user_meta( $topic->post_author, 'nickname', true ); ?></strong>
									</div>
								</a>
                            </td>
                             <?php
                                switch ( $topic->post_status ) {
                                    case 'open':
                                        $c_status = 'closed';
                                        $btn_icon = 'fa-close';
                                        $topic_status = 'dokan-label-success';
                                        $btn_title = __( 'close topic' , 'dokan' );
                                        break;
                                    case 'closed':
                                        $c_status = 'open';
                                        $btn_icon = 'fa-file-o';
                                        $topic_status = 'dokan-label-danger';
                                        $btn_title = __( 're-open topic' , 'dokan' );
                                        break;

                                    default:
                                        $c_status = 'closed';
                                        $btn_icon = 'fa-close';
                                        $topic_status = 'dokan-label-success';
                                        $btn_title = __( 'close topic' , 'dokan' );
                                        break;
                                }
                                ?>
                            <!--<td><span class="dokan-label <?php// echo $topic_status ?>"><?php// echo $topic->post_status; ?></span></td>-->
                            <td class="dokan-order-date"><span><?php echo get_the_date( 'j F Y \à G:i a' , $topic->ID )?></span></td>
                            <td>
                              	<a class="dokan-btn dokan-btn-default dokan-btn-sm tips dokan-support-status-change" href="<?php echo $topic_url ?>" data-original-title="Voir la conversation"  title="" >
                              		<i class="fa fa-eye">&nbsp;</i>
                              	</a>
                               
                                <a class="dokan-btn dokan-btn-default dokan-btn-sm tips dokan-support-status-change" onclick="return confirm('Are you sure?');" href="<?php echo wp_nonce_url( add_query_arg( array( 'action' => 'dokan-support-topic-status', 'topic_id' => $topic->ID, 'ticket_status' => $c_status ), dokan_get_navigation_url('support') ), 'dokan-change-topic-status' ); ?>" title="" data-changing_post_id="<?php echo $topic->ID ?>" data-original-title="<?php echo $btn_title ?>">
                                	<i class="fa <?php echo $btn_icon ?>">&nbsp;</i
                                </a>
                            </td>
                        </tr>
              <?php endforeach; ?>
          <?php else :?>
                    <div class="dokan-error">
                        <?php _e( 'No tickets found!' , 'dokan' ) ?>
                    </div>
          <?php endif;?>
                </tbody>
            </table>
        </div>
        <?php
        $dss->topics_pagination( 'support' );
        wp_reset_postdata();
	
	
	
	/*******************************************************************
	
	$query = $dss->get_support_topics_by_seller( $customer_id );
        ?>
        <div class="dokan-support-topics-list">
            <?php if ( $query->posts ) : ?>
            <table class="dokan-table dokan-support-table">
                <thead>
                    <tr>
                        <th><?php _e( 'Topic', 'dokan' ) ?></th>
                        <th><?php _e( 'Store Name', 'dokan' ) ?></th>
                        <th><?php _e( 'Title', 'dokan' ) ?></th>
                        <th><?php _e( 'Status', 'dokan' ) ?></th>
                        <th><?php _e( 'Date', 'dokan' ) ?></th>
                    </tr>
                </thead>
                <tbody>
                <?php
                foreach ( $query->posts as $topic ) :
                    $topic_url = trailingslashit( dokan_get_page_url( 'myaccount', 'woocommerce' ). 'support-tickets/'  . '' . $topic->ID );

                    ?>
                    <tr>
                        <td>
                            <a href="<?php echo $topic_url; ?>"
                               <strong>
                                   <?php echo '#'.$topic->ID ?>
                                </strong>
                            </a>
                        </td>
                        <td>
                            <div class="dokan-support-customer-name">
                                <?php
                                    $store_info = dokan_get_store_info( $topic->store_id );
                                    $store_name = isset( $store_info['store_name'] ) ? $store_info['store_name'] : get_user_meta( $topic->store_id, 'nickname', true );
                                    $store_url = dokan_get_store_url( $topic->store_id );
                                ?>
                                <strong><a href="<?php echo $store_url ?>" target="_blank"><?php  echo $store_name ?></a></strong>
                            </div>
                        </td>
                        <td>
                            <a href="<?php echo $topic_url ?>">
                                <?php echo $topic->post_title; ?>
                            </a>
                        </td>
                        <?php
                            switch ( $topic->post_status ) {
                                case 'open':
                                    $c_status = 'closed';
                                    $btn_icon = 'fa-close';
                                    $topic_status = 'dokan-label-success';
                                    $btn_title = __( 'close topic' , 'dokan' );
                                    break;
                                case 'closed':
                                    $c_status = 'open';
                                    $btn_icon = 'fa-file-o';
                                    $topic_status = 'dokan-label-danger';
                                    $btn_title = __( 're-open topic' , 'dokan' );
                                    break;

                                default:
                                    $c_status = 'closed';
                                    $btn_icon = 'fa-close';
                                    $topic_status = 'dokan-label-success';
                                    $btn_title = __( 'close topic' , 'dokan' );
                                    break;
                            }
                            ?>
                        <td><span class="dokan-label <?php echo $topic_status ?>"><?php echo $topic->post_status; ?></span></td>

                        <td class="dokan-order-date"> <span><?php echo $topic->post_date?></span></td>
                    </tr>
                <?php endforeach; ?>
                <?php else :?>
                    <div class="dokan-error">
                        <?php _e( 'No tickets found!' , 'dokan' ) ?>
                    </div>
                <?php endif;?>
                </tbody>
            </table>

        </div>
        <?php
        $dss->topics_pagination('support-tickets');
        wp_reset_postdata();*/
	
	
}

/*function get_support_topics_by_users( $customer_id ) {


        $pagenum = isset( $_GET['pagenum'] ) ? absint( $_GET['pagenum'] ) : 1;
        $offset  = ( $pagenum - 1 ) * $this->per_page;
        $paged = (get_query_var( 'paged' )) ? get_query_var( 'paged' ) : 1;
        // WP_Query arguments

        $args = array(
            'post_type'  => 'dokan_store_support',
            'posts_per_page' => $this->per_page,
            'offset'         => $offset,
            'paged'          => $paged,
            'meta_query' => array(
                array(
                    'key'     => 'store_id',
                    'value'   => $seller_id,
                    'compare' => '=',
                    'type'    => 'NUMERIC',
                ),
            ),
        );

        $args = apply_filters( 'dokan_get_topic_by_seller_qry_args', $args );

        $args['post_status'] = 'open';
        if ( isset( $_GET['ticket_status'] ) ) {
            $args['post_status'] = $_GET['ticket_status'];
        }

        // The Query
        $query = new WP_Query( $args );

        $this->total_query_result = $query->found_posts;

        return $query;
    }*/

do_action( 'woocommerce_account_navigation' ); ?>

<div class="woocommerce-MyAccount-content">
	<?php
		$dss      = Dokan_Store_Support::init();
		$topic_id = get_query_var( 'support-tickets' );

		if( is_numeric( $topic_id ) ) {
		    $topic = $dss ->get_single_topic_by_customer( $topic_id, dokan_get_current_user_id() );
			$topic_b = $dss ->get_single_topic( $topic_id, dokan_get_current_user_id() );
		}
	?>
	<div class="dokan-support-customer-listing dokan-support-topic-wrapper">
	    <?php
	        if ( empty( $topic ) || isset( $_GET['ticket_status'] ) ) {
	            //$dss->support_topic_status_list( false );
	            print_support_topics_list( dokan_get_current_user_id() );
				
	        } else {
	            print_support_conversation_topic( $topic, $topic_b );
	        }
	    ?>
	</div>

</div>