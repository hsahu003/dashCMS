<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*this is the script that needs to run on regular basis
 this helper is added to autoload
*/




/*checks the satus of sub directories of uploads folder on the basis of month and year
*and create them if not present
*
*
*
* purpose of this folder is to organise uploaded images in subdirectories and for faster retirval
*/ 

//The name of the directory that we need to create.
$directoryName = FCPATH . 'assets/images/uploads/' . date("Y") . '/' . date("m");
 
//Check if the directory already exists.
if(!is_dir($directoryName)){
    //Directory does not exist, so lets create it.
    mkdir($directoryName, 0777, true);
}
