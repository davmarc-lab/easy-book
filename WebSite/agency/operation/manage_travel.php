<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../../style/style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Easy Book</title>
</head>
<style>
    .transport{
        border:1px solid black;
        border-collapse: collapse;
        color: red;
        width: auto;
    }

    .tcol {
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
        function PrepareCity($string) {
            $string = strtolower($string);
            $arr = array();
            $str = explode('_', $string);
            foreach ($str as $x) {
                array_push($arr, $x);
            }
            return $arr;
        }

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

        $error = false;
        $start = $end = new DateTime();
        $travel_query = 'SELECT v.dataPartenza as depa, v.dataArrivo as retu,
                    v.prezzo as price, v.postiDisponibili as places, v.id_itinerario as schedule, v.id as id
                FROM viaggio as v 
                WHERE v.id = \''.$_POST["travel"].'\'';
        $trv = $conn -> query($travel_query) -> fetch_array();

        if (!isset($_POST["submit"]) || !isset($_POST["isDatePrepared"])) {
    ?>
    <hr>
    <h2>Modify Travel</h2>

    <form action="<?php echo($_SERVER["PHP_SELF"]); ?>" method="post" id="travel_form">
        <?php
            if (!isset($_POST["departure"]) || !isset($_POST["return"])) {
        ?>
        <table>
            <input type="hidden" name="travel" value="<?php echo($_POST["travel"]); ?>">
            <tr>
                <td>Departure date:</td>
                <td>
                    <input type="date" name="departure" placeholder="Departure date" value="<?php echo($trv["depa"]); ?>" required>
                </td>
            </tr>
            <tr>
                <td>Return date:</td>
                <td>    
                    <input type="date" name="return" placeholder="Return date" value="<?php echo($trv["retu"]); ?>" required>
                </td>
            </tr>
        </table>
        <?php
            } else {
                $start = new DateTime($_POST["departure"]);
                $end = new DateTime($_POST["return"]);

                if ($start > $end) {
                    $error = true;
                    echo("Dates are invalid.<br>");
                } else {
        ?>
        <input type="hidden" name="travel" value="<?php echo($_POST["travel"]); ?>">
        <input type="hidden" name="isDatePrepared" value="done">
        <table>
            <tr>
                <td>Price per person:</td>
                <td>
                    <input type="number" name="price" placeholder="Price per person" value="<?php echo($trv["price"]); ?>" required>
                </td>
            </tr>
            <tr>
                <td>Available places:</td>
                <td>
                    <input type="number" name="places" placeholder="Places" value="<?php echo($trv["places"]); ?>" required>
                </td>
            </tr>
        </table>

        <h2>Transport</h2>
        <h3>Select transport</h3>

        <table class="transport">
            <tr>
                <th colspan="2">id-type-year-places</th>
            </tr>
            <?php
                $trs_query = 'SELECT * FROM mezzo as m WHERE m.id_agenzia = \''.$_SESSION["agency_id"].'\'';
                $trs = $conn -> query($trs_query);

                // all vehicles of the travel given
                $trvh_query = 'SELECT m.id, m.tipo, m.annoImmatricolazione, m.postiDisponibili
                        FROM mezzo as m, viaggio_mezzo as vm, viaggio as v
                        WHERE vm.id_mezzo = m.id
                        AND vm.id_viaggio = v.id
                        AND vm.id_viaggio = \''.$trv["id"].'\' AND
                        ((v.dataPartenza BETWEEN \''.$start -> format('Y-m-d').'\' AND \''.$end -> format('Y-m-d').'\') OR
                        (v.dataArrivo BETWEEN \''.$start -> format('Y-m-d').'\' AND \''.$end -> format('Y-m-d').'\'));';
                $trvh = $conn -> query($trvh_query);
                foreach ($trvh as $x) {
                    echo("<tr>");
                    echo("<td class=\"tcol\">");
                    echo(($x["id"].'-'.$x["tipo"].'-'.$x["annoImmatricolazione"].'-'.$x["postiDisponibili"]));
                    echo("</td>");
                    echo("<td class=\"tcol\">");
                    echo("<input type=\"checkbox\" name=\"transport[]\" value=\"{$x["id"]}\" checked>");
                    echo("</td>");
                    echo("</tr>");
                }

                $occupied_query = 'SELECT vm.id_mezzo
                        FROM viaggio as v, viaggio_mezzo as vm
                        WHERE v.id = vm.id_viaggio AND
                        v.id_agenzia = \''.$_SESSION["agency_id"].'\' AND
                        ((v.dataPartenza BETWEEN \''.$start -> format('Y-m-d').'\' AND \''.$end -> format('Y-m-d').'\') OR
                        (v.dataArrivo BETWEEN \''.$start -> format('Y-m-d').'\' AND \''.$end -> format('Y-m-d').'\'));';
                $occ_id = $conn -> query($occupied_query) -> fetch_all();

                foreach ($trs as $x) {
                    if (in_array(array($x["id"]), $occ_id)) {
                        continue;
                    }
                    echo("<tr>");
                    echo("<td class=\"tcol\">");
                    echo(($x["id"].'-'.$x["tipo"].'-'.$x["annoImmatricolazione"].'-'.$x["postiDisponibili"]));
                    echo("</td>");
                    echo("<td class=\"tcol\">");
                    echo("<input type=\"checkbox\" name=\"transport[]\" value=\"{$x["id"]}\">");
                    echo("</td>");
                    echo("</tr>");
                }
            ?>
        </table>
        <br>
        <h2>Schedule</h2>
        <h3>Prepare your schedule</h3>
        <?php
            $schedule_query = 'SELECT i.descrizione as descr FROM itinerario as i WHERE i.id = \''.$trv["schedule"].'\'';
            $sch = $conn -> query($schedule_query) -> fetch_array();

            $city_query = 'SELECT l.nome FROM localita as l, itinerario_localita as i WHERE i.id_localita = l.id AND i.id_itinerario = \''.$trv["schedule"].'\'';
            $city = $conn -> query($city_query);
            $cities = "";

            foreach ($city as $x) {
                $cities .= (strtolower($x["nome"]).'_');
            }
            $cities = substr_replace($cities, "", -1);

        ?>
        <table>
            <tr>
                <td>Cities:</td>
                <td><input type="text" name="city" placeholder="city1_city2_city3_city number 4" value="<?php echo($cities); ?>" required></td>
            </tr>
            <tr>
                <td>Description:</td>
                <td><textarea name="description" form="travel_form" cols="40" rows="5" placeholder="Write the description here..."><?php echo($sch["descr"]); ?></textarea></td>
            </tr>
        </table>
        <input type="hidden" name="departure" value="<?php echo($start -> format('Y-m-d')); ?>">
        <input type="hidden" name="return" value="<?php echo($end -> format('Y-m-d')); ?>">
        <?php } }
            if (!$error) {
        ?> 
        <button name="submit">Send</button>
        <input type="reset" value="Clear">
        <?php } ?>
    </form>
    <br>
    <?php
        // for the go back link
        $agency_name = str_replace(' ', '+', $_SESSION["agency"]);
        echo("<button onclick=\"location.href='../".($error ? "operation/add_travel.php" : "info_agency.php?agency={$agency_name}")."'\">Go back</button>");
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