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
        }

        if (!isset($_POST["submit"])) {
    ?>
    <hr>

    <h3>Add a vehicle</h3>
    <form action="<?php echo($_SERVER["PHP_SELF"]); ?>" method="post">
        <table>
            <tr>
                <td>Vehicle type:</td>
                <td>
                    <input type="text" name="type" placeholder="Vehicle type (boat, auto, taxi, etc)">
                </td>
            </tr>
            <tr>
                <td>Available places:</td>
                <td>    
                    <input type="number" name="places" placeholder="Available places on the vehicle">
                </td>
            </tr>
            <tr>
                <td>Immatriculation year:</td>
                <td>
                    <input type="number" name="year" placeholder="Year of the vehicle">
                </td>
            </tr>
        </table>
    <br>
    <input type="submit" name="submit" value="Send">
    <input type="reset" value="Clear">
    </form>
    <br>
    <?php
        } else {
            $ins_query = 'INSERT INTO mezzo (tipo, annoImmatricolazione, postiDisponibili, id_agenzia)
                    VALUES(\''.$_POST["type"].'\', \''.$_POST["year"].'\', \''.$_POST["places"].'\', \''.$_SESSION["agency_id"].'\')';
            $conn -> query($ins_query);
            $agency_name = str_replace(' ', '+', $_SESSION["agency"]);
            header("location:../info_agency.php?agency={$agency_name}");
        }
        // for the go back link
        $agency_name = str_replace(' ', '+', $_SESSION["agency"]);
        echo("<button onclick=\"location.href='../info_agency.php?agency={$agency_name}'\">Go back</button>");
    ?>
</body>
<footer>
    <hr>
    <a href="../../index.php">HomePage</a>
</footer>
</html>