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
    session_start();
    include_once("../database/dbConnection.php");
    PrintLoginInfo();
    $conn = OpenCon();

    if (!isset($_SESSION["id"])) {
        header("location:../user/login.php");
    }
    ?>
    <hr>
    <table id="top">
        <tr>
            <td><a href="#agency">Agencies</a></td>
            <td><a href="#travel">Travels</a></td>
            <td><a href="#user">Users</a></td>
            <td><a href="#bot">Bottom</a></td>
        </tr>
    </table>
    <hr>
    <h2 id="agency">All Agencies</h2>
    <table style="max-width: 70%; min-width: 50%">
        <tr>
            <th>Name</th>
            <th>Owner</th>
            <th>Contact</th>
            <th>Number of Travels</th>
            <th>Link</th>
        </tr>
        <?php
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
                <form action="../agency/info_agency.php" method="get">
                    <button type="submit" name="agency" value="<?php echo ($r["nome"]); ?>">Go</button>
                </form>
            </td>
        <?php
            echo ("</tr>");
        }
        ?>

    </table>
    <hr>

    <h2 id="travel">All Travels</h2>
    <table style="max-width: 70%">
        <tr>
            <th>Agency</th>
            <th>Destination</th>
            <th>Remaining Places</th>
            <th>Departure Date</th>
            <th>Return Date</th>
            <th>Price per person</th>
            <th>Status</th>
            <th>Operation</th>
        </tr>
        <?php
        $travel_query = 'SELECT * FROM viaggio AS v';
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

            $agency_query = "SELECT * FROM agenzia as a WHERE a.id = '{$x["id_agenzia"]}'";
            $agency = $conn->query($agency_query)->fetch_array();

            $status = "";
            if (date('Y-m-d') < $x["dataPartenza"]) {
                $status = "Bookable";
            } else if (date('Y-m-d') > $x["dataArrivo"]) {
                $status = "Finished";
            } else {
                $status = "Ongoing";
            }

            echo ("<tr>");
            echo ("<td style = \"text-align: center\">{$agency["nome"]}</td>");
            echo ("<td>{$cities}</td>");
            echo ("<td style = \"text-align: center\">" . $x["postiDisponibili"] . "</td>");
            echo ("<td style = \"text-align: center\">" . $x["dataPartenza"] . "</td>");
            echo ("<td style = \"text-align: center\">" . $x["dataArrivo"] . "</td>");
            echo ("<td style = \"text-align: center\">" . $x["prezzo"] . "</td>");
            echo ("<td style = \"text-align: center\">{$status}</td>");
            echo ("<td style=\"text-align: center\">");
        ?>
            <form action="../agency/info_travel.php" method="get">
                <button name="travel" value="<?php echo ($x["id"]); ?>">Info</button>
            </form>

            <form action="../agency/operation/remove_travel.php" method="get">
                <button name="travel" value="<?php echo ($x["id"]); ?>">Remove</button>
            </form>
        <?php
            echo ("</td>");
            echo ("</tr>");
        }
        ?>
    </table>
    <hr>

    <h2 id="user">All Users</h2>
    <table>
        <table style="max-width: 70%; min-width: 50%">
            <tr>
                <th>Name</th>
                <th>Surname</th>
                <th>Telephone</th>
                <th>Email</th>
                <th>Travels Booked</th>
                <th>Operation</th>
            </tr>
            <?php
            $user_query = "SELECT *, (SELECT COUNT(v.id) FROM viaggio_utente as v WHERE v.id_utente = u.id) as travels FROM utente as u";
            $user = $conn->query($user_query);
            foreach ($user as $x) {
                echo ("<tr>");
                echo ("<td>" . $x["nome"] . "</td>");
                echo ("<td>" . $x["cognome"] . "</td>");
                echo ("<td>" . $x["telefono"] . "</td>");
                echo ("<td>" . $x["email"] . "</td>");
                echo ("<td style = \"text-align: center\">" . $x["travels"] . "</td>");
            ?>
                <td style="text-align: center">
                    <form action="../user/info_user.php" method="post">
                        <button type="submit" name="user" value="<?php echo ($x["id"]); ?>">Info</button>
                    </form>
                    <form action="../admin/operation/remove_user.php" method="post">
                        <button type="submit" name="user" value="<?php echo ($x["id"]); ?>">Remove</button>
                    </form>
                </td>
            <?php
                echo ("</tr>");
            }
            ?>

        </table>
    </table>
    <hr>
    <table id="bot">
        <tr>
            <td><a href="#top">Top</a></td>
        </tr>
    </table>
    <hr>
    <footer>
        <a href=" ../index.php">HomePage</a>
    </footer>
</body>

</html>