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
        $o_flag = $e_flag = $u_flag = false;

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
            header("location:../user/login.php");
        }
        include_once("../database/dbConnection.php");
        $conn = OpenCon();
        $travel_id = $_GET["travel"];
        $dest_query = 'SELECT l.nome
                FROM localita as l, itinerario_localita as il 
                WHERE l.id = il.id_localita
                AND il.id_itinerario = 
                    (SELECT v.id_itinerario
                    FROM viaggio as v
                    WHERE v.id = \''.$travel_id.'\');';
        $dest = $conn -> query($dest_query);
        $cities = "";
        foreach ($dest as $c) {
            $cities .= ($c["nome"].'-');
        }
        $cities = substr_replace($cities, "", -1);

        if (isset($_SESSION["id"])) {
    ?>
    <hr>
    <h2><?php echo($cities); ?></h2>
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
    <?php } ?>

    <footer>
        <hr>
        <a href="../index.php">HomePage</a>
    </footer>
</body>
</html>