<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
* HybridAuth
* http://hybridauth.sourceforge.net | http://github.com/hybridauth/hybridauth
* (c) 2009-2012, HybridAuth authors | http://hybridauth.sourceforge.net/licenses.html
*/

// ----------------------------------------------------------------------------------------
//    HybridAuth Config file: http://hybridauth.sourceforge.net/userguide/Configuration.html
// ----------------------------------------------------------------------------------------

// set on "base_url" the relative url that point to HybridAuth Endpoint
// IMPORTANT: If the "index.php" is removed from the URL (http://codeigniter.com/user_guide/general/urls.html) the
// "/index.php/" part __MUST__ be prepended to the base_url.
$config['base_url'] = '/auth/provider_endpoint';

$config['providers'] = array ( 
            // openid providers
            "OpenID" => array (
                "enabled" => FALSE
            ),

            "Yahoo" => array ( 
                "enabled" => FALSE,
                "keys"    => array ( "id" => "", "secret" => "" ),
            ),

            "AOL"  => array ( 
                "enabled" => FALSE 
            ),

"Google" => array(
  "enabled" => TRUE,
  "keys" => array("id" => "531546002717-tuhjq96skk289t48p7fehkpf6n1j9ljq.apps.googleusercontent.com", "secret" => "k47X0HRfa9_hs3Edd8-FHHq3"),
),

            "Facebook" => array ( 
                "enabled" => FALSE,
                "keys"    => array ( "id" => "", "secret" => "" ), 
            ),

            "Twitter" => array ( 
                "enabled" => FALSE,
                "keys"    => array ( "key" => "", "secret" => "" ) 
            ),

            // windows live
            "Live" => array ( 
                "enabled" => FALSE,
                "keys"    => array ( "id" => "", "secret" => "" ) 
            ),

            "MySpace" => array ( 
                "enabled" => FALSE,
                "keys"    => array ( "key" => "", "secret" => "" ) 
            ),

            "LinkedIn" => array ( 
                "enabled" => FALSE,
                "keys"    => array ( "key" => "", "secret" => "" ) 
            ),

            "Foursquare" => array (
                "enabled" => FALSE,
                "keys"    => array ( "id" => "", "secret" => "" ) 
            ),
        );

// if you want to enable logging, set 'debug_mode' to true  then provide a writable file by the web server on "debug_file"
$config['debug_mode'] = (ENVIRONMENT == 'development');

$config['debug_file'] = APPPATH.'/logs/hybridauth.log';


/* End of file hybridauthlib.php */
/* Location: ./application/config/hybridauthlib.php */