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
    PrintLoginInfo();
    if (!isset($_SESSION["id"])) {
        header("location:../../user/login.php");
    }
    $conn = OpenCon();
    ?>
    <hr>
    <h2>Suspend Transport</h2>
    <?php
    if (!isset($_POST["submit"])) {
    ?>
        <form action="<?php echo ($_SERVER["PHP_SELF"]); ?>" method="post">
            <table>
                <tr>
                    <td>Start Date:</td>
                    <td><input type="date" name="start" required></td>
                </tr>

                <tr>
                    <td>End Date:</td>
                    <td><input type="date" name="end"></td>
                </tr>
                <tr>
                    <td>Reason of suspension:</td>
                    <td><input type="text" name="reason" placeholder="Reason"></td>
                </tr>
                <tr>
                    <td>Description:</td>
                    <td><input type="text" name="description" placeholder="Leave a little description"></td>
                </tr>
            </table>
            <input type="submit" name="submit" value="Send">
            <input type="reset" value="Clear">
            <input type="hidden" name="vehi" value="<?php echo ($_GET["vehi"]); ?>">
        </form>
    <?php
    } else {
        $error = false;
        $start = $_POST["start"];
        $startDate = new DateTime($start);
        $end = $_POST["end"];

        if (!empty($_POST["end"])) {
            if ($end < $start) {
                $error = true;
                echo ("Invalid date.<br>");
            }
            $endDate = new DateTime($end);
        } else {
            $endDate = "NULL";
        }
        if ($endDate == "NULL") {
            $str = $endDate;
        } else {
            $str = "'{$endDate->format('Y-m-d')}'";
        }
        if ($error == true) {
            // unset submit and pass vehicle id
            unset($_POST["submit"]);
            echo ("<br><form action=\"{$_SERVER["PHP_SELF"]}\" method=\"get\"><input type=\"submit\" name=\"submit\" value=\"Retry\">
                <input type=\"hidden\" name=\"vehi\" value=\"{$_POST["vehi"]}\">
                </form>");
        } else {
            $insert_query = "INSERT INTO manutenzione (dataInizio, dataFine, motivo, descrizione) 
                    VALUES ('{$startDate->format('Y-m-d')}', $str , '{$_POST["reason"]}', '{$_POST["description"]}');";
            $res = $conn->query($insert_query);

            $last_id = $conn->insert_id;
            $insert_query = "INSERT INTO mezzo_manutenzione (id_mezzo, id_manutenzione) VALUES ('{$_POST["vehi"]}', '{$last_id}');";
            $res = $conn->query($insert_query);
        }
    }
    $agency_name = str_replace(' ', '+', $_SESSION["agency"]);
    echo ("<br><button onclick=\"location.href='../info_agency.php?agency={$agency_name}'\">Go back</button>");
    ?>
    <footer>
        <hr>
        <a href="../../index.php">HomePage</a>
    </footer>
</body>

</html>