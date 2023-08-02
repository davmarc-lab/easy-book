<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="style/style.css"> -->
    <title>Easy Book</title>
</head>
<style>
    table, th {
        border:1px solid black;
        border-collapse: collapse;
        color: red;
    }

    td {
        border: 1px solid black;
        border-collapse: collapse;
        color: black;
        text-indent: 4px;
    }


</style>
<body>
    <h1>Easy Book</h1>
    <h3>Check our list of destination for your vacation and book it.</h3>
    <p>It is fast and simple: choose, pay and have fun.</p>
    <p>The rules are simple, if you want to book a vacation you have to sign up or do login, you have to be signed on the platform. <br>
        &emsp;After you can do whatever tou want and book how many vacation you can afford.
    </p>
    <p>If you already have an account press the Login button, instead you can press the Sign Up button to create an account.</p>

    <?php
        session_start();
        include_once("database/dbConnection.php");
        $conn = OpenCon();
        if (isset($_SESSION["user_id"])){               // se settato l' array superglobale $_SESSION vuol dire che è stato effettuato il login
          echo ("Hello ".$_SESSION["name"]." | <a href=\"user/logout.php\">Logout</a>");
        }else{
      ?>
      <a href="user/login.php">Login</a> |
      <a href="user/register.php">Sign Up</a>
    <?php } ?>
    <hr>
    <h2>All agencies</h2>
    <agency>
        <table style = "width: 70%">
            <tr>
                <th style = "width: 40%">Name</th>
                <th>Owner</th>
                <th>Contact</th>
                <th style = "width: 15%">Number of Travels</th>
            </tr>
                <?php
                    // restituisce le informazioni principali per ogni agenzia iscritta alla piattaforma
                    $query = 'SELECT *, (SELECT COUNT(v.id) FROM viaggio as v WHERE v.id_agenzia = a.id) AS nt FROM agenzia AS a';
                    $res = $conn -> query($query);
                    foreach ($res as $r) {
                        echo("<tr>");
                        echo("<td>".$r["nome"]."</td>");
                        echo("<td>".$r["proprietario"]."</td>");
                        echo("<td>".$r["telefono"]."</td>");
                        echo("<td style = \"text-align: center\">".$r["nt"]."</td>");
                        echo("</tr>");
                    }
                ?>

        </table>
    </agency>

    <hr>

    <h2>All travels</h2>
    <travel>
        <table style = "width: 70%">
            <tr>
                <th>Agency Name</th>
                <th>Destination</th>
                <th>Available Places</th>
                <th>Departure Date</th>
                <th>Return Date</th>
                <th style = "width: 10%">Price per person</th>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </table>
    </travel>
    <?php
        if (isset($_SESSION["user_id"])){
            echo ("<hr><h2>Are you an agency? <a href=\"agency/register_agency.php\">Click here</a> to create an agency and start organize vacations.</h2>");
        }
    ?>
</body>
</html>