<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="../style/style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Easy Book</title>
</head>
<style>
    table,
    th {
        text-align: center;
        border: 1px solid black;
        border-collapse: collapse;
        padding-left: 4px;
        padding-right: 4px;
        color: red;
        width: auto;
    }

    td {
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
    include_once("../database/dbConnection.php");
    PrintLoginInfo();
    $conn = OpenCon();

    if (!isset($_SESSION["id"])) {
        header("location:../user/login.php");
    }
    echo ("<hr>");

    $vehi_query = 'SELECT * FROM mezzo as m WHERE m.id = \'' . $_GET["vehicle"] . '\'';
    $vehi = $conn->query($vehi_query)->fetch_array();
    echo ("<h3>Vehicle N -> {$vehi["id"]}</h3>");
    ?>

    <table style="text-align: center">
        <tr>
            <th>Type</th>
            <th>Immatriculation year</th>
            <th>Available places</th>
        </tr>

        <tr>
            <td><?php echo ($vehi["tipo"]); ?></td>
            <td><?php echo ($vehi["annoImmatricolazione"]); ?></td>
            <td><?php echo ($vehi["postiDisponibili"]); ?></td>
        </tr>
    </table>
    <br>

    <div style="display: flex">
        <form action="operation/suspend_transport.php" method="get" style="flex-basis: 70px">
            <button name="vehi" value="<?php echo ($vehi["id"]); ?>">Suspend</button>
        </form>

        <form action="operation/manage_transport.php" method="get">
            <button name="vehi" value="<?php echo ($vehi["id"]); ?>">Modify</button>
        </form>
    </div>
    <hr>
    <h2>All maintenance</h2>
    <table>
        <tr>
            <th>Reason</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Description</th>
        </tr>
        <?php
        $trs_query = "SELECT * 
                FROM manutenzione as m, mezzo_manutenzione as mm
                WHERE m.id = mm.id_manutenzione
                AND mm.id_mezzo = '{$_GET["vehicle"]}'";
        $trs = $conn->query($trs_query);

        foreach ($trs as $x) {
            echo ("<tr>");
            echo ("<td>{$x["motivo"]}</td>");
            echo ("<td>{$x["dataInizio"]}</td>");
            echo ("<td>{$x["dataFine"]}</td>");
            echo ("<td>{$x["descrizione"]}</td>");
            echo ("</tr>");
        }

        ?>
    </table>
    <?php
    $agency_name = str_replace(' ', '+', $_SESSION["agency"]);
    echo ("<br><button onclick=\"location.href='info_agency.php?agency={$agency_name}'\">Go back</button>");
    ?>
    <footer>
        <hr>
        <a href=" ../index.php">HomePage</a>
    </footer>
</body>

</html>