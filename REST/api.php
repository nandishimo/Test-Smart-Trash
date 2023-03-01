<?php
// error_log(json_encode($_GET));
// error_log(json_encode($_REQUEST['request']));

require_once "apiDef.php";

try
{
    $API = new MyAPI($_REQUEST['request']);
    echo $API->processAPI();
}
catch(Exception $e)
{
    echo json_encode(Array('error' => $e->getMessage()));
}