<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../../style/style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Easy Book</title>
</head>
<style>
    table, th {
        border:1px solid black;
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
            ?>
                <div class="login">
                    <?php
                        echo ("Hello ".$_SESSION["name"]." | <a href=\"./homepage_agency.php\">Agencies</a> | <a href=\"../user/logout.php\">Logout</a>");
                    ?>
                </div>
            <?php
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
                $query = 'SELECT u.id AS id, u.nome AS nome, u.cognome AS cognome, u.email AS email, (SELECT COUNT(a.id) FROM agenzia_utente AS a WHERE a.id_utente = u.id) AS num,
                            (SELECT COUNT(a.id) FROM agenzia AS a WHERE a.email = u.email) AS own
                        FROM utente AS u, agenzia_utente AS a
                        WHERE u.id != a.id_utente';
                $res = $conn -> query($query);
                foreach ($res as $r) {
                    echo("<tr>");
                    echo("<td>".$r["nome"]."</td>");
                    echo("<td>".$r["cognome"]."</td>");
                    echo("<td>".$r["email"]."</td>");

                    $num = intval($r["num"]) > 0 ? $r["num"] : "No";
                    echo("<td style=\"text-align: center\">".$num."</td>");
                    
                    $own = $r["own"] > 0 ? $r["own"] : "No";
                    echo("<td style=\"text-align: center\">".$own."</td>");
                    echo("<td style=\"text-align: center\"><input type=\"checkbox\" name=\"user[]\" value=\"{$r["id"]}\" /></td>");
                    echo("</tr>");
                }
            ?>
        </table>
        <input type="submit" value="Submit">
        <input type="reset" value="Clear">
    </form>    
    <?php
        // for the go back link
        $agency_name = str_replace(' ', '+', $_SESSION["agency"]);
        echo("<button onclick=\"location.href='../info_agency.php?agency={$agency_name}'\">Go back</button>");
    ?>
</body>
<footer>
    <hr>
    <a href="../index.php">HomePage</a>
</footer>
</html>