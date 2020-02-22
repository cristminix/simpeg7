<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| APP INFO
|--------------------------------------------------------------------------
|
| Typically this will be your index.php file, unless you've renamed it to
| something else. If you are using mod_rewrite to remove the page set this
| variable so that it is blank.
|
*/

if(!defined('APP_MOD_DIR')){
    define('APP_MOD_DIR', APPPATH . 'modules/apps/apppayrol/');
}
$apppre = 'admpr';
$config[ 'app_prefix_var' ] = $apppre;
$config[ $apppre . '_app_name' ] = 'Sistem Informasi Gaji Pegawai';
$config[ $apppre . '_app_ver' ] = 'Dev 1.0.0';

//$route['apppayroll/(:any)'] = "admin_payroll/page/apppayroll/$1";

// Form Filter
$config['ff_all_value'] = '--All--';

/*
|--------------------------------------------------------------------------
| Default Language - Override
|--------------------------------------------------------------------------
|
| This determines which set of language files should be used. Make sure
| there is an available translation if you intend to use something other
| than english.
|
*/
$config['language']	= 'indonesian';




/*
 * 
 */
$config['app_bjb_text']	= 'BANK JABAR BANTEN CABANG TANGERANG';

/**
 * 
 */
$config['apppayroll_log_archive_dir']	= '/var/www/html/pdamtkrsip/dev2/paysliparchive/';
$config['apppayroll_log_archive_salt']	= md5('696e6f736861646940676d61696c2e636f6d');