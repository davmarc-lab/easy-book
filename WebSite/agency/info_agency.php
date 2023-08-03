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
    <?php
        session_start();
        if (isset($_SESSION["id"])) {
            ?>
                <div class="login">
                    <?php
                        echo ("Hello ".$_SESSION["name"]." | <a href=\"./homepage_agency.php\">Agencies</a> | <a href=\"../user/logout.php\">Logout</a>");
                    ?>
                </div>
            <?php
        } else {
            ?>
            <div class="login">
                <a href="../user/login.php">Login</a> |
                <a href="../user/register.php">Sign Up</a>
            </div>
            <?php
        }
        include_once("../database/dbConnection.php");
        $conn = OpenCon();
        $_SESSION["agency"] = $_GET["agency"];
        $agency_query = 'SELECT id, nome FROM agenzia AS a WHERE a.nome = \''.$_GET["agency"].'\' ;';
        $res = $conn -> query($agency_query);
        $res = $res -> fetch_array();
        $agency = $res["nome"];
        $id_agency = $res["id"];
        echo("<hr><h2>{$agency}</h2>");
    ?>
    <h3>Employees</h3>
    <table style="max-width: 70%">
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Contract</th>
            <th>Operations</th>
        </tr>
            <?php
                $query = 'SELECT u.nome AS nome, u.email AS email, a.tipoContratto AS contratto FROM utente AS u, agenzia_utente AS a
                        WHERE a.id_agenzia = \''.$id_agency.'\' AND u.id IN
                                (SELECT id_utente FROM agenzia_utente WHERE agenzia_utente.id_agenzia = \''.$id_agency.'\')
                        AND u.id = a.id_utente';
                $res = $conn -> query($query);
                foreach ($res as $r) {
                    echo("<tr>");
                    echo("<td>".$r["nome"]."</td>");
                    echo("<td>".$r["email"]."</td>");
                    echo("<td style = \"text-align: center\">".$r["contratto"]."</td>");
                    echo("<td style=\"text-align: center\"><form action=\"operation/remove_employee.php\" method=\"post\"><button type=\"submit\" name=\"email\"value=\"".$r["email"]."\">Remove</button></form>
                        <input type=\"button\" onclick=\"location.href='agency/operations/remove_employee.php'\" value=\"Modify\"></td>");
                    echo("</tr>");
                }
            ?>
    </table>
    
    <input type="button" onclick="location.href='gg.php'" value="GG">

</body>
<footer>
    <hr>
    <a href="../index.php">HomePage</a>
</footer>
</html>