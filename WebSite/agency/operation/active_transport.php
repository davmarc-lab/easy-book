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
    <h2>Active Transport</h2>
    <?php
    if (!isset($_POST["submit"])) {
        echo ("<h3>Are you sure you want to activate this vehicle?</h3>");

        $vehi_query = 'SELECT * FROM mezzo as m WHERE m.id = \'' . $_POST["vehicle"] . '\'';
        $vehi = $conn->query($vehi_query)->fetch_array();

    ?>
        <table style="text-align: center;" class="tab">
            <tr>
                <th class="tab">Type</th>
                <th class="tab">Immatriculation year</th>
                <th class="tab">Available places</th>
            </tr>

            <tr>
                <td class="ele"><?php echo ($vehi["tipo"]); ?></td>
                <td class="ele"><?php echo ($vehi["annoImmatricolazione"]); ?></td>
                <td class="ele"><?php echo ($vehi["postiDisponibili"]); ?></td>
            </tr>
        </table>
        <br>

        <table>
            <tr>
                <td>
                    <form action="<?php echo ($_SERVER["PHP_SELF"]) ?>" method="post">
                        <input type="submit" name="submit" value="Activate" style="color: blue">
                        <input type="hidden" name="transp" value="<?php echo ($_POST["vehicle"]); ?>">
                        <input type="hidden" name="man" value="<?php echo ($_POST["man"]); ?>">
                    </form>
                </td>
                <td>
                    <?php
                    echo ("<button onclick=\"location.href='../info_vehicle.php?vehicle={$_POST["vehicle"]}' \">Go back</button>");
                    ?>
                </td>
            </tr>
        </table>
    <?php
    } else {
        $activate_query = "UPDATE manutenzione
                SET
                    dataFine = CURDATE()
                WHERE
                    id = '{$_POST["man"]}';";
        $res = $conn->query($activate_query);
        header("location:../info_vehicle.php?vehicle={$_POST["transp"]}");
    }
    ?>
    <footer>
        <hr>
        <a href=" ../../index.php">HomePage</a>
    </footer>
</body>

</html>