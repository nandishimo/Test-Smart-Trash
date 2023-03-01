<?php

$connection = null;
$response = [];

Connect();

function Connect()
{
    global $connection, $response;
    $connection = new mysqli("localhost", "npatel10_TestUser", "TestPW159", "npatel10_Lab01");

    if($connection->connect_error)
    {
        $response['result'] = "error";
        $response['errorMessage'] = "Connect Error (" . $connection->connect_errno . ") " . $connection->connect_error;
        echo json_encode($response);
        error_log(json_encode($response));
        die();
    }

    error_log("db.php Connection Successful");
}

function mySQLQuery($query)
{
    global $connection, $response;
    $result = false;
    if($connection == null)
    {
        $response['result'] = "error";
        $response['errorMessage'] = "No database connection established";
        error_log(json_encode($response));
        return $result;
    }

    if(!($result = $connection->query( $query )))
    {
        $response['result'] = "error";
        $response['errorMessage'] = "Query Error : {$connection->errno} : {$connection->error}";
        error_log(json_encode($response));
    }

    return $result;
}