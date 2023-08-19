<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="../style/style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Easy Book</title>
</head>
<style>
    table,
    th {
        text-align: center;
        border: 1px solid black;
        border-collapse: collapse;
        padding-left: 4px;
        padding-right: 4px;
        color: red;
        width: auto;
    }

    td {
        border: 1px solid black;
        border-collapse: collapse;
        padding-left: 4px;
        padding-right: 4px;
        color: black;
        width: auto;
    }
</style>

<body>
    <h1>Easy Book</h1>
    <?php
    session_start();
    include_once("../database/dbConnection.php");
    PrintLoginInfo();
    $conn = OpenCon();

    if (!isset($_SESSION["id"])) {
        header("location:../user/login.php");
    }
    echo ("<hr>");

    $vehi_query = 'SELECT * FROM mezzo as m WHERE m.id = \'' . $_GET["vehicle"] . '\'';
    $vehi = $conn->query($vehi_query)->fetch_array();
    echo ("<h3>Vehicle N -> {$vehi["id"]}</h3>");
    ?>

    <table style="text-align: center">
        <tr>
            <th>Type</th>
            <th>Immatriculation year</th>
            <th>Available places</th>
        </tr>

        <tr>
            <td><?php echo ($vehi["tipo"]); ?></td>
            <td><?php echo ($vehi["annoImmatricolazione"]); ?></td>
            <td><?php echo ($vehi["postiDisponibili"]); ?></td>
        </tr>
    </table>
    <br>

    <div style="display: flex">
        <form action="operation/suspend_transport.php" method="get" style="flex-basis: 70px">
            <button name="vehi" value="<?php echo ($vehi["id"]); ?>">Suspend</button>
        </form>

        <form action="operation/manage_transport.php" method="get">
            <button name="vehi" value="<?php echo ($vehi["id"]); ?>">Modify</button>
        </form>
    </div>
    <hr>
    <h2>All maintenance</h2>
    <table>
        <tr>
            <th>Reason</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Description</th>
            <th>Operation</th>
        </tr>
        <?php
        $trs_query = "SELECT * 
                FROM manutenzione as m, mezzo_manutenzione as mm
                WHERE m.id = mm.id_manutenzione
                AND mm.id_mezzo = '{$_GET["vehicle"]}'";
        $trs = $conn->query($trs_query);

        foreach ($trs as $x) {
            echo ("<tr>");
            echo ("<td>{$x["motivo"]}</td>");
            echo ("<td>{$x["dataInizio"]}</td>");
            echo ("<td>{$x["dataFine"]}</td>");
            echo ("<td>{$x["descrizione"]}</td>");
            echo ("<td>");
            echo ("<form action='operation/manage_maintenance.php' method='post'>
                    <button name='man' value='{$x["id_manutenzione"]}'>Modify</button>
                    <input type='hidden' name='vehicle' value='{$x["id_mezzo"]}'>
                </form>");
            if (!strlen($x["dataFine"]) > 0 || $x["dataFine"] < date('Y-m-d')) {
                echo ("<form action='operation/active_transport.php' method='post'>
                    <button name='vehicle' value='{$x["id_mezzo"]}'>Active</button>
                    <input type='hidden' name='man' value='{$x["id_manutenzione"]}'>
                </form>");
            }
            echo ("</td>");
            echo ("</tr>");
        }
        ?>
    </table>
    <?php

    echo ("<hr>");
    $travel_query = "SELECT v.* FROM viaggio as v, viaggio_mezzo as vm
                WHERE v.id = vm.id_viaggio
                AND v.dataPartenza > CURDATE()
                AND vm.id_mezzo = '{$_GET["vehicle"]}'
                GROUP BY v.id";
    $trv = $conn->query($travel_query);

    if ($trv->num_rows > 0) {
    ?>
        <h4>These travels will be removed:</h4>
        <table style="text-align: center;" class="tab">
            <tr>
                <th class="tab">Schedule</th>
                <th class="tab">Departure Date</th>
                <th class="tab">Return Date</th>
                <th class="tab">Remaining places</th>
                <th class="tab">Price</th>
            </tr>
            <?php
            foreach ($trv as $x) {
                $dest_query = 'SELECT l.nome
                            FROM localita as l, itinerario_localita as il 
                            WHERE l.id = il.id_localita
                            AND il.id_itinerario = 
                                (SELECT v.id_itinerario
                                FROM viaggio as v
                                WHERE v.id = \'' . $x["id"] . '\');';
                $dest = $conn->query($dest_query);
                $cities = "";
                foreach ($dest as $c) {
                    $cities .= ($c["nome"] . '-');
                }
                $cities = substr_replace($cities, "", -1);
                echo ("<tr>");
                echo ("<td>$cities</td>");
                echo ("<td>{$x["dataPartenza"]}</td>");
                echo ("<td>{$x["dataArrivo"]}</td>");
                echo ("<td>{$x["postiDisponibili"]}</td>");
                echo ("<td>{$x["prezzo"]}</td>");
                echo ("</tr>");
            }
            ?>

        </table>
    <?php
    }

    $agency_name = str_replace(' ', '+', $_SESSION["agency"]);
    echo ("<br><button onclick=\"location.href='info_agency.php?agency={$agency_name}'\">Go back</button>");
    ?>
    <footer>
        <hr>
        <a href=" ../index.php">HomePage</a>
    </footer>
</body>

</html>