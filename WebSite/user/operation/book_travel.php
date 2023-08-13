<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="../../style/style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Easy Book</title>
</head>

<body>
    <h1>Easy Book</h1>
    <?php
    session_start();
    include_once("../../database/dbConnection.php");
    if (isset($_SESSION["id"])) {
        PrintLoginInfo();
    } else {
        header("location:../login.php");
    }

    if (isset($_GET["agency"])) {
        $_SESSION["agency"] = $_GET["agency"];
    }

    $conn = OpenCon();
    if (!isset($_POST["submit"])) {
        $travel_id = $_GET["travel"];
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
        $places_query = 'SELECT v.postiDisponibili as places
                FROM viaggio as v 
                WHERE v.id = \'' . $travel_id . '\'';
        $places = $conn->query($places_query)->fetch_array();
        ?>
        <form action="<?php echo ($_SERVER["PHP_SELF"]); ?>" method="post">
            <table>
                <tr>
                    <td>
                        <section style="text-align: center">
                            <b>Number of person:</b>
                            <p>(min 1, max 4)</p>
                        </section>
                    </td>
                    <td>
                        <section style="text-align: center">
                            <input type="number" name="reservation" min="1" max="4" value="1" required>
                            <p>remaining places: <?php echo ($places["places"]); ?></p>
                        </section>
                    </td>
                </tr>
            </table>
            <br>
            <input type="submit" name="submit" value="Book">
            <input type="hidden" name="travel" value="<?php echo ($travel_id); ?>">
        </form>
    <?php
        $agency_name = str_replace(' ', '+', $_SESSION["agency"]);
        echo ("<br><button onclick=\"location.href='../../agency/info_agency.php?agency={$agency_name}'\">Go back</button>");
    } else {
        echo ("<hr>");
        $error = false;
        $travel_id = $_POST["travel"];

        $places_query = 'SELECT v.postiDisponibili as places
                FROM viaggio as v 
                WHERE v.id = \'' . $travel_id . '\'';
        $places = $conn->query($places_query)->fetch_array()["places"];

        if ($places < $_POST["reservation"]) {
            echo ("Cannot book for {$_POST["reservation"]} people; choose another travel.<br>");
            $error = true;
        }

        if ($error) {
            echo ("<br><button onclick=\"location.href='../../agency/info_travel.php?travel={$travel_id}'\">Go back</button>");
        } else {
            $insert_query = 'INSERT INTO viaggio_utente (numeroPrenotazioni, id_utente, id_viaggio)
                    VALUES(\'' . $_POST["reservation"] . '\', \'' . $_SESSION["id"] . '\', \'' . $travel_id . '\')';
            $res = $conn->query($insert_query);
            $avail = $places - $_POST["reservation"];
            $update_query = 'UPDATE viaggio
                    SET
                        postiDisponibili = \'' . $avail . '\'
                    WHERE
                        id = \'' . $travel_id . '\'';
            $res = $conn->query($update_query);

            echo ("<h3>Travel book success.</h3>");
        }
    }
    ?>
    <footer>
        <hr>
        <a href="../../index.php">HomePage</a>
    </footer>
</body>

</html>