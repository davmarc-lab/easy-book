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
            <p>DA FAREE</p>
            <input type="submit" name="send" value="Modify">
        </form>
        <br>
    <?php
        // for the go back link
        $agency_name = str_replace(' ', '+', $_SESSION["agency"]);
        echo ("<button onclick=\"location.href='../info_agency.php?agency={$agency_name}'\">Go back</button>");
    } else {
        // all checks and insert query
        $error = false;

        if ($error) {
            unset($_POST["send"]);
            echo ("<br><form action=\"{$_SERVER["PHP_SELF"]}\" method=\"post\"><input type=\"submit\" name=\"submit\" value=\"Go back\">
                <input type=\"hidden\" name=\"emid\" value=\"{$emid}\">
                </form>");
        } else {
            // go next, put it in
            echo ($_POST["date"]);
            if (empty($_POST["date"])) {
                $str = "NULL";
            } else {
                $da = new DateTime($_POST["date"]);
                $str = $da->format('Y-m-d');
            }
            $update_query = 'UPDATE agenzia_utente
                    SET
                        tipoContratto = \'' . $_POST["contract"] . '\',
                        scadenza = ' . $str . '
                    WHERE
                        id = \'' . $_POST["emid"] . '\'';
            $res = $conn->query($update_query);

            $agency_name = str_replace(' ', '+', $_SESSION["agency"]);
            header("location:../info_agency.php?agency={$agency_name}");
        }
    }
    ?>
    <footer>
        <hr>
        <a href="../../index.php">HomePage</a>
    </footer>
</body>

</html>