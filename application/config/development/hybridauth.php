<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$this_baseurl = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || isset($_ENV['FORCE_HTTPS'])) ? 'https' : 'http';
$this_baseurl .= '://' . $_SERVER['HTTP_HOST'];
$this_baseurl .= str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);

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
      'callback' => $this_baseurl .'esciauth/google_login',
    ),
    "Facebook" => array(
      "enabled" => FALSE,
      "keys" => array("id" => "", "secret" => ""),
      "trustForwarded" => FALSE,
    ),
    "Twitter" => array(
      "enabled" => TRUE,
      "keys" => array("key" => "4g52tLKR641TqfaeuRLNMsgVa", "secret" => "PEXMKe9VQ5arw7mKpKfpZPj6hVvZo2g44O77WGTKRlp0Po0oSL"),
      'callback' => $this_baseurl .'hauth/window/Twitter',
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
