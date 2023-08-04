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
                        echo ("Hello ".$_SESSION["name"]." | <a href=\"../homepage_agency.php\">Agencies</a> | <a href=\"../user/logout.php\">Logout</a>");
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
    <a href="../index.php">HomePage</a>
</footer>
</html>