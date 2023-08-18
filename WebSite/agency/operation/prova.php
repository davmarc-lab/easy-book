<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="../../style/style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Easy Book</title>
</head>
<style>
    .transport {
        border: 1px solid black;
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
    function PrepareCity($string)
    {
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
            echo ("Hello " . $_SESSION["name"] . " | <a href=\"../homepage_agency.php\">Agencies</a> | <a href=\"../../user/logout.php\">Logout</a>");
            ?>
        </div>
    <?php
    } else {
        header("location:../../user/login.php");
    }

    $error = false;
    if (!isset($_POST["submit"])) {
    ?>
        <hr>
        <h2>New Travel</h2>
        <h3>Organize the travel</h3>

        <form action="<?php echo ($_SERVER["PHP_SELF"]); ?>" method="post" id="travel_form">
            <?php
            if (!isset($_POST["departure"]) || !isset($_POST["return"])) {
            ?>
                <table>
                    <tr>
                        <td>Departure date:</td>
                        <td>
                            <input type="date" name="departure" placeholder="Departure date" required>
                        </td>
                    </tr>
                    <tr>
                        <td>Return date:</td>
                        <td>
                            <input type="date" name="return" placeholder="Return date" required>
                        </td>
                    </tr>
                </table>
            <?php
            }
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
        echo ("<button onclick=\"location.href='../" . ($error ? "operation/add_travel.php" : "info_agency.php?agency={$agency_name}") . "'\">Go back</button>");
    } else {
        $start = new DateTime($_POST["departure"]);
        $end = new DateTime($_POST["return"]);

        echo ($start->format('Y-m-d') . "   " . $end->format('Y-m-d'));
        $ins = "INSERT INTO insdata (inizio, fine) VALUES('{$start->format('Y-m-d')}', '{$end->format('Y-m-d')}')";
        $res = $conn->query($ins);
    }
    ?>
    <footer>
        <hr>
        <a href="../../index.php">HomePage</a>
    </footer>
</body>

</html>