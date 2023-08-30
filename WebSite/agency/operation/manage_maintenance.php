<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="../../style/style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Easy Book</title>
</head>
<style>
    .tab {
        border: 1px solid black;
        border-collapse: collapse;
        padding-left: 4px;
        padding-right: 4px;
        color: red;
        width: auto;
    }

    .ele {
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
    session_start();
    include_once("../../database/dbConnection.php");
    PrintLoginInfo();
    if (!isset($_SESSION["id"])) {
        header("location:../../user/login.php");
    }
    $conn = OpenCon();
    ?>
    <hr>
    <h2>Modify Maintenance</h2>
    <?php
    if (!isset($_POST["submit"])) {
        $man_query = "SELECT * FROM manutenzione as m WHERE m.id = '{$_POST["man"]}'";
        $man = $conn->query($man_query)->fetch_array();
    ?>
        <form action="<?php echo ($_SERVER["PHP_SELF"]); ?>" method="post" id="man_form">
            <table>
                <tr>
                    <td>Start date:</td>
                    <td>
                        <input type="date" name="start" value="<?php echo ($man["dataInizio"]); ?>" required>
                    </td>
                </tr>
                <tr>
                    <td>End date:</td>
                    <td>
                        <input type="date" name="end" value="<?php echo ($man["dataFine"]); ?>">
                    </td>
                </tr>
                <tr>
                    <td>Reason:</td>
                    <td>
                        <input type="text" name="reason" value="<?php echo ($man["motivo"]); ?>" placeholder="Reason of maintenance">
                    </td>
                </tr>
                <tr>
                    <td>Description:</td>
                    <td>
                        <textarea name="description" form="man_form" cols="40" rows="5" placeholder="Write the description here..."><?php echo ($man["descrizione"]); ?></textarea>
                    </td>
                </tr>
            </table>
            <input type="hidden" name="vehicle" value="<?php echo ($_POST["vehicle"]); ?>">
            <input type="hidden" name="man" value="<?php echo ($_POST["man"]); ?>">
            <input type="submit" name="submit" value="Modify" style="color: blue">
            <input type="reset" value="Clear">
        </form>
        <?php
        echo ("<br><button onclick=\"location.href='../info_vehicle.php?vehicle={$_POST["vehicle"]}'\">Go back</button>");
    } else {
        $start = new DateTime($_POST["start"]);
        $end = empty($_POST["end"]) ? "NULL" : new DateTime($_POST["end"]);
        $error = false;

        if ($end < $start && $end != "NULL") {
            $error = true;
            echo ("Invalid date.<br>");
        }

        if ($error) {
        ?>
            <table>
                <tr>
                    <td>
                        <?php
                        echo ("<form action='manage_maintenance.php' method='post'>
                            <button name='man' value='{$_POST["man"]}'>Retry</button>
                            <input type='hidden' name='vehicle' value='{$_POST["vehicle"]}'>
                        </form>")
                        ?>
                    </td>
                    <td>
                        <?php
                        echo ("<button onclick=\"location.href='../info_vehicle.php?vehicle={$_POST["vehicle"]}'\">Go back</button>");
                        ?>
                    </td>
                </tr>
            </table>
    <?php
        } else {
            $str = $end == "NULL" ? $end : "\"{$end->format('Y-m-d')}\"";
            $update_query = "UPDATE manutenzione
                SET
                    dataInizio = '{$start->format('Y-m-d')}',
                    dataFine = {$str},
                    motivo = '{$_POST["reason"]}', 
                    descrizione = '{$_POST["description"]}'
                WHERE
                    id = '{$_POST["man"]}'";
            $res = $conn->query($update_query);
            header("location:../info_vehicle.php?vehicle={$_POST["vehicle"]}");
        }
    }
    ?>
    <footer>
        <hr>
        <a href=" ../../index.php">HomePage</a>
    </footer>
</body>

</html>