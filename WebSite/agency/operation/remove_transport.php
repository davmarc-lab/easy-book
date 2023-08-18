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
    <h2>Delete Transport</h2>
    <?php
    if (!isset($_POST["submit"])) {
        echo ("<h3>Are you sure you want to delete this vehicle?</h3>");

        $vehi_query = 'SELECT * FROM mezzo as m WHERE m.id = \'' . $_GET["vehicle"] . '\'';
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
                        <input type="submit" name="submit" value="Remove" style="color: red">
                        <input type="hidden" name="transp" value="<?php echo ($_GET["vehicle"]); ?>">
                    </form>
                </td>
                <td>
                    <?php
                    $agency_name = str_replace(' ', '+', $_SESSION["agency"]);
                    echo ("<button onclick=\"location.href='../info_agency.php?agency={$agency_name}' \">Go back</button>");
                    ?>
                </td>
            </tr>
        </table>
        <h3>It will remove also all the travels with this vehicle.</h3>
        <?php
        $travel_query = "SELECT v.* FROM viaggio as v, viaggio_mezzo as vm
                WHERE v.id = vm.id_viaggio
                AND vm.id_mezzo = '{$_GET["vehicle"]}'
                GROUP BY v.id";
        $trv = $conn->query($travel_query);

        if ($trv->num_rows > 0) {
        ?>
            <table style="text-align: center;" class="tab">
                <tr>
                    <th class="tab">Schedule</th>
                    <th class="tab">Departure Date</th>
                    <th class="tab">Return Date</th>
                    <th class="tab">Available places</th>
                    <th class="tab">Price</th>
                </tr>
                <?php
                foreach ($trv as $x) {
                    $dest_query = 'SELECT l.nome
                            FROM localita as l, itinerario_localita as il 
                            WHERE l.id = il.id_localita
                            AND il.id_itinerario = 
                                (SELECT v.id_itinerario
                                FROM viaggio as v
                                WHERE v.id = \'' . $x["id"] . '\');';
                    $dest = $conn->query($dest_query);
                    $cities = "";
                    foreach ($dest as $c) {
                        $cities .= ($c["nome"] . '-');
                    }
                    $cities = substr_replace($cities, "", -1);
                    echo ("<tr>");
                    echo ("<td>$cities</td>");
                    echo ("<td>{$trv["dataPartenza"]}</td>");
                    echo ("<td>{$trv["dataArrivo"]}</td>");
                    echo ("<td>{$trv["postiDisponibili"]}</td>");
                    echo ("<td>{$trv["prezzo"]}</td>");
                    echo ("</tr>");
                }
                ?>

            </table>
    <?php
        }
    } else {
        $remove_query = "DELETE FROM mezzo as m WHERE m.id = '{$_POST["transp"]}';";
        $res = $conn->query($remove_query);
        $agency_name = str_replace(' ', '+', $_SESSION["agency"]);
        header("location:../info_agency.php?agency={$agency_name}");
    }
    ?>
    <footer>
        <hr>
        <a href=" ../../index.php">HomePage</a>
    </footer>
</body>

</html>