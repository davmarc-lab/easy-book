<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="style/style.css"> -->
    <title>Easy Book</title>
</head>

<body>
    <h1>Easy Book</h1>
    <?php if (!isset($_POST["submit"])) { ?>
        <form method="post" action="<?php echo $_SERVER["PHP_SELF"]?>">
            <h2>User Sign Up</h2>
            <table>
                <tr>
                    <td>Name:</td>
                    <td><input type="text" placeholder="Name" name = "first" required></td>
                </tr>
                <tr>
                    <td>Surname:</td>
                    <td><input type="text" placeholder="Surname" name = "last" required></td>
                </tr>
                <tr>
                    <td>Telephone Number:</td>
                    <td><input type="text" placeholder="Include prefix" name = "tel"></td>
                </tr>
                <tr>
                    <td>Email:</td>
                    <td><input type="email" placeholder="Email" name = "email" required></td>
                </tr>
                <tr>
                    <td>Password:</td>
                    <td><input type="password" placeholder="Password" name = "pass" required> <p>Please max 8 character</p></td>                
                </tr>
            </table>
            <input type="submit" name="submit" value="Confirm">
            <input type="reset" value="Clear">
        </form>
        <a href="../index.php">HomePage</a>
        <?php } else {
            include_once("database/dbConnection.php");
            $namePattern = '/^[A-Za-z]{1,40}$/';
            $first = $_POST["first"];
            // check first name validity
            if (mb_strlen($first) > 40) {
                echo("The name is too long.<br><a href=\"register.php\">Go back</a><br>");
                $error = true;
            }
            $last = $_POST["last"];
            // check last name validity
            if (!preg_match($namePattern, $last)) {
                echo("The last name is not valid, use only letters and max 40 characters.<br><a href=\"register.php\">Go back</a><br>");
                $error = true;
            }
            $tel = $_POST["tel"];
            // check telephone number validity
            $isTelValid = filter_var($tel, FILTER_VALIDATE_REGEXP, ["options" => ["regexp" => "^(?=.*\+)([0-9+ ]{14})$"]]);
            if ($isTelValid === false && mb_strlen($tel) > 0) {
                echo("The telephone number is not valid, pleas use at least one + character and one space after the prefix, max 14 characters.
                        <br>Example: +01 0123456789<br><a href=\"register.php\">Go back</a>");
                $error = true;
            }
            $email = $_POST["email"];
            // check if email already exist in database
            $pass = $_POST["pass"];
            // check password validity
        } ?>

</body>
</html>