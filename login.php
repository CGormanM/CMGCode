<?php

ob_start();
session_start();

$sUsername          = htmlspecialchars($_POST["username"]);
$sPassword          = htmlspecialchars($_POST["password"]);

$sDbServername      = "localhost";
$sDbUsername        = "cmgcodec_cam";
$sDbPassword        = "27a%uC2Lv3*jI9x";
$sDbName            = "cmgcodec_primary";
$sPasswordQuery     = "SELECT password FROM cmgcodec_primary.users WHERE username = '" . $sUsername . "'";
$sCorrectPassword   = null;

// Create connection
$oDatabaseConnection = mysqli_connect($sDbServername, $sDbUsername, $sDbPassword);

// Check connection
if (!$oDatabaseConnection) {
    die("Connection failed: " . mysqli_connect_error());
}

mysqli_select_db($oDatabaseConnection, $sDbName);
$aQueryResult = $oDatabaseConnection->query($sPasswordQuery);

if ($aQueryResult->num_rows > 0) {
    // output data of each row
    while($row = $aQueryResult->fetch_assoc()) {
        $sCorrectPassword = $row["password"];
    }
}

if(!is_null($sCorrectPassword) && $sPassword === $sCorrectPassword ){
    $_SESSION['valid'] = true;
    $_SESSION['timeout'] = time();
    $_SESSION['username'] = $sUsername;
    echo $sCorrectPassword;
}else{
    echo 'Incorrect password';
}

$oDatabaseConnection->close();

?>
