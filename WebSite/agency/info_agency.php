<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../style/style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Easy Book</title>
</head>
<style>
    table, th {
        border:1px solid black;
        border-collapse: collapse;
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
        $o_flag = $e_flag = $u_flag = false;

        function contains($str, array $arr)
        {
            foreach($arr as $a) {
                if (stripos($str,$a) !== false) return true;
            }
            return false;
        }

        session_start();
        if (isset($_SESSION["id"])) {
            ?>
                <div class="login">
                    <?php
                        echo ("Hello ".$_SESSION["name"]." | <a href=\"./homepage_agency.php\">Agencies</a> | <a href=\"../user/logout.php\">Logout</a>");
                    ?>
                </div>
            <?php
        } else {
            ?>
            <div class="login">
                <a href="../user/login.php">Login</a> |
                <a href="../user/register.php">Sign Up</a>
            </div>
            <?php
        }
        include_once("../database/dbConnection.php");
        $conn = OpenCon();
        $_SESSION["agency"] = $_GET["agency"];

        $agency_query = 'SELECT * FROM agenzia AS a WHERE a.nome = \''.$_GET["agency"].'\' ;';
        $res = $conn -> query($agency_query);
        $res = $res -> fetch_array();
        $agency = $res["nome"];
        $ow_email = $res["email"];
        $id_agency = $res["id"];
        $_SESSION["agency_id"] = $id_agency;
        echo("<hr><h2>{$agency}</h2>");

        $us_query = 'SELECT * FROM utente AS u WHERE u.id = \''.$_SESSION["id"].'\';';
        $us = $conn -> query($us_query) -> fetch_array();
        $us_email = $us["email"];

        $em_query = 'SELECT * FROM agenzia_utente as a WHERE a.id_agenzia = \''.$id_agency.'\' AND a.id_utente = \''.$_SESSION["id"].'\'';
        $em = $conn -> query($em_query);

        // if owner do operation
        if ($ow_email == $us_email) {
            $o_flag = true;
            ?>
            <h3>Employees</h3>
            <table style="max-width: 70%">
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Contract</th>
                    <th>Operations</th>
                </tr>
                    <?php
                        $query = 'SELECT u.nome AS nome, u.email AS email, a.tipoContratto AS contratto FROM utente AS u, agenzia_utente AS a
                                WHERE a.id_agenzia = \''.$id_agency.'\' AND u.id IN
                                        (SELECT id_utente FROM agenzia_utente WHERE agenzia_utente.id_agenzia = \''.$id_agency.'\')
                                AND u.id = a.id_utente';
                        $res = $conn -> query($query);
                        foreach ($res as $r) {
                            echo("<tr>");
                            echo("<td>".$r["nome"]."</td>");
                            echo("<td>".$r["email"]."</td>");
                            echo("<td style = \"text-align: center\">".$r["contratto"]."</td>");
                            echo("<td style=\"text-align: center\"><form action=\"operation/remove_employee.php\" method=\"post\"><button type=\"submit\" name=\"email\"value=\"".$r["email"]."\">Remove</button></form>
                                <input type=\"button\" onclick=\"location.href='agency/operations/remove_employee.php'\" value=\"Modify\"></td>");
                            echo("</tr>");
                        }
                    ?>
            </table>
            <br>
            <form action="operation/add_employee.php" method="get">
            <button type="submit" name="agency" value="<?php echo($agency) ?>">Add</button>
            </form>
            <hr>
            <?php
        } else if ($em -> num_rows > 0) { // not the owner
            $e_flag = true;
        } else {
            $u_flag = true;
        }
    ?>
    
    <h2>Transport</h2>
    <table style = "max-width: 70%">
        <tr>
            <th>Type</th>
            <th>Available Places</th>
            <th>Year</th>
            <th>Status</th>
            <th style="text-align: center">Link</th>
        </tr>
        <?php
            $travel_query = 'SELECT * FROM mezzo as m WHERE m.id_agenzia = \''.$_SESSION["agency_id"].'\'';
            $tv = $conn -> query($travel_query);
            foreach ($tv as $x) {
                echo("<tr>");
                echo("<td style = \"text-align: center\">".$x["tipo"]."</td>");
                echo("<td style = \"text-align: center\">".$x["postiDisponibili"]."</td>");
                echo("<td style = \"text-align: center\">".$x["annoImmatricolazione"]."</td>");
                echo("<td style=\"text-align: center\"> NaN</td>");
                echo("<td></td>");
            }
        ?>
    </table>
    <br>
    <button onclick="location.href='operation/add_transport.php'">Add</button>

    <h2>All travels</h2>
    <table style = "width: 70%">
        <tr>
            <th>Destination</th>
            <th>Available Places</th>
            <th>Departure Date</th>
            <th>Return Date</th>
            <th style = "width: 10%; text-align: center">Price per person</th>
            <th style="text-align: center">Link</th>
        </tr>
        <?php
            $travel_query = 'SELECT * FROM viaggio AS v WHERE v.id_agenzia = \''.$_SESSION["agency"].'\' ';
            $tv = $conn -> query($travel_query);
            foreach ($tv as $x) {
                echo("<tr>");
                echo("<td>".$x["dest"]."</td>");
                echo("<td style = \"text-align: center\">".$x["postiDisponibili"]."</td>");
                echo("<td style = \"text-align: center\">".$x["dataPartenza"]."</td>");
                echo("<td style = \"text-align: center\">".$x["dataArrivo"]."</td>");
                echo("<td style=\"text-align: center\">".$x["prezzo"]."</td>");
                if ($e_flag || $o_flag) {
                    echo("<td style=\"text-align: center\">");
                    ?>
                    <form action="info_agency.php" method="get">
                        <button style="cursor: pointer;" name="travel" value="<?php echo($r["id"]); ?>">Manage</button>
                        <button onclick="location.href='/user/operation/travel_book.php'" style="cursor: pointer;" name="travel" value="<?php echo($r["id"]); ?>">Book</button>
                    </form>
                    <?php echo("</td>");
                }
                // aggiungi il tasto per prenotare se l'utente ha fatto il logiin
                echo("</tr>");
            }
        ?>
    </table>
    <br>
    <button onclick="location.href='operation/add_travel.php'">Add</button>

</body>
<footer>
    <hr>
    <a href="../index.php">HomePage</a>
</footer>
</html>