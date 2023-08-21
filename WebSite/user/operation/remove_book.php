<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="../../style/style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Easy Book</title>
</head>
<style>
    .tab {
        border: 1px solid black;
        border-collapse: collapse;
        padding-left: 4px;
        padding-right: 4px;
        color: red;
        width: auto;
    }

    .ele {
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
    include_once("../../database/dbConnection.php");
    PrintLoginInfo();
    if (!isset($_SESSION["id"])) {
        header("location:../login.php");
    }
    $conn = OpenCon();
    ?>
    <hr>
    <h2>Delete Reservation</h2>
    <?php
    if (!isset($_POST["submit"])) {
        echo ("<h3>Are you sure you want to delete this travel?</h3>");

        $travel_query = "SELECT * FROM viaggio as v WHERE v.id = '{$_GET["travel"]}'";
        $trv = $conn->query($travel_query)->fetch_array();

        $dest_query = 'SELECT l.nome
                FROM localita as l, itinerario_localita as il 
                WHERE l.id = il.id_localita
                AND il.id_itinerario = 
                    (SELECT v.id_itinerario
                    FROM viaggio as v
                    WHERE v.id = \'' . $_GET["travel"] . '\');';
        $dest = $conn->query($dest_query);
        $cities = "";
        foreach ($dest as $c) {
            $cities .= ($c["nome"] . '-');
        }
        $cities = substr_replace($cities, "", -1);

        $reservation_query = "SELECT SUM(vu.numeroPrenotazioni) as reservations
                FROM viaggio_utente as vu
                WHERE vu.id_viaggio = '{$_GET["travel"]}';";
        $rsv = $conn->query($reservation_query)->fetch_array()["reservations"];

        $schedule_query = "SELECT i.descrizione FROM itinerario as i 
                WHERE i.id = (SELECT v.id_itinerario FROM viaggio as v WHERE v.id = '{$_GET["travel"]}')";
        $description = $conn->query($schedule_query)->fetch_array()["descrizione"];
    ?>
        <table style="text-align: center; max-width: 70%" class="tab">
            <tr>
                <th class="tab">Destination</th>
                <th class="tab">Departure Date</th>
                <th class="tab">Return Date</th>
                <th class="tab">Reservation</th>
                <th class="tab">Price</th>
                <th class="tab">Description</th>
            </tr>

            <tr>
                <td class="ele"><?php echo ($cities); ?></td>
                <td class="ele"><?php echo ($trv["dataPartenza"]); ?></td>
                <td class="ele"><?php echo ($trv["dataArrivo"]); ?></td>
                <td class="ele"><?php echo (empty($rsv) ? "0" : "$rsv"); ?></td>
                <td class="ele"><?php echo ($trv["prezzo"]); ?></td>
                <td class="ele"><?php echo ($description); ?></td>
            </tr>
        </table>
        <br>

        <table>
            <tr>
                <td>
                    <form action="<?php echo ($_SERVER["PHP_SELF"]) ?>" method="post">
                        <input type="submit" name="submit" value="Remove" style="color: red">
                        <input type="hidden" name="travel" value="<?php echo ($_GET["travel"]); ?>">
                    </form>
                </td>
                <td>
                    <?php
                    echo ("<button onclick=\"location.href='../info_user.php' \">Go back</button>");
                    ?>
                </td>
            </tr>
        </table>
    <?php
    } else {
        $removeschedule_query = "DELETE FROM itinerario as i
                WHERE i.id = (
                    SELECT v.id_itinerario 
                    FROM viaggio as v 
                    WHERE v.id = '{$_POST["travel"]}'
                    );";
        $res = $conn->query($removeschedule_query);
        $removetravel_query = "DELETE FROM viaggio as v WHERE v.id = '{$_POST["travel"]}';";
        $res = $conn->query($removetravel_query);
        header("location:../info_user.php");
    }
    ?>
    <footer>
        <hr>
        <a href=" ../../index.php">HomePage</a>
    </footer>
</body>

</html>