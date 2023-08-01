<?php
    include_once("database/dbConnection.php");
    include("inserisci.php");

    $conn = OpenCon();
    for ($i = 0; $i < 1; $i++) {
        $name = RandSource('./name.txt');
        $surname = RandSource('./surname.txt');
        echo($name.' '.$surname.' '.RandTel(10));
    }
?>