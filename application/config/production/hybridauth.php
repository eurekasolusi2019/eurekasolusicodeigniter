<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| HybridAuth settings
| -------------------------------------------------------------------------
| Your HybridAuth config can be specified below.
|
| See: https://github.com/hybridauth/hybridauth/blob/v2/hybridauth/config.php
*/
$config['hybridauth'] = array(
  "providers" => array(
    // openid providers
    "OpenID" => array(
      "enabled" => FALSE,
    ),
    "Yahoo" => array(
      "enabled" => FALSE,
      "keys" => array("id" => "", "secret" => ""),
    ),
    "AOL" => array(
      "enabled" => FALSE,
    ),
    "Google" => array(
      "enabled" => TRUE,
      "keys" => array("id" => "102711109122-0ij5pqmc0kbbmmlouhds16pdmgj80npi.apps.googleusercontent.com", "secret" => "-r_8RFRDkTJH5_8V5SsSE2Dx"),
      'callback' => 'http://localhost/eurekasolusicodeigniter/' .'esciauth/google_login',
    ),
    "Facebook" => array(
      "enabled" => FALSE,
      "keys" => array("id" => "", "secret" => ""),
      "trustForwarded" => FALSE,
    ),
    "Twitter" => array(
      "enabled" => FALSE,
      "keys" => array("key" => "", "secret" => ""),
      "includeEmail" => FALSE,
    ),
    "Live" => array(
      "enabled" => FALSE,
      "keys" => array("id" => "", "secret" => ""),
    ),
    "LinkedIn" => array(
      "enabled" => FALSE,
      "keys" => array("id" => "", "secret" => ""),
      "fields" => array(),
    ),
    "Foursquare" => array(
      "enabled" => FALSE,
      "keys" => array("id" => "", "secret" => ""),
    ),
  ),
  // If you want to enable logging, set 'debug_mode' to true.
  // You can also set it to
  // - "error" To log only error messages. Useful in production
  // - "info" To log info and error messages (ignore debug messages)
  "debug_mode"   => true ,
  // Path to file writable by the web server. Required if 'debug_mode' is not false
  "debug_file" => APPPATH . 'logs/hybridauth.log',
);
