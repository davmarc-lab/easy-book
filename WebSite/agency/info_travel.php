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
    // needed to print different operation for each user, checked by query
    $o_flag = $e_flag = $u_flag = false;

    session_start();
    include_once("../database/dbConnection.php");
    PrintLoginInfo();
    $conn = OpenCon();
    $travel_id = $_GET["travel"];

    $agency_query = 'SELECT a.nome as nome 
            FROM viaggio as v, agenzia as a
            WHERE a.id = v.id_agenzia
            AND v.id = \'' . $travel_id . '\'';
    $agency = $conn->query($agency_query)->fetch_array();
    $_SESSION["agency"] = $agency["nome"];

    $dest_query = 'SELECT l.nome
                FROM localita as l, itinerario_localita as il 
                WHERE l.id = il.id_localita
                AND il.id_itinerario = 
                    (SELECT v.id_itinerario
                    FROM viaggio as v
                    WHERE v.id = \'' . $travel_id . '\');';
    $dest = $conn->query($dest_query);
    $cities = "";
    foreach ($dest as $c) {
        $cities .= ($c["nome"] . '-');
    }
    $cities = substr_replace($cities, "", -1);
    ?>
    <hr>
    <h2><?php echo ($cities); ?></h2>

    <?php
    $travel_query = 'SELECT v.dataPartenza as depart, v.dataArrivo as retu, i.descrizione as descr, v.prezzo as price
                FROM viaggio as v, itinerario as i
                WHERE v.id = \'' . $travel_id . '\'
                AND i.id = v.id_itinerario;';
    $trv = $conn->query($travel_query)->fetch_array();
    echo ("<h3>Description</h3>");
    if (strlen($trv["descr"]) > 0) {
        $str = $trv["descr"];
    } else {
        $str = "Description not available.";
    }
    echo ("<p>{$str}</p>");
    ?>

    <div style="display: flex">
        <section style="flex-basis: 10%; text-align: center">
            <h3>Departure Date</h3>
            <p><?php echo ($trv["depart"]); ?></p>
        </section>
        <section style="flex-basis: 10%; text-align: center">
            <h3>Return Date</h3>
            <p><?php echo ($trv["retu"]); ?></p>
        </section>
    </div>

    <div style="display: flex">
        <section style="text-align: center">
            <h3>Vehicles</h3>
            <?php
            $vehi_query = 'SELECT m.tipo, m.id, m.postiDisponibili
                        FROM mezzo as m, viaggio_mezzo as vm 
                        WHERE m.id = vm.id_mezzo
                        AND vm.id_viaggio = \'' . $travel_id . '\';';
            $vehi = $conn->query($vehi_query);
            ?>
            <table style="text-align: center">
                <tr>
                    <th>Type</th>
                    <th>Places</th>
                </tr>
                <?php
                foreach ($vehi as $x) {
                    echo ("<tr>");
                    echo ("<td>{$x["tipo"]}</td>");
                    echo ("<td>{$x["postiDisponibili"]}</td>");
                    echo ("</tr>");
                }
                ?>
            </table>
        </section>

        <section style="flex-basis: 12%; text-align: center">
            <h3>Price per person</h3>
            <p><?php echo ($trv["price"]); ?> €</p>
        </section>
    </div>
    <br>
    <?php
    if (!$u_flag) {
    ?>
        <div style="display: flex">
            <form action="operation/manage_travel.php" method="post" style="flex-basis: 70px">
                <input type="hidden" name="travel" value="<?php echo ($travel_id); ?>">
                <button>Manage</button>
            </form>
            <form action="../user/operation/book_travel.php" method="get">
                <input type="hidden" name="travel" value="<?php echo ($travel_id); ?>">
                <button>Book</button>
            </form>
        </div>
    <?php
    } else {
    ?>
        <form action="../user/operation/book_travel.php" method="get">
            <input type="hidden" name="travel" value="<?php echo ($travel_id); ?>">
            <button>Book</button>
        </form>
    <?php
    }
    $agency_name = str_replace(' ', '+', $_SESSION["agency"]);
    echo ("<br><button onclick=\"location.href='info_agency.php?agency={$agency_name}'\">Go back</button>");
    ?>
    <footer>
        <hr>
        <a href="../index.php">HomePage</a>
    </footer>
</body>

</html>