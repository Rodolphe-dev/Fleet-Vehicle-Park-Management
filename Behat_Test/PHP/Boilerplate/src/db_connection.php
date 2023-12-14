<?php

function openCon()
{
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $dbhost = "localhost";
    $dbuser = "root";
    $dbpass = "";
    $dbname = "behat_test";
    $conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname) or die("Connect failed: %s\n" . $conn -> error);
    $conn->set_charset('utf8mb4');
    return $conn;
}

function closeCon($conn)
{
    $conn->close();
}
