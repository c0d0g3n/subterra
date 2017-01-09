<?php

// only allow execution from backend/contact
defined( 'BACKEND/CONTACT' ) || die();










// validate (controller)
function validate( $in, $accepted_fields ) {
        
    // safe values (can optionally be sanitized if needed)
    $filtered_values = [];
    $escaped_values = [];
    
    // errors (count = 0 => proceed)
    $errors = [];
    
    // validate (and sanitize if needed)
    foreach( $accepted_fields as $field => $validation ) {

        if ( $validation[ 'required' ] && empty( $in[ $field ] ) ) {
            // input was required but empty
            $filtered_values[ $field ] = null;
            $escaped_values[ $field ] = null;
            $errors[ $field ] = [
                    'code'          => 'field_required',
                    'user_message'  => 'Bovenstaand veld is verplicht.'
                ];
        } else {
            // proceed normal validation
            // validate field  
            $validated = call_user_func( 'validate_' . $validation[ 'validate_as' ], $in[ $field ] );
            
            // store validated (+ possibly sanitized) value
            $filtered_values[ $field ] = $validated[ 'filtered_value' ];
            
            // store escaped value, used to display what user submitted
            $escaped_values[ $field ] = $validated[ 'escaped_value' ];
            
            // store error if present
            if ( $validated[ 'error' ] ) {
                $errors[ $field ] = $validated[ 'error' ];
               /* $errors[ $count ] = $validated[ 'error_count' ];*/
            }
        }
        
    }
    
    // return output
    return [
            'filtered_values'   => $filtered_values,
            'escaped_values'    => $escaped_values,
            'errors'            => $errors
        ];
    
}










// validate (text)
function validate_text( $in ) {
    
    $out = htmlentities( $in );
    
    return [
            'filtered_value'    => $out,
            'escaped_value'     => htmlentities( $in ),
            'error'             => $error
        ];
    
}










// validate (email)
function validate_email( $in ) {
    
    $out = filter_var( $in, FILTER_VALIDATE_EMAIL );
    
    if ( !$out ) {
        // error: not a valid mail address
        $error = [
                'code'          => 'email_invalid',
                'user_message'  => 'Dit e-mail adres is ongeldig.'
            ];
    }
    
    return [
            'filtered_value'    => $out,
            'escaped_value'     => htmlentities( $in ),
            'error'             => $error
        ];
    
}










// validate (phone)
function validate_phone( $in ) {

    // remove spaces
    $out = preg_replace( '/\s+/', '', $in );
    
    if ( !preg_match( '/^[0-9]*$/', $out ) ) {
        // error: not a valid mail address
        $out = false;
        $error = [
                'code'          => 'phone_invalid',
                'user_message'  => 'Dit telefoonnummer bevat ongeldige tekens, enkel getallen zijn toegelaten.'
            ];
    }
    
    return [
            'filtered_value'    => $out,
            'escaped_value'     => htmlentities( $in ),
            'error'             => $error
        ];
    
}










// error class
function field_class( $field, $echo = true ) {
    
    $class = ' '; // space so we can directly append php helper to other classes
    
    // get access to error object
    global $errors;
    
    // field has error => add error class
    if ( isset( $errors[ $field ] ) ) {
        $class .= 'has-error error-' . str_replace( '_', '-', $errors[ $field ][ 'code' ] );
    }
    
    if ( $echo ) {
        echo $class;
    }
    
    return $class;
    
}








function form_class( $echo = true ) {
    
    $class = 'contact-form';
    
    // get access to data_submitted
    global $data_submitted;
    
    if ( $data_submitted ) {
        $class .= ' form-evaluated';
    }
    
    if ( $echo ) {
        echo $class;
    }
    
    return $class;
    
}







function form_message(
        $pre = '<div class="%s">',
        $post = '</div>',
        $close_btn = '<a href="#close" class="close-message"><span class="fa fa-times"></span></a>',
        $echo = true
    ) {
    
    $output = '';
    
    // get status
    global $data_submitted;
    global $form_success;
    
    if ( $data_submitted ) {
        
        if ( $form_success ) {
            $output .= sprintf( $pre, 'form-message success' );
            $output .= '<p class="message-title">';
            $output .= $close_btn;
            $output .= 'Het formulier werd successvol verzonden</p>';
            $output .= '<p>Wij zullen zo snel mogelijk contact met u opnemen. ';
            $output .= 'Bedankt dat u geïnteresseerd bent in onze service.</p>';
            $output .= '<p class="message-warning">Er is een kopie naar uw e-mail adres verzonden ter controle. ';
            $output .= 'Indien het niet aankomt, verzoeken wij u vriendelijk dit formulier nogmaals in te vullen. ';
            $output .= 'Er deed zich dan waarschijnlijk een technische storing voor. (kijk zeker ook eerst tussen de "ongewenste" berichten!)</p>';
        } else {
            $output .= sprintf( $pre, 'form-message has-error' );
            $output .= '<p class="message-title">';
            $output .= $close_btn;
            $output .= 'Enkele velden werden niet correct ingevuld</p>';
            $output .= '<p>Controleer a.u.b. uw gegevens en verzend opnieuw.</p>';
        }
        
        $output .= $post;
        
    }
    
    if ( $echo ) {
        echo $output;
    }
    
    return $output;
    
}








function field_value( $field, $echo = true ) {
    
    $output = '';
    
    // get access to values and status
    global $escaped_values;
    global $form_success;
    
    // field has previously submitted value => display
    if ( !$form_success && isset( $escaped_values[ $field ] ) ) {
        $output = $escaped_values[ $field ];
    }
    
    if ( $echo ) {
        echo $output;
    }
    
    return $output;
    
}








function display_error(
        $field,
        $pre = '<div class="error-message">',
        $post = '</div>', 
        $echo = true
    ) {
    
    $output = '';
    
    // get access to error object
    global $errors;
    
    // field has error => output
    if ( isset( $errors[ $field] ) ) {
        $output .= $pre;
        $output .= $errors[ $field ][ 'user_message' ];
        $output .= $post;
    }
    
    if ( $echo ) {
        echo $output;
    }
    
    return $output;
    
}








function send_form() {
    
    // access
    global $form_host;
    global $filtered_values;
    
    // send mail
    $mail_status = mail(
            // to
            $form_host,
            // subject
            'CONTACTAANVRAAG van ' . $filtered_values[ 'name' ],
            // message
            'test',
            // additional headers
            'From: ' . $filtered_values[ 'email' ] . "\r\n"
        );
        
    return $mail_status;
}