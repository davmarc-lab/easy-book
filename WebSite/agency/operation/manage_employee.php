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
            echo ("Hello " . $_SESSION["name"] . " | <a href=\"../homepage_agency.php\">Agencies</a> | <a href=\"../../user/logout.php\">Logout</a>");
            ?>
        </div>
    <?php
    } else {
        header("location:../../user/login.php");
    }

    if (!isset($_POST["send"])) {
    ?>
        <hr>
        <h2>Manage employee</h2>

        <form action="<?php echo ($_SERVER["PHP_SELF"]); ?>" method="post">
            <?php
            $employee_query = 'SELECT au.tipoContratto as contratto, au.scadenza as scadenza
                    FROM agenzia_utente as au
                    WHERE au.id = \'' . $_POST["emid"] . '\'';
            $empl = $conn->query($employee_query)->fetch_array();
            ?>
            <table>
                <tr>
                    <td>Employee contract:</td>
                    <td>
                        <input type="text" name="contract" value="<?php echo ($empl["contratto"]); ?>" required><br>
                    </td>
                </tr>
                <tr>
                    <td>Expire contract date:</td>
                    <td>
                        <input type="date" name="date" value="<?php echo ($empl["scadenza"]); ?>"><br>
                    </td>
                </tr>
            </table>
            <input type="submit" name="send" value="Modify">
            <input type="hidden" name="emid" value="<?php echo ($_POST["emid"]); ?>">
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