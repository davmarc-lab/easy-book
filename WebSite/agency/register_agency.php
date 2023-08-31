<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="../style/style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Easy Book</title>
</head>

<body>
    <h1>Easy Book</h1>
    <?php
    session_start();
    include_once("../database/dbConnection.php");
    if (isset($_SESSION["id"])) {
        PrintLoginInfo();
    } else {
    ?>
        <div class="login">
            <a href="../user/login.php">Login</a> |
            <a href="../user/register.php">Sign Up</a>
        </div>
        <hr>
    <?php
    }
    if (!isset($_POST["submit"])) { ?>
        <form method="post" action="<?php echo $_SERVER["PHP_SELF"] ?>">
            <h2>Agency Sign Up</h2>
            <table>
                <tr>
                    <td>Agency Name:</td>
                    <td><input type="text" placeholder="Name" name="name" required></td>
                </tr>
                <tr>
                    <td>Owner:</td>
                    <td><input type="text" placeholder="Owner" name="owner" required></td>
                </tr>
                <tr>
                    <td>Head Office:</td>
                    <td><input type="text" placeholder="City Name" name="city"></td>
                </tr>
                <tr>
                    <td>Telephone Number:</td>
                    <td><input type="text" placeholder="Include prefix" name="tel"></td>
                </tr>
            </table>
            <input type="submit" name="submit" value="Confirm">
            <input type="reset" value="Clear">
        </form>
        <hr>
        <a href="../index.php">HomePage</a>
    <?php } else {
        include_once("../database/dbConnection.php");
        $mysql = OpenCon();
        $error = false;
        $namePattern = '/^[A-Za-z ]{1,100}$/';
        $passPattern = '/^.{1,8}$/';
        $name = $_POST["name"];
        // check name name validity
        if (!preg_match($namePattern, $name)) {
            echo ("The agency name is not valid, use only letters and max 100 characters.<br>");
            $error = true;
        }
        $owner = $_POST["owner"];
        // check owner name validity
        if (!preg_match($namePattern, $owner)) {
            echo ("The owner name is not valid, use only letters and max 100 characters.<br>");
            $error = true;
        }
        $city = $_POST["city"];
        // check city name validity
        if (!preg_match($namePattern, $city) && mb_strlen($city) > 0) {
            echo ("The city name is not valid, use only letters and max 100 characters.<br>");
            $error = true;
        }

        $tel = $_POST["tel"];
        // check telephone number validity
        $isTelValid = filter_var($tel, FILTER_VALIDATE_REGEXP, ["options" => ["regexp" => "/^(?=.*\+)([0-9+ ]{14})$/"]]);
        if ($isTelValid === false && mb_strlen($tel) > 0) {
            echo ("The telephone number is not valid, pleas use at least one + character and one space after the prefix, max 14 characters.
                        <br>Example: +01 0123456789<br>");
            $error = true;
        }

        if ($error == true) {
            echo ("<a href=\"register_agency.php\">Go back</a><br>");
            echo ("<a href=\"../index.php\">Home Page</a><br>");
        } else {
            $insert_query = 'INSERT INTO agenzia (nome, proprietario, sedeFisica, telefono, id_utente)
                        VALUES(\'' . $name . '\', \'' . $owner . '\', \'' . $city . '\', \'' . $tel . '\', \'' . $_SESSION["id"] . '\');';
            $mysql->query($insert_query);
            echo ("Agency signed correctly. You can now <a href=\"../index.php\">Go back</a><br>");
        }
    } ?>
</body>

</html>