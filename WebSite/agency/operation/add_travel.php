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
                        echo ("Hello ".$_SESSION["name"]." | <a href=\"../homepage_agency.php\">Agencies</a> | <a href=\"../user/logout.php\">Logout</a>");
                    ?>
                </div>
            <?php
        }
    ?>
    <hr>
    <h2>Add Travel</h3>
    <h3>Insert all the cities of the travel with this format (city 1_city 2_city 3)</h2>
    <form action="check_schedule.php" method="post">
        <table>
            <tr>
                <td>Select from all schedule:</td>
                <td>
                    <select name="schedule">
                        <option value="-1">--select cities--</option>
                        <?php
                            $schedule_query = 'SELECT * FROM itinerario';
                            $scd = $conn -> query($schedule_query);
                            foreach ($scd as $x) {
                                $query = 'SELECT l.nome
                                        FROM localita as l, itinerario_localita as ai
                                        WHERE l.id = ai.id_localita
                                        AND l.id IN
                                            (SELECT ia.id_localita FROM itinerario_localita as ia);';
                                $res = $conn -> query($query);
                                foreach ($res as $city) {
                                    $cities.= ($city["nome"].'-');
                                }
                                $cities = substr_replace($cities, "", -1);
                                echo("<option value=\"{$x["id"]}\">{$cities}</option>");
                            }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td style="color: blue">or create a new one</td>
            </tr>
            <tr>
                <td>Cities:</td>
                <td><input type="text" name="city" placeholder="city1_city2"></td>
            </tr>
        </table>
        <button name="submit" value="toCheck">Send</button>
        <input type="reset" value="Clear">
    </form>
    <br>
    <?php
        // for the go back link
        $agency_name = str_replace(' ', '+', $_SESSION["agency"]);
        echo("<button onclick=\"location.href='../info_agency.php?agency={$agency_name}'\">Go back</button>");
    ?>
</body>
<footer>
    <hr>
    <a href="../index.php">HomePage</a>
</footer>
</html>