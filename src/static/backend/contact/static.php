<?php

// only allow execution form contact page
defined( 'CONTACT' ) || die();

// identify
define( 'BACKEND/CONTACT', 'static' );

// include settings
require( 'settings.php' );

// include lib
require( 'lib.php' );




// data submitted
if ( isset( $_POST[ $field_array ] ) ) {
    
    // COMMON LOGIC
    require( 'common.php' );

}


?>