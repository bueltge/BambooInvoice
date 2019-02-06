<?php

if ( floor( phpversion() ) < 5 ) {
	die( 'BambooInvoice requires PHP version 5 or higher.  After you have satisfied this, you can try re-installing.' );
}

define('ENVIRONMENT', 'development');
/*
|---------------------------------------------------------------
| PHP ERROR REPORTING LEVEL
|---------------------------------------------------------------
*/
if (defined('ENVIRONMENT'))
{
    switch (ENVIRONMENT)
    {
        case 'development':
            // Report all errors
            error_reporting(E_ALL);

            // Display errors in output
            ini_set('display_errors', 1);
        break;

        case 'testing':
        case 'production':
            // Report all errors except E_NOTICE
            // This is the default value set in php.ini
            error_reporting(E_ALL ^ E_NOTICE);

            // Don't display errors (they can still be logged)
            ini_set('display_errors', 0);
        break;

        default:
            exit('The application environment is not set correctly.');
    }
}

/*
|---------------------------------------------------------------
| SYSTEM FOLDER NAME
|---------------------------------------------------------------
|
| This variable must contain the name of your "system" folder.
| Include the path if the folder is not in the same  directory
| as this file.
|
| NO TRAILING SLASH!
|
*/
$system_folder = "bamboo_system_files";

/*
|---------------------------------------------------------------
| APPLICATION FOLDER NAME
|---------------------------------------------------------------
|
| If you want this front controller to use a different "application"
| folder then the default one you can set its name here. The folder 
| can also be renamed or relocated anywhere on your server.
| For more info please see the user guide:
| http://www.codeigniter.com/user_guide/general/managing_apps.html
|
|
| NO TRAILING SLASH!
|
*/
$application_folder = "application";

/*
|===============================================================
| END OF USER CONFIGURABLE SETTINGS
|===============================================================
*/

/*
|---------------------------------------------------------------
| SET THE SERVER PATH
|---------------------------------------------------------------
|
| Let's attempt to determine the full-server path to the "system"
| folder in order to reduce the possibility of path problems.
|
*/
if ( function_exists( 'realpath' ) AND @realpath( dirname( __FILE__ ) ) !== FALSE ) {
	$system_folder = str_replace( "\\", "/", realpath( dirname( __FILE__ ) ) ) . '/' . $system_folder;
}

/*
|---------------------------------------------------------------
| DEFINE APPLICATION CONSTANTS
|---------------------------------------------------------------
|
| EXT		- The file extension.  Typically ".php"
| FCPATH	- The full server path to THIS file
| SELF		- The name of THIS file (typically "index.php)
| BASEPATH	- The full server path to the "system" folder
| APPPATH	- The full server path to the "application" folder
|
*/
define( 'EXT', '.' . pathinfo( __FILE__, PATHINFO_EXTENSION ) );
define( 'FCPATH', __FILE__ );
define( 'SELF', pathinfo( __FILE__, PATHINFO_BASENAME ) );
define( 'BASEPATH', $system_folder . '/' );

if ( is_dir( $application_folder ) ) {
	define( 'APPPATH', $application_folder . '/' );
} else {
	if ( $application_folder == '' ) {
		$application_folder = 'application';
	}

	define( 'APPPATH', BASEPATH . $application_folder . '/' );
}

/*
|---------------------------------------------------------------
| DEFINE E_STRICT
|---------------------------------------------------------------
|
| Some older versions of PHP don't support the E_STRICT constant
| so we need to explicitly define it otherwise the Exception class 
| will generate errors.
|
*/
if ( ! defined( 'E_STRICT' ) ) {
	define( 'E_STRICT', 2048 );
}

/*
|---------------------------------------------------------------
| LOAD THE FRONT CONTROLLER
|---------------------------------------------------------------
|
| And away we go...
|
*/
require_once BASEPATH . 'codeigniter/CodeIgniter' . EXT;