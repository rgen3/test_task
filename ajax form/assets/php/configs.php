<?php

return array(
    "db" => array(
        "dns" => "mysql:host=localhost;dbname=testtask",
        "username" => "root",
        "password" => "",
        "options" => array()
    ),

    "validation" => array(
        "username" => array(
            array("required"),
            array("max_length", 50, true),
        ),
        "email" => array(
            array("valid_email"),
            array("max_length", 129)
        ),
        "phone" => array(
            array("required"),
            array("valid_phone"),
            array("max_length", 20, true)
        ),
        "agreement" => array(
            array("required")
        ),
    ),


);