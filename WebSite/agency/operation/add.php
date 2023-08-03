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
        $conn = OpenCon();
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
    <h2>Add information</h2>
        <table style="max-width: 70%; min-width: 50%">
            <tr>
                <th>Email</th>
                <th>Type of Contract</th>
                <th>End of Contract</th>
            </tr>
            <form action="check.php" method="post">
                <?php
                    $users = $_POST["user"];
                    $i = 0;
                    foreach ($users as $x) {
                        $info = $conn -> query('SELECT * FROM utente AS u WHERE u.id = \''.$x.'\'') -> fetch_array();
                        echo("<tr>");
                        echo("<td>".$info["email"]."</td>");
                        echo("<td><input type=\"text\" name=\"meta[{$i}][contract]\" placeholder=\"Type of contract\" required></td>");
                        echo("<td><input type=\"date\" name=\"meta[{$i}][date]\" placeholder=\"End of contract\"></td>");
                        echo("</tr>");
                        echo("<input type=\"hidden\" name=\"meta[{$i}][userid]\" value=\"{$info["id"]}\">");
                        $ag_query = 'SELECT a.id FROM agenzia AS a WHERE a.nome = \''.$_SESSION["agency"].'\'';
                        $ag_id = $conn -> query($ag_query) -> fetch_array();
                        $i++;
                    }
                ?>
            
        </table>
        <input type="submit" name="submit" value="Submit">
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
