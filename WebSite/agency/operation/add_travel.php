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
        }

        if (!isset($_POST["submit"])) {
    ?>
    <hr>
    <h2>New Travel</h2>
    <h3>Organize the travel</h3>

    <form action="<?php echo($_SERVER["PHP_SELF"]); ?>" method="post" id="travel_form">
        <table>
            <tr>
                <td>Departure date:</td>
                <td>
                    <input type="date" name="departure" placeholder="Departure date">
                </td>
            </tr>
            <tr>
                <td>Return date:</td>
                <td>    
                    <input type="date" name="return" placeholder="Return date">
                </td>
            </tr>
            <tr>
                <td>Price per person:</td>
                <td>
                    <input type="number" name="price" placeholder="Price per person">
                </td>
            </tr>
            <tr>
                <td>Available places:</td>
                <td>
                    <input type="number" name="places" placeholder="Places">
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
                
                foreach ($trs as $x) {
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
        <table>
            <tr>
                <td>Cities:</td>
                <td><input type="text" name="city" placeholder="city1_city2_city3_city number 4"></td>
            </tr>
            <tr>
                <td>Description:</td>
                <td><textarea name="description" form="travel_form" cols="40" rows="5" placeholder="Enter the descritpion here..."></textarea></td>
            </tr>
        </table>
        <button name="submit">Send</button>
        <input type="reset" value="Clear">
    </form>
    <br>
    <?php
        // for the go back link
        $agency_name = str_replace(' ', '+', $_SESSION["agency"]);
        echo("<button onclick=\"location.href='../info_agency.php?agency={$agency_name}'\">Go back</button>");
        } else {
            // all checks and insert query
            $start = new DateTime($_POST["departure"]);
            $end = new DateTime($_POST["return"]);
            $vehicles = "";
            $error = false;

            if ($start > $end) {
                $error = true;
                echo("Dates are invalid.<br>");
            }

            if (!isset($_POST["transport"])) {
                $error = true;
                echo("You have to select at least one vehicle.<br>");
            } else {
                $vehicles = $_POST["transport"];
            }

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
                        $str_x = ucwords($x, '\' .');        // modifica e metti tutte le prime lettere maiuscole sopo gli spazi prima di inserire nel db
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
                $schedule_query = 'INSERT INTO itinerario (descrizione) VALUES(\''.$_POST["description"].'\')';
                $sdl = $conn -> query($schedule_query);              // it works
                $schedule_query = 'SELECT MAX(id) AS id FROM itinerario';
                $sd = $conn -> query($schedule_query) -> fetch_array();
                $sd_id = $sd["id"];
                // it schedule obtained

                foreach ($ct_id as $x) {             // it works
                    $insert_query = 'INSERT INTO itinerario_localita (id_localita, id_itinerario)
                            VALUES(\''.$x.'\', \''.$sd_id.'\')';
                    $res = $conn -> query($insert_query);
                }

                $travel_query = 'INSERT INTO viaggio (postiDisponibili, dataPartenza, dataArrivo, prezzo, id_agenzia, id_itinerario)
                        VALUES(\''.$_POST["places"].'\', \''.$_POST["departure"].'\', \''.$_POST["return"].'\', \''.$_POST["price"].'\', \''.$_SESSION["agency_id"].'\', \''.$sd_id.'\')';
                $res = $conn -> query($travel_query);

                $trav_id = $conn -> query('SELECT MAX(v.id) AS id FROM viaggio AS v WHERE v.id_agenzia = \''.$_SESSION["agency_id"].'\'') -> fetch_array()["id"];
                foreach($vehicles as $x) {
                    $vehi_query = 'INSERT INTO viaggio_mezzo (id_viaggio, id_mezzo)
                            VALUES(\''.$trav_id.'\', \''.$x.'\')';
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