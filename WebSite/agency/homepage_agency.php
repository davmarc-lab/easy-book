<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../style/style.css">
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
        padding-left: 4px;
        padding-right: 4px;
        color: black;
        width: auto;
    }

</style>
<body>
    <h1>Easy Book</h1>
    <h2>Agency section</h2>
    <?php
        session_start();
        if (isset($_SESSION["id"])) {
            include_once("../database/dbConnection.php");
            $conn = OpenCon();
            ?>
                <div class="login">
            <?php
                echo ("Hello ".$_SESSION["name"]." | <a href=\"../index.php\">HomePage</a> | <a href=\"../user/logout.php\">Logout</a>");
            ?> </div> <hr> <?php
            $owner_query = 'SELECT FROM ';
            ?>
            <h3>Your agencies</h3>
            <table style="min-width: 50%; max-width: 70%">
                <tr>
                    <th>Name</th>
                    <th>Contact</th>
                    <th>Number of Travels</th>
                    <th>Link</th>
                </tr>
                    <?php
                        $query = 'SELECT *, (SELECT COUNT(v.id) FROM viaggio as v WHERE v.id_agenzia = a.id) AS nt FROM agenzia AS a 
                                WHERE a.email = (SELECT email FROM utente AS u WHERE u.id = \''.$_SESSION["id"].'\')';
                        $res = $conn -> query($query);
                        foreach ($res as $r) {
                            echo("<tr>");
                            echo("<td>".$r["nome"]."</td>");
                            echo("<td>".$r["telefono"]."</td>");
                            echo("<td style = \"text-align: center\">".$r["nt"]."</td>");
                            echo("<td style=\"text-align: center\">");
                            ?>
                            <form action="info_agency.php" method="get">
                                <button style="cursor: pointer;" type="submit" name="agency" value="<?php echo($r["nome"]); ?>">Go</button>
                            </form>
                            <?php echo("</td>");
                            echo("</tr>");
                        }
                    ?>
            </table>
            <hr>
            <h3>Agencies you work for</h3>
            <table style="min-width: 50%; max-width: 70%">
                <tr>
                    <th>Name</th>
                    <th>Owner</th>
                    <th>Contact</th>
                    <th>Number of Travels</th>
                    <th>Link</th>
                </tr>
                    <?php
                        $query = 'SELECT a.nome AS nome, a.proprietario AS proprietario, a.telefono AS telefono, 
                                (SELECT COUNT(v.id) FROM viaggio as v WHERE v.id_agenzia = a.id) AS nt FROM agenzia AS a, agenzia_utente AS au
                                WHERE au.id_agenzia = a.id AND au.id_utente = \''.$_SESSION["id"].'\'';
                        $res = $conn -> query($query);
                        foreach ($res as $r) {
                            echo("<tr>");
                            echo("<td>".$r["nome"]."</td>");
                            echo("<td>".$r["proprietario"]."</td>");
                            echo("<td>".$r["telefono"]."</td>");
                            echo("<td style = \"text-align: center\">".$r["nt"]."</td>");
                            echo("<td style=\"text-align: center\">");
                            ?>
                            <form action="info_agency.php" method="get">
                                <button style="cursor: pointer;" type="submit" name="agency" value="<?php echo($r["nome"]); ?>">Go</button>
                            </form>
                            <?php echo("</td>");
                            echo("</tr>");
                        }
                    ?>

            </table>
            <?php
        } else {
            echo("You have to do the login to manage your agency. Please click <a href=\"../user/login.php\">here</a>");
        }
    ?>
</body>
<footer>
    <hr>
    <a href="../index.php">HomePage</a>
</footer>
</html>