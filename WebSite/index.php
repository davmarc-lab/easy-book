<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Easy Book</title>
    <link rel="stylesheet" href="style/style.css">
</head>
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
        if (isset($_SESSION["user_id"])){               // se settato l' array superglobale $_SESSION vuol dire che è stato effettuato il login
          echo ("Hello ".$_SESSION["name"]." | <a href=\"user/logout.php\">Logout</a> </login>");
          $user = $_SESSION["name"];
        }else{
      ?>
      <a href="user/login.php">Login</a> |
      <a href="user/register.php">Sign Up</a>
    <?php } ?>
    <hr>

    <h2>All agencies</h2>
    <agency>
        <table style = "width: 40%">
            <tr>
                <th style = "width: 40%">Name</th>
                <th style = "width: 30%">Number of travels</th>
                <th>Reviews</th>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
            </tr>
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
    <hr>

</body>
</html>