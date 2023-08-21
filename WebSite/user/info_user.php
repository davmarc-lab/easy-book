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

    .para {
        flex-basis: 5%;
        text-align: center;
        margin: 5px;
    }

    .title {
        color: red;
    }
</style>

<body>
    <h1>Easy Book</h1>
    <?php
    /// needed to print different operation for each user, checked by query
    $o_flag = $e_flag = $u_flag = false;

    session_start();
    include_once("../database/dbConnection.php");
    PrintLoginInfo();
    $conn = OpenCon();

    if (!isset($_SESSION["id"])) {
        header("location:login.php");
    }

    ?>
    <hr>
    <h2>User Area</h2>
    <h3>Personal Information</h3>
    <?php
    $user_query = "SELECT * FROM utente as u WHERE u.id = '{$_SESSION["id"]}'";
    $user = $conn->query($user_query)->fetch_array();
    ?>
    <div style="display: flex;">
        <section class="para">
            <h4 class="title">Name</h4>
            <p><?php echo ($user["nome"]); ?></p>
        </section>
        <section class="para">
            <h4 class="title">Surname</h4>
            <p><?php echo ($user["cognome"]); ?></p>
        </section>
        <section class="para">
            <h4 class="title">Telephone</h4>
            <p><?php echo (empty($user["telefono"]) ? "Not inserted" : $user["telefono"]); ?></p>
        </section>
        <section class="para">
            <h4 class="title">Email</h4>
            <p><?php echo ($user["email"]); ?></p>
        </section>
    </div>
    <button onclick="window.location.href='operation/manage_user.php';">Modify</button>
    <!-- <a href="operation/change_password.php">Change password</a> -->
    <hr>
    <h3>Travel Booked</h3>
    <?php
    $travel_query = "SELECT * FROM viaggio as v, viaggio_utente as vu
            WHERE v.id = vu.id_viaggio
            AND vu.id_utente = '{$_SESSION["id"]}'";
    $trv = $conn->query($travel_query);
    ?>
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
        $travel_query = "SELECT v.* FROM viaggio as v, viaggio_utente as vu
            WHERE v.id = vu.id_viaggio
            AND vu.id_utente = '{$_SESSION["id"]}'";
        $trv = $conn->query($travel_query);
        foreach ($trv as $x) {
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
            <form action="../agency/info_travel.php" method="get">
                <button style="cursor: pointer;" name="travel" value="<?php echo ($x["id"]); ?>">Info</button>
            </form>
        <?php
            $da = new DateTime($x["dataPartenza"]);
            $int = new DateInterval('P30D');
            $max = $da->sub($int)->format('Y-m-d'); // gap date to modify travel information
            // if ($max > date('Y-m-d')) {
            echo ("
                <form action=\"operation/remove_book.php\" method=\"get\">
                    <button style=\"cursor: pointer;\" name=\"travel\" value=\"{$x["id"]}\">Remove</button>
                </form>
            ");
            // }
            echo ("</td>");
            echo ("</tr>");
        }
        ?>
    </table>

    <footer>
        <hr>
        <a href="../index.php">HomePage</a>
    </footer>
</body>

</html>