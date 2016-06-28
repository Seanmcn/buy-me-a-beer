<?php
//require_once( plugin_dir_path( __DIR__ ) . "includes/config.php" );
require_once( plugin_dir_path( __DIR__ ) . "payment_services/paypal.php" );

/**
 * Class BuyMeABeerPublicAjax
 */
class BuyMeABeerPublicAjax {
	function formHandler() {
		if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
			$descriptionId  = isset( $_REQUEST['bmabDescriptionId'] ) ? (int) $_REQUEST['bmabDescriptionId'] : null;
			$selectedOption = isset( $_REQUEST['bmabOption'] ) ? (int) $_REQUEST['bmabOption'] : null;
			//open connection
			try {
				if ( $descriptionId !== null && $selectedOption !== null ) {
					// Todo Sean: Different payment providers here
					$paypal = new BuyMeABeerPaypal();
					$paypal->createPayment( $descriptionId, $selectedOption );
				} else {
					error_log( "Error: The 'Buy Me A Beer' wp plugin failed to receive a selected option ID and/or description ID" );
					wp_redirect( "/" );
				}
			} catch ( Exception $e ) {
				error_log( "Error: The 'Buy Me A Beer' wp plugin has encountered an exception while creating a payment with Paypal: " );
				error_log( $e );
			}
		}
	}
}