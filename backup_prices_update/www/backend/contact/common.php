<?php

// contains common logic for ajax and static

// only allow execution from backend/contact
defined( 'BACKEND/CONTACT' ) || die();

$data_submitted = true;

// validate
$validated = validate( $_POST[ $field_array ], $accepted_fields );
$captcha = check_captcha( $_POST[ 'g-recaptcha-response' ] );

// output short (only use if no errors occured)
$filtered_values = $validated[ 'filtered_values' ];
$escaped_values = $validated[ 'escaped_values' ];


// errors short
$errors = $validated[ 'errors' ];
if ( $captcha !== true ) { // not true means error
	$errors[ 'captcha' ] = $captcha;
}

/*echo '<pre>';
print_r( $validated );
echo '</pre>';*/

$form_success = false;
$mail_success = false;
if ( !count( $errors ) ) {
    $form_success = true;
    
    // attempt to send mail
    $mail_success = send_form();
    
}

?>