
<?php
	if ( ! defined( 'ABSPATH' ) ) {
		exit;
	}

 	$user = wp_get_current_user();
	$user_id = get_current_user_id();

	$user_firstname = $user->user_firstname;
	$user_lastname = $user->user_lastname;
	$user_meta = get_user_meta ($user_id);
	$mango = mpAccess::getInstance();
	//var_dump($mango->get_mp_user($user_id));
?>

<h1 style="text-align: center;">Mon Porte monnaie</h1>
	<div>
		<?php echo do_shortcode ('[mp_wallet]')?>
	</div>
