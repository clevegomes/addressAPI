<?php

/**
 * gz-encoding  activated
 */
ob_start('ob_gzhandler');



include_once "autoload.php";


$request = (isset($_REQUEST['request']))?$_REQUEST['request']:NULL;


$httpKernelObj = new RESTKernel($request);
echo $httpKernelObj->processAPI();