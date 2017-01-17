<?php

// only allow execution from backend/contact
defined( 'BACKEND/CONTACT' ) || die();

// Autoload recaptcha
require 'backend/recaptcha/src/autoload.php';

// Autoload PHPMailer
require 'backend/PHPMailer/PHPMailerAutoload.php';

// get credentials NOT PUBLISHED ON GITHUB
require 'backend/contact/credentials.php';









// check captcha
function check_captcha( $in ) {

	global $recaptcha_secret;

	$out = true;

    $recaptcha = new \ReCaptcha\ReCaptcha( $recaptcha_secret );
    $response = $recaptcha->verify( $in );
    if ( !$response->isSuccess() ) {
        $errors = $response->getErrorCodes();
        $out = [
            'code'          => 'recaptcha_incorrect',
            'user_message'  => 'De Recaptcha was incorrect, probeer a.u.b. opnieuw.'
        ];
    }

    return $out;

}









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
            'error'             => false
        ];
    
}










// validate (email)
function validate_email( $in ) {
    
    $out = filter_var( $in, FILTER_VALIDATE_EMAIL );

    // prevent notice
    $error = false;
    
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

    // prevent notice
    $error = false;
    
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
    global $mail_success;
    
    if ( $data_submitted ) {
        
        if ( $mail_success ) { // form accepted and sucessfully sent
            $output .= sprintf( $pre, 'form-message success' );
            $output .= '<p class="message-title">';
            $output .= $close_btn;
            $output .= 'Het formulier werd successvol verzonden</p>';
            $output .= '<p>Wij zullen zo snel mogelijk contact met u opnemen. ';
            $output .= 'Bedankt dat u geïnteresseerd bent in onze service.</p>';
            $output .= '<p class="message-warning">Er is een kopie naar uw e-mail adres verzonden ter controle. ';
            $output .= 'Indien het niet aankomt, verzoeken wij u vriendelijk dit formulier nogmaals in te vullen. ';
            $output .= 'Er deed zich dan waarschijnlijk een technische storing voor. (kijk zeker ook eerst tussen de "ongewenste" berichten!)</p>';
        } else if ( $form_success ) { // form accepted but mail was not accepted for delevery
            // get host email
            global $host_email;

            $output .= sprintf( $pre, 'form-message mail-failed' );
            $output .= '<p class="message-title">';
            $output .= $close_btn;
            $output .= 'Het formulier kon niet verzonden worden</p>';
            $output .= '<p>Er deed zich een technisch probleem voor. ';
            $output .= 'Probeer later het formulier opnieuw te verzenden. ';
            $output .= 'Indien het formulier dan nog niet werkt, ';
            $output .= 'vragen wij u vriendelijk uw gegevens rechtstreeks naar ';
            $output .= '<a href="mailto:' . $host_email . '">' . $host_email . '</a> te sturen ';
            $output .= 'en zeker ook melding te maken van dit probleem. Onze excuses.</p>';
        } else { // form contains some errors / didnt pass validation
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
    global $mail_success;
    
    // field has previously submitted value => display
    if ( !$mail_success && isset( $escaped_values[ $field ] ) ) {
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
    if ( isset( $errors[ $field ] ) ) {
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

    // access to global vars
    global $host_email;
    global $host_email_name;
    global $filtered_values;

    // add credentials NOT PUBLISHED ON GITHUB
    global $smtp_user;
    global $smtp_pass;



    // var_dump( $smtp_user );
    // var_dump( $smtp_pass );
    // echo PHP_EOL;



    // MAIL FOR HOST
    $mail_host = new PHPMailer;

    // connection
    $mail_host->isSMTP();
    $mail_host->Host = 'smtp.gmail.com';
    $mail_host->SMTPAuth = true;
    $mail_host->Username = $smtp_user;
    $mail_host->Password = $smtp_pass;
    $mail_host->SMTPSecure = 'tls';
    $mail_host->Port = 587;

    // mail meta
    $mail_host->setFrom( $filtered_values[ 'email' ], $filtered_values[ 'name' ] );
    $mail_host->addAddress( $host_email );
    $mail_host->Subject = 'CONTACTAANVRAAG van ' . $filtered_values[ 'name' ];

    // content
    $mail_host->isHTML(true);
    $mail_host->Body = '<style>td {padding: 10px;}</style>';
    $mail_host->Body .= '<div class="wrapper" style="font-size: 16px; color: black;">';
    $mail_host->Body .= '<h1>Contactaanvraag</h1>';
    $mail_host->Body .= '<p><b>' . $filtered_values[ 'name' ] . '</b> vulde op <b>' . date( 'd/m/Y (H:i:s)' ) . '</b> het contactformulier van Subterra in.</p>';
    $mail_host->Body .= '<table>';

        $mail_host->Body .= '<tr>';
            $mail_host->Body .= '<td>';
                $mail_host->Body .= 'Naam:';
            $mail_host->Body .= '</td>';
            $mail_host->Body .= '</td>';
            $mail_host->Body .= '<td>';
                $mail_host->Body .= $filtered_values[ 'name' ];
            $mail_host->Body .= '</td>';
        $mail_host->Body .= '</tr>';

        $mail_host->Body .= '<tr>';
            $mail_host->Body .= '<td>';
                $mail_host->Body .= 'E-mail:';
            $mail_host->Body .= '</td>';
            $mail_host->Body .= '</td>';
            $mail_host->Body .= '<td>';
                $mail_host->Body .= $filtered_values[ 'email' ];
            $mail_host->Body .= '</td>';
        $mail_host->Body .= '</tr>';

        $mail_host->Body .= '<tr>';
            $mail_host->Body .= '<td>';
                $mail_host->Body .= 'telefoon:';
            $mail_host->Body .= '</td>';
            $mail_host->Body .= '</td>';
            $mail_host->Body .= '<td>';
                if ( $filtered_values[ 'phone' ] ) {
                    $mail_host->Body .= $filtered_values[ 'phone' ];
                } else {
                    $mail_host->Body .= '<i>(Niet opgegeven)</i>';
                }
            $mail_host->Body .= '</td>';
        $mail_host->Body .= '</tr>';

        $mail_host->Body .= '<tr>';
            $mail_host->Body .= '<td>';
                $mail_host->Body .= 'Bericht:';
            $mail_host->Body .= '</td>';
            $mail_host->Body .= '</td>';
            $mail_host->Body .= '<td>';
                $mail_host->Body .= $filtered_values[ 'message' ];
            $mail_host->Body .= '</td>';
        $mail_host->Body .= '</tr>';

    $mail_host->Body .= '</table>';
    $mail_host->Body .= '</div>';



    // echo 'MAIL HOST';
    // $mail_host->SMTPDebug = 3;  



    // send mail
    $mail_host_status = $mail_host->send();


    // MAIL FOR RESPONDENT
    $mail_respondent = new PHPMailer;

    // connection
    $mail_respondent->isSMTP();
    $mail_respondent->Host = 'smtp.gmail.com';
    $mail_respondent->SMTPAuth = true;
    $mail_respondent->Username = $smtp_user;
    $mail_respondent->Password = $smtp_pass;
    $mail_respondent->SMTPSecure = 'tls';
    $mail_respondent->Port = 587;

    // mail meta
    $mail_respondent->setFrom( $host_email, $host_email_name );
    $mail_respondent->addAddress( $filtered_values[ 'email' ], $filtered_values[ 'name' ] );
    $mail_respondent->Subject = 'U vulde zojuist het contactformulier van Subterra in, waarvoor dank!';

    // content
    $mail_respondent->isHTML(true);
    $mail_respondent->Body = '<style>td {padding: 10px;}</style>';
    $mail_respondent->Body .= '<div class="wrapper" style="font-size: 16px; color: black;">';
    $mail_respondent->Body .= '<h1>Contactformulier succesvol verzonden</h1>';
    $mail_respondent->Body .= '<p>U vulde op <b>' . date( 'd/m/Y (H:i:s)' ) . '</b> het contactformulier van Subterra in, waarvoor dank! Wij zullen uw aanvraag zo snel mogelijk beantwoorden. Hieronder vindt u een overzicht van de ingediende gegevens. U kan op dit bericht antwoorden indien de gegevens niet kloppen of als u een extra mededeling wilt doen.</p>';
    $mail_respondent->Body .= '<table>';

        $mail_respondent->Body .= '<tr>';
            $mail_respondent->Body .= '<td>';
                $mail_respondent->Body .= 'Naam:';
            $mail_respondent->Body .= '</td>';
            $mail_respondent->Body .= '</td>';
            $mail_respondent->Body .= '<td>';
                $mail_respondent->Body .= $filtered_values[ 'name' ];
            $mail_respondent->Body .= '</td>';
        $mail_respondent->Body .= '</tr>';

        $mail_respondent->Body .= '<tr>';
            $mail_respondent->Body .= '<td>';
                $mail_respondent->Body .= 'E-mail:';
            $mail_respondent->Body .= '</td>';
            $mail_respondent->Body .= '</td>';
            $mail_respondent->Body .= '<td>';
                $mail_respondent->Body .= $filtered_values[ 'email' ];
            $mail_respondent->Body .= '</td>';
        $mail_respondent->Body .= '</tr>';

        $mail_respondent->Body .= '<tr>';
            $mail_respondent->Body .= '<td>';
                $mail_respondent->Body .= 'telefoon:';
            $mail_respondent->Body .= '</td>';
            $mail_respondent->Body .= '</td>';
            $mail_respondent->Body .= '<td>';
                if ( $filtered_values[ 'phone' ] ) {
                    $mail_respondent->Body .= $filtered_values[ 'phone' ];
                } else {
                    $mail_respondent->Body .= '<i>(Niet opgegeven)</i>';
                }
            $mail_respondent->Body .= '</td>';
        $mail_respondent->Body .= '</tr>';

        $mail_respondent->Body .= '<tr>';
            $mail_respondent->Body .= '<td>';
                $mail_respondent->Body .= 'Bericht:';
            $mail_respondent->Body .= '</td>';
            $mail_respondent->Body .= '</td>';
            $mail_respondent->Body .= '<td>';
                $mail_respondent->Body .= $filtered_values[ 'message' ];
            $mail_respondent->Body .= '</td>';
        $mail_respondent->Body .= '</tr>';

    $mail_respondent->Body .= '</table>';
    $mail_respondent->Body .= '</div>';



    // echo 'MAIL RESPONDENT';
    // $mail_respondent->SMTPDebug = 3;  



    // send mail
    $mail_respondent_status = $mail_respondent->send();


    // CHECK STATUS
    $mail_success = false;
    if ( $mail_host_status && $mail_respondent_status ) {
        $mail_success = true;
    }

    // if ( !$mail_host_status ) {
    //     echo $mail_host->ErrorInfo;
    // }

    // MAIL FOR RESPONDENT

    
    /*// access
    global $form_host;
    global $filtered_values;
    
    // send mail to host
    $mail_host = mail(
            // to
            $form_host,
            // subject
            'CONTACTAANVRAAG van ' . $filtered_values[ 'name' ],
            // message
            'test',
            // additional headers
            'From: ' . $filtered_values[ 'email' ] . "\r\n"
        );

    // send mail to respondent
    $mail_respondent = mail(
            // to
            $filtered_values[ 'email' ],
            // subject
            'U vulde zojuist het contactformulier van Subterra in',
            // message
            'test',
            // additional headers
            'From: ' . $form_host . "\r\n"
        );

    $mail_success = false;
    if ( $mail_host && $mail_respondent ) {
        $mail_success = true;
    }*/
        
    return $mail_success;
}