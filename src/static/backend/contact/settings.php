<?php

// only allow execution from backend/contact
defined( 'BACKEND/CONTACT' ) || die();

//////////////
// settings //
//////////////

// field array (array to look for in $_POST)
$field_array = 'contact';

// accepted fields (key) and validation methods (value, -> validate_[value]())
$accepted_fields = [
        "name"      => [
                "validate_as"   => 'text',
                "required"      => true
            ],
        "email"     => [
                "validate_as"   => 'email',
                "required"      => true
            ],
        "phone"     => [
                "validate_as"   => 'phone',
                "required"      => false
            ],
        "message"   => [
                "validate_as"   => 'text',
                "required"      => true
            ]
    ];
    
$host_email = 'c0d0g3n@gmail.com';

?>