<?php 
    session_start();
    include_once("../../database/dbConnection.php");
    $conn = OpenCon();
    $ag_query = 'SELECT a.id FROM agenzia AS a WHERE a.nome = \''.$_SESSION["agency"].'\'';
    $ag_id = $conn -> query($ag_query) -> fetch_array();
    $ag = $ag_id["id"];             // agency id
    $meta = $_POST["meta"];

    foreach ($meta as $x) {
        $date = $x["date"];
        if ($date != '') {
            $tmp = explode('-', $date);
            $date = "$tmp[2]-$tmp[1]-$tmp[0]";
            $date = date("Y-m-d", strtotime($date));
        } else {
            $date = "NULL";
        }
        $insert_query = "INSERT INTO agenzia_utente (tipoContratto, scadenza, id_agenzia, id_utente)
                VALUES ('{$x["contract"]}', ".($date != "NULL" ? ("'{$date}'") : $date).", '{$ag}', '{$x["userid"]}')";
        echo("{$date}");
        $res = $conn -> query($insert_query);
    }

    $agency_name = str_replace(' ', '+', $_SESSION["agency"]);
    header("location:../info_agency.php?agency={$agency_name}");
