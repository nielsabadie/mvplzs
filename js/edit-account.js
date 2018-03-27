// Declare our JQuery Alias
jQuery( 'document' ).ready( function( $ ) {

	$('#user_nicename').keypress(function () {
		  var _val = $('user_nicename').val();
		  var _txt = _val.charAt(0).toUpperCase() + _val.slice(1);
		  $('#user_nicename').val(_txt);
	  });
	
	$('#first_name').keypress(function () {
		  var _val = $('#first_name').val();
		  var _txt = _val.charAt(0).toUpperCase() + _val.slice(1);
		  $('#first_name').val(_txt);
	  });
	  
	$('#last_name').keypress(function () {
		  var _val = $('#last_name').val();
		  var _txt = _val.charAt(0).toUpperCase() + _val.slice(1);
		  $('#last_name').val(_txt);
	  });






	// Form submission edit bank account
    $( '#edit_bank_form' ).submit( function() {

	var user_bank_name = $( '#edit_bank_form #user_bank_name' ).val();
	var user_bank_adress_f = $( '#edit_bank_form #user_bank_adress_f' ).val();
	var user_bank_adress_s = $( '#edit_bank_form #user_bank_adress_s' ).val();
	var user_bank_postal = $( '#edit_bank_form #user_bank_postal' ).val();
	var user_bank_city = $( '#edit_bank_form #user_bank_city' ).val();
	var user_bank_iban = $( '#edit_bank_form #user_bank_iban' ).val();
	var user_bank_bic = $( '#edit_bank_form #user_bank_bic' ).val();

	$.ajax( {
	    url : ajax_url,                 // Use our localized variable that holds the AJAX URL
	    type: 'POST',                   // Declare our ajax submission method ( GET or POST )
	    data: {                         // This is our data object
		action  : 'update_account_bank_wire',
		'user_bank_name' : user_bank_name,		// AJAX POST Action
		'user_bank_adress_f' : user_bank_adress_f,		// AJAX POST Action
		'user_bank_adress_s' : user_bank_adress_s,		// AJAX POST Action
		'user_bank_postal' : user_bank_postal,		// AJAX POST Action
		'user_bank_city' : user_bank_city,		// AJAX POST Action
		'user_bank_iban' : user_bank_iban,		// AJAX POST Action
		'user_bank_bic' : user_bank_bic,		// AJAX POST Action

		// Replace `um_key` with your user_meta key name
	    }
	} )
	    .success( function( results ) {
		if(results != "ko") {
		    $( '#edit_bank_form #banner-edit-bankwire' ).addClass('alert-success').html("IBAN ajouté avec succès").show(400).delay(3500).hide(400, function(){
			$(this).removeClass('alert-success'); });
		}
		else {
		    $( '#edit_bank_form #banner-edit-bankwire' ).addClass('alert-error').html("Une erreur est survenu, vérifiez vos informations").show(400).delay(3500).hide(400, function(){
			$(this).removeClass('alert-error'); });
		}
		
	    })

	    .fail( function( data ) {
		console.log( data );
		console.log( 'Request failed: ' + data );
	    } );


	return false;   // Stop our form from submitting
    });

	// Form submission edit user profile
    $( '#edit_account_form' ).submit( function() {

        // Grab our post meta value
		var user_nicename = $( '#edit_account_form #user_nicename' ).val();
        var first_name = $( '#edit_account_form #first_name' ).val();
		var last_name = $( '#edit_account_form #last_name' ).val();
		var user_email = $( '#edit_account_form #user_email' ).val();
		var billing_phone = $( '#edit_account_form #billing_phone' ).val();
		var user_description = $( '#edit_account_form #user_description' ).val();
		var _mc4wp_review_notice_dismissed = $('#edit_account_form input[name=mc4wp]:checked').val();

        // Do very simple value validation
        if( $( '#edit_account_form #first_name' ).val().length ) {
            $.ajax( {
                url : ajax_url,                 // Use our localized variable that holds the AJAX URL
                type: 'POST',                   // Declare our ajax submission method ( GET or POST )
                data: {                         // This is our data object
                    action  : 'um_cb',
					'user_nicename' : user_nicename,		// AJAX POST Action
                    'first_name': first_name,
					'last_name': last_name,
					'user_email': user_email,
					'billing_phone': billing_phone,
					'user_description': user_description,
					'_mc4wp_review_notice_dismissed': _mc4wp_review_notice_dismissed,
					// Replace `um_key` with your user_meta key name
                }
            } )
            .success( function( results ) {	
				var statut = results.success;
				var data = results.data;
				
				if (statut === true) {
					$( '#edit_account_form #banner-edit-account' ).addClass('alert-success').html(data.message).show(400).delay(3500).hide(400, function(){
						$(this).removeClass('alert-success'); });
					
					$( '#user_pseudo' ).html(user_nicename);
					$( '#user_email' ).html(user_email);
					$( '#user_first_name' ).html(first_name);
					$( '#user_last_name' ).html(last_name);
					$( '#billing_phone' ).html(billing_phone);
					$( '#user_description' ).html(user_description);

					if (_mc4wp_review_notice_dismissed > 0) {
						$( '#user_newsletter' ).html('<div id="oui-newsletter" style="display: inline-block;"><i style="color: #00DD03" class="fa fa-check" aria-hidden="true"></i> <p style="display: inline-block; ;">Yeah !</p></div>')

					} else {
						$( '#user_newsletter' ).html('<div id="non-newsletter" style="display: inline-block;"><i style="color: #DD0003" class="fa fa-times" aria-hidden="true"></i> <p style="display: inline-block; ;">Non</p></div>')
					}
					
				
				} else {
					$( '#edit_account_form #banner-edit-account' ).addClass('alert-danger').html(data.message).show(400).delay(5000).hide(400, function(){
						$(this).removeClass('alert-danger'); });
				}
			})
			
				
            .fail( function( data ) {
                console.log( data.responseText );
                console.log( 'Request failed: ' + data.statusText );
            } );

        } else {
            // Show user error message.
        }

        return false;   // Stop our form from submitting
		
    } );
	
	
	
	/* PASSWORD VERIFICATION SCRIPT */
	
	// hide/show password
	$(".icon-wrapper").click(function() {
		$(".toggle-password").toggleClass(".fa-eye");
		var input = $($(".toggle-password").attr("toggle"));
		if (input.attr("type") == "password") {
			input.attr("type", "text");
		} else {
			input.attr("type", "password");
		}
	});
	
	// unset paste to confirm_password
   	$('#confirm_password').bind('paste', function (e) {
       e.preventDefault();
    });

	// strength validation on keyup-event
	$("#password").on("keyup", function() {
		var val = $(this).val(),
			color = testPasswordStrength(val);

		styleStrengthLine(color, val);
	});

	// check password strength
	function testPasswordStrength(value) {
		var strongRegex = new RegExp(
			"^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*])(?=.{8,})"
		),
			mediumRegex = new RegExp(
				"^(((?=.*[a-z])(?=.*[A-Z]))|((?=.*[a-z])(?=.*[0-9]))|((?=.*[A-Z])(?=.*[0-9])))(?=.{6,})"
			);

		if (strongRegex.test(value)) {
			return "green";
		} else if (mediumRegex.test(value)) {
			return "orange";
		} else {
			return "red";
		}
	}

	function styleStrengthLine(color, value) {
		$(".line")
			.removeClass("bg-red bg-orange bg-green")
			.addClass("bg-transparent");
		
		if (value) {
			
			if (color === "red") {
				$(".line:nth-child(1)")
					.removeClass("bg-transparent")
					.addClass("bg-red");
			} else if (color === "orange") {
				$(".line:not(:last-of-type)")
					.removeClass("bg-transparent")
					.addClass("bg-orange");
			} else if (color === "green") {
				$(".line")
					.removeClass("bg-transparent")
					.addClass("bg-green");
			}
		}
	}
	
	$('#password, #confirm_password').on('keyup', function () {
	  if ($('#password').val() == $('#confirm_password').val()) {
		$('#alert_password').html('<i class="fa fa-check"></i> Les mots de passe correspondent.').css('color', '#5BDDB9');
	  } else {
		$('#alert_password').html('<i class="fa fa-times"></i> Les mots de passe ne correspondent pas.').css('color', '#DD0003'); }
	});
	
	/* END PASSWORD VERIFICATION SCRIPT */
	
	 $( '#edit_password_form' ).submit( function() {

        // Grab our post meta value
        var old_password = $( '#edit_password_form #old_password' ).val();
		var password = $( '#edit_password_form #password' ).val();
		var confirm_password = $( '#edit_password_form #confirm_password' ).val();

        // Do very simple value validation
            $.ajax( {
                url : ajax_url,                
                type: 'POST',                   
                data: {                         
                    action  : 'um_edit_password',
					'old_password'     : old_password,
					'password'         : password,
					'confirm_password' : confirm_password,
                    
                }
            } )
            .success( function( results ) {
				var statut = results.success;
				var data = results.data;
				console.log(statut);
				console.log(data.message);
				
				if (statut === true) {
					$( '#edit_password_form #banner-edit-password' ).addClass('alert-success').html(data.message).show(400).delay(3500).hide(400, function(){
						$(this).removeClass('alert-success').removeClass('alert-success');
						
					});} else if ( statut === false ) {
					$( '#edit_password_form #banner-edit-password' ).addClass('alert-danger').html(data.message).show(400).delay(5000).hide(400, function(){
						$(this).removeClass('alert-danger').removeClass('alert-danger');
					});}
            })
			
            .fail( function( data ) {

				console.log(data.responseText);
				console.log(data.statusText);
			
            } );

        return false;   // Stop our form from submitting
		
    } );
	
	
	
	$('#edit_billing_address_form #billing_first_name').keypress(function () {
		  var _val = $('#edit_billing_address_form #billing_first_name').val();
		  var _txt = _val.charAt(0).toUpperCase() + _val.slice(1);
		  $('#edit_billing_address_form #billing_first_name').val(_txt);
	  });
	
	$('#edit_billing_address_form #billing_last_name').keypress(function () {
		  var _val = $('#edit_billing_address_form #billing_last_name').val();
		  var _txt = _val.charAt(0).toUpperCase() + _val.slice(1);
		  $('#edit_billing_address_form #billing_last_name').val(_txt);
	  });
	
	$('#edit_billing_address_form #billing_address_1').keypress(function () {
		  var _val = $('#edit_billing_address_form #billing_address_1').val();
		  var _txt = _val.charAt(0).toUpperCase() + _val.slice(1);
		  $('#edit_billing_address_form #billing_address_1').val(_txt);
	  });
	
	$('#edit_billing_address_form #billing_address_2').keypress(function () {
		  var _val = $('#edit_billing_address_form #billing_address_2').val();
		  var _txt = _val.charAt(0).toUpperCase() + _val.slice(1);
		  $('#edit_billing_address_form #billing_address_2').val(_txt);
	  });
	
	$('#edit_billing_address_form #billing_city').keypress(function () {
		  var _val = $('#edit_billing_address_form #billing_city').val();
		  var _txt = _val.charAt(0).toUpperCase() + _val.slice(1);
		  $('#edit_billing_address_form #billing_city').val(_txt);
	  });

	// Form submission edit billing address
    $( '#edit_billing_address_form' ).submit( function() {

        // Grab our post meta value
        var billing_first_name = $( '#edit_billing_address_form #billing_first_name' ).val();
		var billing_last_name  = $( '#edit_billing_address_form #billing_last_name' ).val();
		var billing_address_1  = $( '#edit_billing_address_form #billing_address_1' ).val();
		var billing_address_2  = $( '#edit_billing_address_form #billing_address_2' ).val();
		var billing_postcode   = $( '#edit_billing_address_form #billing_postcode' ).val();
		var billing_city       = $( '#edit_billing_address_form #billing_city' ).val();

        // Do very simple value validation
        if( $( '#edit_billing_address_form #billing_first_name' ).val().length ) {
            $.ajax( {
                url : ajax_url,                
                type: 'POST',                   
                data: {                         
                    action  : 'um_edit_billing',
					'billing_first_name' : billing_first_name,		
                    'billing_last_name'  : billing_last_name,
					'billing_address_1'  : billing_address_1,
					'billing_address_2'  : billing_address_2,
					'billing_postcode'   : billing_postcode,
					'billing_city'       : billing_city,
                }
            } )	
			
			.success( function( results ) {	
				var statut = results.success;
				var data = results.data;
				
				if (statut === true) {
					$( '#edit_billing_address_form #banner-edit-billing' ).addClass('alert-success').html(data.message).show(400).delay(3500).hide(400, function(){
						$(this).removeClass('alert-success'); });
					
					$( '#billing_first_name' ).html(billing_first_name);
					$( '#billing_last_name' ).html(billing_last_name);
					$( '#billing_address_1' ).html(billing_address_1);
					$( '#billing_postcode' ).html(billing_postcode);
					$( '#billing_city' ).html(billing_city);

					if ( $( '#edit_billing_address_form #billing_address_2' ).val().length ) {
						$( '#billing_address_2' ).html(billing_address_2);
					}
					
				} else {
					$( '#edit_billing_address_form #banner-edit-billing' ).addClass('alert-danger').html(data.message).show(400).delay(5000).hide(400, function(){
						$(this).removeClass('alert-danger'); });
				}
			})
			
			
            .fail( function( data ) {
                console.log( data.responseText );
                console.log( 'Request failed: ' + data.statusText );
            } );

        } else {
            // Show user error message.
        }

        return false;   // Stop our form from submitting
		
    } );
	
	
	
	$('#edit_shipping_address_form #shipping_first_name').keypress(function () {
		  var _val = $('#edit_shipping_address_form #shipping_first_name').val();
		  var _txt = _val.charAt(0).toUpperCase() + _val.slice(1);
		  $('#edit_shipping_address_form #shipping_first_name').val(_txt);
	  });
	
	$('#edit_shipping_address_form #shipping_last_name').keypress(function () {
		  var _val = $('#edit_shipping_address_form #shipping_last_name').val();
		  var _txt = _val.charAt(0).toUpperCase() + _val.slice(1);
		  $('#edit_shipping_address_form #shipping_last_name').val(_txt);
	  });
	
	$('#edit_shipping_address_form #shipping_address_1').keypress(function () {
		  var _val = $('#edit_shipping_address_form #shipping_address_1').val();
		  var _txt = _val.charAt(0).toUpperCase() + _val.slice(1);
		  $('#edit_shipping_address_form #shipping_address_1').val(_txt);
	  });
	
	$('#edit_shipping_address_form #shipping_address_2').keypress(function () {
		  var _val = $('#edit_shipping_address_form #shipping_address_2').val();
		  var _txt = _val.charAt(0).toUpperCase() + _val.slice(1);
		  $('#edit_shipping_address_form #shipping_address_2').val(_txt);
	  });
	
	$('#edit_shipping_address_form #shipping_city').keypress(function () {
		  var _val = $('#edit_shipping_address_form #shipping_city').val();
		  var _txt = _val.charAt(0).toUpperCase() + _val.slice(1);
		  $('#edit_shipping_address_form #shipping_city').val(_txt);
	  });
	
		// Form submission edit shipping address
    $( '#edit_shipping_address_form' ).submit( function() {

        // Grab our post meta value
        var shipping_first_name = $( '#edit_shipping_address_form #shipping_first_name' ).val();
		var shipping_last_name  = $( '#edit_shipping_address_form #shipping_last_name' ).val();
		var shipping_address_1  = $( '#edit_shipping_address_form #shipping_address_1' ).val();
		var shipping_address_2  = $( '#edit_shipping_address_form #shipping_address_2' ).val();
		var shipping_postcode   = $( '#edit_shipping_address_form #shipping_postcode' ).val();
		var shipping_city       = $( '#edit_shipping_address_form #shipping_city' ).val();

        // Do very simple value validation
        if( $( '#edit_shipping_address_form #shipping_first_name' ).val().length ) {
            $.ajax( {
                url : ajax_url,                
                type: 'POST',                   
                data: {                         
                    action  : 'um_edit_shipping',
					'shipping_first_name' : shipping_first_name,		
                    'shipping_last_name'  : shipping_last_name,
					'shipping_address_1'  : shipping_address_1,
					'shipping_address_2'  : shipping_address_2,
					'shipping_postcode'   : shipping_postcode,
					'shipping_city'       : shipping_city,
                }
            } )
			
            .success( function( results ) {	
				var statut = results.success;
				var data = results.data;
				
				if (statut === true) {
					$( '#edit_shipping_address_form #banner-edit-shipping' ).addClass('alert-success').html(data.message).show(400).delay(3500).hide(400, function(){
						$(this).removeClass('alert-success'); });
					
					$( '#shipping_first_name' ).html(shipping_first_name);
					$( '#shipping_last_name' ).html(shipping_last_name);
					$( '#shipping_address_1' ).html(shipping_address_1);
					$( '#shipping_postcode' ).html(shipping_postcode);
					$( '#shipping_city' ).html(shipping_city);

					if ( $( '#edit_shipping_address_form #shipping_address_2' ).val().length ) {
						$( '#shipping_address_2' ).html(shipping_address_2);
					}
					
				} else {
					$( '#edit_shipping_address_form #banner-edit-shipping' ).addClass('alert-danger').html(data.message).show(400).delay(5000).hide(400, function(){
						$(this).removeClass('alert-danger'); });
				}
			})
			
            .fail( function( data ) {
                console.log( data.responseText );
                console.log( 'Request failed: ' + data.statusText );
            } );

        } else {
            // Show user error message.
        }

        return false;   // Stop our form from submitting
		
    } );




	
} );

