<?php

$serverName = "DESKTOP-CQR4K8L\SQLEXPRESS"; //serverName\instanceName
$connectionInfo = array( "Database"=>"CRM_Test", "UID"=>"Admin", "PWD"=>"Letmein1");
$conn = sqlsrv_connect( $serverName, $connectionInfo);

?>