<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="../../style/style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Easy Book</title>
</head>
<style>
    table,
    th {
        border: 1px solid black;
        border-collapse: collapse;
        color: red;
        width: auto;
    }

    td {
        border: 1px solid black;
        border-collapse: collapse;
        padding-left: 10px;
        padding-right: 10px;
        color: black;
        width: auto;
    }
</style>

<body>
    <h1>Easy Book</h1>
    <?php
    session_start();
    include_once("../../database/dbConnection.php");
    if (isset($_SESSION["id"])) {
        PrintLoginInfo();
    } else {
        header("location:../../user/login.php");
    }
    ?>
    <hr>
    <h3>Add Employee</h3>
    <?php
    $conn = OpenCon();
    ?>
    <table style="max-width: 70%; min-width: 50%">
        <tr>
            <th>Name</th>
            <th>Surname</th>
            <th>Email</th>
            <th>Work for agencies?</th>
            <th>Own agencies?</th>
            <th>Select</th>
        </tr>
        <form action="add.php" method="post">
            <?php
            $ag_query = 'SELECT * FROM agenzia AS a WHERE a.nome = \'' . $_SESSION["agency"] . '\'';
            $ag = $conn->query($ag_query)->fetch_array();
            $ow_id = $ag["id_utente"];
            $ag_id = $_SESSION["agency_id"];

            $sel_query = 'SELECT u.id FROM utente AS u WHERE u.id = \'' . $_SESSION["id"] . '\'';
            $sel = $conn->query($sel_query)->fetch_array();
            $us_id = $sel["id"];

            $empl_query = "SELECT u.id AS id, u.nome AS nome, u.cognome AS cognome, u.email as email, (SELECT COUNT(au.id) FROM agenzia_utente as au WHERE au.id_utente = u.id) as num,
                            (SELECT COUNT(ag.id) FROM agenzia as ag WHERE ag.id_utente = u.id) as own
                        FROM utente AS u, agenzia as a
                        WHERE a.id_utente != u.id
                        AND u.id NOT IN (SELECT au.id_utente
                            FROM agenzia_utente as au, utente as p
                            WHERE au.id_utente = p.id AND (CURDATE() > au.scadenza OR au.scadenza IS NULL)
                            )
                        GROUP BY u.id;";
            $res = $conn->query($empl_query);
            foreach ($res as $r) {
                echo ("<tr>");
                echo ("<td>" . $r["nome"] . "</td>");
                echo ("<td>" . $r["cognome"] . "</td>");
                echo ("<td>" . $r["email"] . "</td>");

                $num = intval($r["num"]) > 0 ? $r["num"] : "No";
                echo ("<td style=\"text-align: center\">" . $num . "</td>");

                $own = $r["own"] > 0 ? $r["own"] : "No";
                echo ("<td style=\"text-align: center\">" . $own . "</td>");
                echo ("<td style=\"text-align: center\"><input type=\"checkbox\" name=\"user[]\" value=\"{$r["id"]}\" /></td>");
                echo ("</tr>");
            }
            ?>
    </table>
    <br>
    <input type="submit" value="Submit">
    <input type="reset" value="Clear">
    </form>
    <?php
    // for the go back link
    $agency_name = str_replace(' ', '+', $_SESSION["agency"]);
    echo ("<button onclick=\"location.href='../info_agency.php?agency={$agency_name}'\">Go back</button>");
    ?>
</body>
<footer>
    <hr>
    <a href="../../index.php">HomePage</a>
</footer>

</html>