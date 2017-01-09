<?php

// only allow inclusion form a contact form
defined( 'CONTACT' ) || die();

// this is an entrypoint
define( 'ENTRYPOINT', 'backend-contact' );

// class autoloader
spl_autoload_register(function ( $class ) {
    include '../classes/' . $class . '.class.php';
})

/*include 'static.inc.php';
include 'ajax.inc.php';*/

?>