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
    PrintLoginInfo();

    if (!isset($_POST["send"])) {
    ?>
        <hr>
        <h2>Manage vehicle</h2>

        <form action="<?php echo ($_SERVER["PHP_SELF"]); ?>" method="post">
            <?php
            $transport_query = 'SELECT * FROM mezzo as m WHERE m.id = \'' . $_GET["vehi"] . '\'';
            $trans = $conn->query($transport_query)->fetch_array();
            ?>
            <table>
                <tr>
                    <td>Type:</td>
                    <td>
                        <input type="text" name="type" value="<?php echo ($trans["tipo"]); ?>" placeholder="Vehicle type" required>
                    </td>
                </tr>
                <tr>
                    <td>Immatriculation year:</td>
                    <td>
                        <input type="number" name="year" value="<?php echo ($trans["annoImmatricolazione"]); ?>" placeholder="Vehicle year" required>
                    </td>
                </tr>
                <tr>
                    <td>Available places:</td>
                    <td>
                        <input type="number" name="places" value="<?php echo ($trans["postiDisponibili"]); ?>" placeholder="Available places" required>
                    </td>
                </tr>
            </table>
            <input type="hidden" name="vehicle" value="<?php echo ($_GET["vehi"]); ?>">
            <input type="submit" name="send" value="Modify">
            <input type="reset" value="Reset">
        </form>
        <br>
    <?php
        // for the go back link
        echo ("<button onclick=\"location.href='../info_vehicle.php?vehicle={$_GET["vehi"]}'\">Go back</button>");
    } else {

        $update_query = "UPDATE mezzo
                SET
                    tipo = '{$_POST["type"]}',
                    annoImmatricolazione = '{$_POST["year"]}',
                    postiDisponibili = '{$_POST["places"]}'
                WHERE
                    id = '{$_POST["vehicle"]}'";
        $res = $conn->query($update_query);
        header("location:../info_vehicle.php?vehicle={$_POST["vehicle"]}");
    }
    ?>
    <footer>
        <hr>
        <a href="../../index.php">HomePage</a>
    </footer>
</body>

</html>