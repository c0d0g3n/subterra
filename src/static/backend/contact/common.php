<?php

// contains common logic for ajax and static

// only allow execution from backend/contact
defined( 'BACKEND/CONTACT' ) || die();

$data_submitted = true;

// validate
$validated = validate( $_POST[ $field_array ], $accepted_fields );

// output short (only use if no errors occured)
$filtered_values = $validated[ 'filtered_values' ];
$escaped_values = $validated[ 'escaped_values' ];


// errors short
$errors = $validated[ 'errors' ];

/*echo '<pre>';
print_r( $validated );
echo '</pre>';*/

$form_success = false;
if ( !count( $errors ) ) {
    $form_success = true;
    
    // attempt to send mail
    // var_dump(send_form());
    
}

?>