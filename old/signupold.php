<?php
    $username = $_POST['username'];  
    $email = $_POST['email'];
    $psw = $_POST['psw'];
    
    //database connection
    $serverName = "DESKTOP-CQR4K8L\SQLEXPRESS"; //serverName\instanceName
    $database = "CRM_Test";
    $uid = "Admin";
    $pass = "Letmein1";
    $connection = [
        "Database" => $database,
        "Uid" => $uid,
        "PWD" => $pass
    ];
    $conn = sqlsrv_connect($serverName, $connection);
        
    if(!$conn)
    {
        echo "Connection could not be established.<br />";
        die( print_r( sqlsrv_errors(), true));
    }

    $sql = "DECLARE @responseMessage NVARCHAR(250)

    EXEC dbo.spAddUser
        @pUsername = ?,
        @pEmail = ?,
        @pHashPassword = ?,
        @responseMessage=@responseMessage OUTPUT";

    $params = array($username, $email, $psw);

    sqlsrv_query( $conn, $sql, $params);

    header("Location: index.html");
    die();

?>