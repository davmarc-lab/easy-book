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
    /// needed to print different operation for each user, checked by query
    $o_flag = $e_flag = $u_flag = $a_flag = false;

    session_start();
    include_once("../database/dbConnection.php");
    PrintLoginInfo();
    $conn = OpenCon();
    $_SESSION["agency"] = $_GET["agency"];

    $agency_query = 'SELECT * FROM agenzia AS a WHERE a.nome = \'' . $_GET["agency"] . '\' ;';
    $res = $conn->query($agency_query)->fetch_array();
    $agency = $res["nome"];
    $ow_id = $res["id_utente"];
    $id_agency = $res["id"];
    $_SESSION["agency_id"] = $id_agency;
    echo ("<hr><h2>{$agency}</h2>");

    if (isset($_SESSION["id"])) {
        $us_query = 'SELECT * FROM utente AS u WHERE u.id = \'' . $_SESSION["id"] . '\';';
        $us = $conn->query($us_query)->fetch_array();
        $us_id = $us["id"];

        $em_query = 'SELECT * FROM agenzia_utente as a
                WHERE a.id_agenzia = \'' . $id_agency . '\'
                AND a.id_utente = \'' . $_SESSION["id"] . '\'
                AND (a.scadenza > CURDATE() OR a.scadenza IS NULL)';
        $em = $conn->query($em_query);

        $admin_query = 'SELECT u.id AS id FROM amministratore AS a, utente AS u WHERE u.id = a.id_utente AND a.dataRitiro IS NULL;';
        $admin_id = $conn->query($admin_query)->fetch_array()["id"];
        $a_flag = $admin_id == $_SESSION["id"];

        // if owner do operation
        if ($ow_id == $us_id || $a_flag) {
            $o_flag = true;
    ?>
            <h3>Employees</h3>
            <table style="max-width: 70%">
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Contract</th>
                    <th>Expire date</th>
                    <th>Operations</th>
                </tr>
                <?php
                $query = 'SELECT a.id as emid, u.nome AS nome, u.email AS email, a.scadenza as scad,
                        a.tipoContratto AS contratto FROM utente AS u, agenzia_utente AS a
                                    WHERE a.id_agenzia = \'' . $id_agency . '\' AND u.id IN
                                        (SELECT id_utente FROM agenzia_utente WHERE agenzia_utente.id_agenzia = \'' . $id_agency . '\')
                                    AND u.id = a.id_utente';
                $res = $conn->query($query);
                foreach ($res as $r) {
                    echo ("<tr>");
                    echo ("<td>" . $r["nome"] . "</td>");
                    echo ("<td>" . $r["email"] . "</td>");
                    echo ("<td style = \"text-align: center\">" . $r["contratto"] . "</td>");
                    echo ("<td style = \"text-align: center\">" . $r["scad"] . "</td>");
                    echo ("<td style=\"text-align: center\">
                                    <form action=\"operation/remove_employee.php\" method=\"post\"><button type=\"submit\" name=\"email\"value=\"" . $r["email"] . "\">Remove</button></form>
                                    <form action=\"operation/manage_employee.php\" method=\"post\"><button type=\"submit\" name=\"emid\"value=\"" . $r["emid"] . "\">Modify</button></form>
                                    </td>");
                    echo ("</tr>");
                }
                ?>
            </table>
            <br>
            <form action="operation/add_employee.php" method="get">
                <button type="submit" name="agency" value="<?php echo ($agency) ?>">Add</button>
            </form>
            <hr>
    <?php
        } else if ($em->num_rows > 0) { // not the owner
            $e_flag = true;
        }
    } else {
        $u_flag = true;
    }

    ?>

    <h2>All travels</h2>
    <table style="max-width: 70%">
        <tr>
            <th>Destination</th>
            <th>Remaining Places</th>
            <th>Departure Date</th>
            <th>Return Date</th>
            <th>Price per person</th>
            <th>Link</th>
        </tr>
        <?php
        $travel_query = 'SELECT * FROM viaggio AS v WHERE v.id_agenzia = \'' . $_SESSION["agency_id"] . '\'';
        $tv = $conn->query($travel_query);
        foreach ($tv as $x) {

            $dest_query = 'SELECT l.nome FROM localita as l, itinerario_localita as il 
                        WHERE l.id = il.id_localita
                        AND il.id_itinerario = \'' . $x["id_itinerario"] . '\'';
            $dest = $conn->query($dest_query);
            $cities = "";
            foreach ($dest as $c) {
                $cities .= ($c["nome"] . '-');
            }
            $cities = substr_replace($cities, "", -1);
            $isBookable = $x["dataPartenza"] > date('Y-m-d') ? true : false;

            echo ("<tr>");
            echo ("<td>{$cities}</td>");
            echo ("<td style = \"text-align: center\">" . $x["postiDisponibili"] . "</td>");
            echo ("<td style = \"text-align: center\">" . $x["dataPartenza"] . "</td>");
            echo ("<td style = \"text-align: center\">" . $x["dataArrivo"] . "</td>");
            echo ("<td style=\"text-align: center\">" . $x["prezzo"] . "</td>");
            echo ("<td style=\"text-align: center\">");
        ?>
            <form action="info_travel.php" method="get">
                <button name="travel" value="<?php echo ($x["id"]); ?>">Info</button>
            </form>
        <?php
            if (isset($_SESSION["id"]) && $isBookable && $x["postiDisponibili"] > 1) {
                $sel_query = "SELECT * FROM viaggio_utente as vu
                            WHERE vu.id_utente = '{$_SESSION["id"]}'
                            AND vu.id_viaggio = '{$x["id"]}'";
                $sel = $conn->query($sel_query);
                if ($sel->num_rows <= 0) {
                    echo ("<form action=\"../user/operation/book_travel.php?travel={$x["id"]}\" method=\"get\">
                            <button name=\"travel\" value=\"{$x["id"]}\">Book</button>
                        </form>");
                }
            }
            echo ("</td>");
            echo ("</tr>");
        }
        ?>
    </table>
    <br>
    <?php
    if ($e_flag || $o_flag) {
    ?>
        <button onclick="location.href='operation/add_travel.php'">Add</button>
        <hr>
        <h2>Transport</h2>
        <table style="max-width: 70%">
            <tr>
                <th>Type</th>
                <th>Available Places</th>
                <th>Year</th>
                <th>Status</th>
                <th style="text-align: center">Link</th>
            </tr>
            <?php
            $vehi_query = 'SELECT * FROM mezzo as m WHERE m.id_agenzia = \'' . $_SESSION["agency_id"] . '\'';
            $tv = $conn->query($vehi_query);
            $free_query = 'SELECT vm.id_mezzo FROM viaggio_mezzo as vm, viaggio as v
                    WHERE v.id = vm.id_viaggio
                    AND (CURDATE() BETWEEN v.dataPartenza AND v.dataArrivo)';
            $free = $conn->query($free_query)->fetch_all();

            foreach ($tv as $x) {
                $disable_query = "SELECT mm.id FROM mezzo_manutenzione as mm, manutenzione as m
                        WHERE mm.id_manutenzione = m.id
                        AND mm.id_mezzo = '{$x["id"]}'
                        AND ((CURDATE() >= m.dataInizio AND CURDATE() < m.dataFine)
                            OR (m.dataFine IS NULL AND CURDATE() > m.dataInizio))";
                $disable = $conn->query($disable_query);
                $isOccupied = in_array(array($x["id"]), $free);

                if ($disable->num_rows > 0) {
                    $str = "maintenance";
                } else {
                    $str = $isOccupied ? "occupied" : "free";
                }
                $dis = $isOccupied ? "disabled" : "";
                echo ("<tr>");
                echo ("<td style = \"text-align: center\">" . $x["tipo"] . "</td>");
                echo ("<td style = \"text-align: center\">" . $x["postiDisponibili"] . "</td>");
                echo ("<td style = \"text-align: center\">" . $x["annoImmatricolazione"] . "</td>");
                echo ("<td style=\"text-align: center\">" . $str . "</td>");
                echo ("<td style=\"text-align: center\">
                    <form action=\"info_vehicle.php\" method=\"get\">
                        <button name=\"vehicle\" value=\"{$x["id"]}\">Info</button>
                    </form>
                    <form action=\"operation/remove_transport.php\" method=\"get\">
                        <button name=\"vehicle\" value=\"{$x["id"]}\" {$dis}>Remove</button>
                    </form>
                </td>");
            }
            ?>
        </table>
        <br>
        <button onclick="location.href='operation/add_transport.php'">Add</button>
        <hr>
        <h2>All Coupon</h2>
        <table style="max-width: 70%;">
            <tr>
                <th>Description</th>
                <th>Discount code</th>
            </tr>
            <?php
            $coupon_query = "SELECT * FROM coupon as c WHERE c.id_agenzia = '{$_SESSION["agency_id"]}'";
            $cpn = $conn->query($coupon_query);

            foreach ($cpn as $x) {
                echo ("<tr>");
                echo ("<td>{$x["descrizione"]}</td>");
                echo ("<td>{$x["codiceSconto"]}</td>");
                echo ("</tr>");
            }

            ?>
        </table>
        <br>
        <button onclick="location.href='operation/add_coupon.php'">Add</button>
    <?php } ?>

    <footer>
        <hr>
        <a href="../index.php">HomePage</a>
    </footer>
</body>

</html>