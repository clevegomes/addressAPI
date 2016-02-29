<?php

/**
 * gz-encoding  activated
 */
ob_start('ob_gzhandler');


print_r($_REQUEST);exit;
include_once "autoload.php";


$request = (isset($_REQUEST['request']))?$_REQUEST['request']:NULL;


$httpKernelObj = new RESTKernel($request);
echo $httpKernelObj->processAPI();