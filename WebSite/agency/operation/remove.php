<?php
    session_start();
    include_once("../../database/dbConnection.php");
    $conn = OpenCon();
    $agency_name = str_replace(' ', '+', $_SESSION["agency"]);
    $remove_query = 'DELETE FROM agenzia_utente AS a WHERE a.id_agenzia = 
            (SELECT a.id FROM agenzia AS a WHERE a.nome = \''.$_SESSION["agency"].'\')
            AND a.id_utente = (SELECT u.id FROM utente AS u WHERE u.email = \''.$_POST["uemail"].'\');';
    $res = $conn -> query($remove_query);
    header("location:../info_agency.php?agency={$agency_name}");
?>
