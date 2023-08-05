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
    ?>
    <hr>
    <h2>Add Travel</h2>
    <?php
        $first = $_POST["schedule"];
        $second = $_POST["city"];
        // check if the user insert only one value
        if (($first == -1 && $second != "") || ($first != -1 && $second == "")) {
            if ($second != "") {
                $cities = PrepareCity($second);
                $ct_id = array();
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
                // took all the cities ids, creating schedule
                $schedule_query = 'INSERT INTO itinerario (descrizione) VALUES(\''.$_POST["description"].'\')';
                // $sdl = $conn -> query($schedule_query);              // it works
                $schedule_query = 'SELECT MAX(id) AS id FROM itinerario';
                $sd = $conn -> query($schedule_query) -> fetch_array();
                $sd_id = $sd["id"];
                // it schedule obtained

                // foreach ($ct_id as $x) {             // it works
                //     $insert_query = 'INSERT INTO itinerario_localita (id_localita, id_itinerario)
                //             VALUES(\''.$x.'\', \''.$sd_id.'\')';
                //     $res = $conn -> query($insert_query);
                // }

            } else {
                echo($first);
            }

        } else if ($first == -1 && $second == ""){
            echo("You cannot leave each empty, chose one and set it.");
        } else {
            echo("You cannot use the selection and the text area, please leave it empty or in the state \"--select cities--\".");
        }
    ?>
    <br>
    <button onclick="location.href='add_travel.php'">Go back</button>
</body>
<footer>
    <hr>
    <a href="../../index.php">HomePage</a>
</footer>
</html>