// Declare our JQuery Alias
jQuery( 'document' ).ready( function( $ ) {

    // Form submission listener
    $( '#edit_account_form' ).submit( function() {

        // Grab our post meta value
        var um_val = $( '#edit_account_form #um_key' ).val();
		var um_user_email = $( '#edit_account_form #um_email' ).val();

        // Do very simple value validation
        if( $( '#edit_account_form #um_key' ).val().length ) {
            $.ajax( {
                url : ajax_url,                 // Use our localized variable that holds the AJAX URL
                type: 'POST',                   // Declare our ajax submission method ( GET or POST )
                data: {                         // This is our data object
                    action  : 'edit_account_cb',          // AJAX POST Action
                    'first_name': um_val,
					'user_email': um_user_email,	// Replace `um_key` with your user_meta key name
                }
            } )
            .success( function( results ) {
                console.log( 'User Meta Updated!' );
            } )
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