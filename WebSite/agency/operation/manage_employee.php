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
        $conn = OpenCon();
        if (isset($_SESSION["id"])) {
            ?>
                <div class="login">
                    <?php
                        echo ("Hello ".$_SESSION["name"]." | <a href=\"../homepage_agency.php\">Agencies</a> | <a href=\"../../user/logout.php\">Logout</a>");
                    ?>
                </div>
            <?php
        } else {
            header("location:../../user/login.php");
        }

        if (!isset($_POST["submit"])) {
    ?>
    <hr>
    <h2>Manage employee</h2>

    <form action="<?php echo($_SERVER["PHP_SELF"]); ?>" method="post">
        <?php
            $employee_query = 'SELECT u.email as email, au.tipoContratto as contratto, au.scadenza as scadenza
                    FROM utente as u, agenzia_utente as au
                    WHERE u.id = au.id_utente
                    AND au.id = \''.$_POST["emid"].'\'';
            $empl = $conn -> query($employee_query) -> fetch_array();
        ?>
        <input type="email" name="email" value="<?php echo($empl["email"]); ?>" placeholder="Write the email here">
        <input type="text" name="contract" value="<?php echo($empl["contratto"]); ?>">
        <input type="date" name="date" value="<?php echo($empl["scadenza"]); ?>">
    </form>
    <br>
    <?php
        // for the go back link
        $agency_name = str_replace(' ', '+', $_SESSION["agency"]);
        echo("<button onclick=\"location.href='../info_agency.php?agency={$agency_name}'\">Go back</button>");
        } else {
            // all checks and insert query
            $vehicles = "";
            $error = false;

            if (!isset($_POST["transport"])) {
                $error = true;
                echo("You have to select at least one vehicle.<br>");
            } else {
                $vehicles = $_POST["transport"];
                $max_places = 0;
                foreach ($vehicles as $x) {
                    $ask_query = 'SELECT m.postiDisponibili FROM mezzo as m WHERE m.id = \''.$x.'\'';
                    $res = $conn -> query($ask_query) -> fetch_array()["postiDisponibili"];
                    $max_places += $res;
                }
                if ($_POST["places"] > $max_places) {
                    $error = true;
                    echo("Cannot add a value bigger then the total available places of vehicles.<br>");
                }
            }

            $ct_id = array();
            if (isset($_POST["city"])) {
                $cities = PrepareCity($_POST["city"]);
                // insert only newest cities, and taking the already existing.
                foreach ($cities as $x) {
                    $city_query = 'SELECT * FROM localita AS l WHERE LOWER(l.nome) LIKE LOWER(\''.$x.'\')';
                    $ct = $conn -> query($city_query);
                    if ($ct -> num_rows > 0) {
                        $ct = $ct -> fetch_array();
                        array_push($ct_id, $ct["id"]);
                    } else {
                        $str_x = ucwords($x, '\' .');
                        $insert_query = 'INSERT INTO localita (nome) VALUES(\''.$str_x.'\')';
                        $ins = $conn -> query($insert_query);
                        $sel_query = 'SELECT * FROM localita AS l WHERE LOWER(l.nome) LIKE LOWER(\''.$str_x.'\')';
                        $sel = $conn -> query($sel_query) -> fetch_array();
                        array_push($ct_id, $sel["id"]);
                    }
                }
            }
            
            if ($error) {
                echo("<br><button onclick=\"location.href='add_travel.php'\">Go back</button>");
            } else {
                // go next, put it in
                $schedule_query = 'SELECT v.id_itinerario AS id FROM viaggio as v WHERE v.id = \''.$trv["id"].'\'';
                $sd = $conn -> query($schedule_query) -> fetch_array();
                $sd_id = $sd["id"];
                $schedule_query = 'UPDATE itinerario
                        SET descrizione = \''.$_POST["description"].'\'
                        WHERE id = \''.$sd_id.'\'';
                $sdl = $conn -> query($schedule_query);

                $seldelete_query = 'SELECT l.id FROM localita as l, itinerario_localita as il
                        WHERE l.id = il.id_localita
                        AND il.id_itinerario = \''.$sd_id.'\'';
                $sel = $conn -> query($seldelete_query);

                foreach($sel as $x) {
                    $delete_query = 'DELETE FROM itinerario_localita
                            WHERE id_localita = \''.$x["id"].'\' AND id_itinerario = \''.$sd_id.'\'';
                    $res = $conn -> query($delete_query);
                }

                foreach ($ct_id as $x) {             // remove and put them again, win win situescion
                    $insert_query = 'INSERT INTO itinerario_localita (id_localita, id_itinerario)
                            VALUES(\''.$x.'\', \''.$sd_id.'\')';
                    $res = $conn -> query($insert_query);
                }

                $travel_query = 'UPDATE viaggio
                        SET
                            postiDisponibili = \''.$_POST["places"].'\',
                            dataPartenza = \''.$_POST["departure"].'\',
                            dataArrivo = \''.$_POST["return"].'\',
                            prezzo = \''.$_POST["price"].'\'
                        WHERE
                            id = \''.$trv["id"].'\'';
                $res = $conn -> query($travel_query);

                $seldelete_query = 'SELECT m.id FROM mezzo as m, viaggio_mezzo as vm
                        WHERE m.id = vm.id_mezzo
                        AND vm.id_viaggio = \''.$trv["id"].'\'';
                $sel = $conn -> query($seldelete_query);

                foreach($sel as $x) {
                    $delete_query = 'DELETE FROM viaggio_mezzo
                            WHERE id_viaggio = \''.$trv["id"].'\' AND id_mezzo = \''.$x["id"].'\'';
                    $res = $conn -> query($delete_query);
                }

                foreach($vehicles as $x) {
                    $vehi_query = 'INSERT INTO viaggio_mezzo (id_viaggio, id_mezzo)
                            VALUES(\''.$trv["id"].'\', \''.$x.'\')';
                    $res = $conn -> query($vehi_query);
                }

                $agency_name = str_replace(' ', '+', $_SESSION["agency"]);
                header("location:../info_agency.php?agency={$agency_name}");
            }
        }
    ?>
<footer>
    <hr>
    <a href="../../index.php">HomePage</a>
</footer>
</body>
</html>