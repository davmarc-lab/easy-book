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
        $agency_query = 'SELECT nome FROM agenzia AS a WHERE a.nome = \''.$_GET["agency"].'\' ;';
        $res = $conn -> query($agency_query);
        $agency = ($res -> fetch_array())["nome"];
        echo("<hr><h2>{$agency}</h2>");
    ?>

    

</body>
<footer>
    <hr>
    <a href="../index.php">HomePage</a>
</footer>
</html>