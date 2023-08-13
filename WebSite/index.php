<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="style/style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Easy Book</title>
</head>
<style>
    table,
    th {
        border: 1px solid black;
        border-collapse: collapse;
        color: red;
    }

    td {
        border: 1px solid black;
        border-collapse: collapse;
        color: black;
        text-indent: 4px;
    }
</style>

<body>
    <h1>Easy Book</h1>
    <h3>Check our list of destination for your vacation and book it.</h3>
    <p>It is fast and simple: choose, pay and have fun.</p>
    <p>The rules are simple, if you want to book a vacation you have to sign up or do login, you have to be signed on the platform. <br>
        &emsp;After you can do whatever tou want and book how many vacation you can afford.
    </p>
    <?php
    session_start();
    include_once("database/dbConnection.php");
    $conn = OpenCon();
    if (!isset($_SESSION["id"])) {
        echo ("If you already have an account press the Login button, instead you can press the Sign Up button to create an account.");
    }
    PrintLoginInfo();
    ?>
    <hr>
    <h2>All agencies</h2>
    <agency style="overflow-y: auto;">
        <table style="width: 70%; height: 7px">
            <tr>
                <th style="width: 40%">Name</th>
                <th>Owner</th>
                <th>Contact</th>
                <th style="width: 15%">Number of Travels</th>
                <th>Link</th>
            </tr>
            <?php
            // restituisce le informazioni principali per ogni agenzia iscritta alla piattaforma
            $query = 'SELECT *, (SELECT COUNT(v.id) FROM viaggio as v WHERE v.id_agenzia = a.id) AS nt FROM agenzia AS a';
            $res = $conn->query($query);
            foreach ($res as $r) {
                echo ("<tr>");
                echo ("<td>" . $r["nome"] . "</td>");
                echo ("<td>" . $r["proprietario"] . "</td>");
                echo ("<td>" . $r["telefono"] . "</td>");
                echo ("<td style = \"text-align: center\">" . $r["nt"] . "</td>");
            ?>
                <td style="text-align: center">
                    <form action="agency/info_agency.php" method="get">
                        <button style="cursor: pointer;" type="submit" name="agency" value="<?php echo ($r["nome"]); ?>">Go</button>
                    </form>
                </td>
            <?php
                echo ("</tr>");
            }
            ?>

        </table>
    </agency>

    <hr>

    <h2>All travels</h2>
    <travel>
        <table style="width: 70%; text-align: center">
            <tr>
                <th>Agency Name</th>
                <th>Destination</th>
                <th>Available Places</th>
                <th>Departure Date</th>
                <th>Return Date</th>
                <th style="width: 10%">Price per person</th>
                <th>Link</th>
            </tr>
            <?php
            $travel_query = 'SELECT a.id as agency, a.nome AS nome, v.postiDisponibili AS places, v.dataPartenza AS depart,
                            v.dataArrivo AS retur, v.prezzo AS price, v.id_itinerario AS id_itinerario, v.id as id
                        FROM viaggio AS v, agenzia AS a WHERE a.id = v.id_agenzia';
            $travel = $conn->query($travel_query);

            foreach ($travel as $x) {
                echo ("<tr>");

                $dest_query = 'SELECT l.nome FROM localita as l, itinerario_localita as il 
                        WHERE l.id = il.id_localita
                        AND il.id_itinerario = \'' . $x["id_itinerario"] . '\'';
                $dest = $conn->query($dest_query);
                $cities = "";
                foreach ($dest as $c) {
                    $cities .= ($c["nome"] . '-');
                }
                $cities = substr_replace($cities, "", -1);

                echo ("<td>{$x["nome"]}</td>");
                echo ("<td>{$cities}</td>");
                echo ("<td>{$x["places"]}</td>");
                echo ("<td>{$x["depart"]}</td>");
                echo ("<td>{$x["retur"]}</td>");
                echo ("<td>{$x["price"]}</td>");
                echo ("<td style=\"text-align: center\">
                    <form action=\"agency/info_travel.php?travel={$x["id"]}\" method=\"get\">
                        <button name=\"travel\" value=\"{$x["id"]}\">Info</button>
                    </form>");
                if (isset($_SESSION["id"])) {
                    echo ("<form action=\"user/operation/book_travel.php?travel={$x["id"]}\" method=\"get\">
                        <button name=\"travel\" value=\"{$x["id"]}\">Book</button>
                        <input type=\"hidden\" name=\"agency\" value=\"{$x["nome"]}\">
                    </form>");
                }
                echo ("</td>");
                echo ("</tr>");
            }
            ?>
        </table>
    </travel>
</body>
<footer>
    <hr>
    <?php
    if (isset($_SESSION["id"])) {
        echo ("<h2>Are you an agency? <a href=\"agency/register_agency.php\">Click here</a> to create an agency and start organize vacations.</h2>");
    }
    ?>
</footer>

</html>