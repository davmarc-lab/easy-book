<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="../../style/style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Easy Book</title>
</head>

<body>
    <h1>Easy Book</h1>
    <?php
    session_start();
    include_once("../../database/dbConnection.php");
    $conn = OpenCon();
    if (isset($_SESSION["id"])) {
        PrintLoginInfo();
    } else {
        header("location:../login.php");
    }
    if (!isset($_POST["submit"])) {
        $user_query = "SELECT * FROM utente as u WHERE u.id = '{$_SESSION["id"]}'";
        $user = $conn->query($user_query)->fetch_array();
    ?>
        <hr>
        <h2>Modify Information</h2>
        <form action="<?php echo ($_SERVER["PHP_SELF"]); ?>" method="post">
            <table>
                <tr>
                    <td>First Name:</td>
                    <td>
                        <input type="text" maxlength="40" name="name" value="<?php echo ($user["nome"]); ?>" placeholder="First name" required>
                    </td>
                </tr>
                <tr>
                    <td>Last Name:</td>
                    <td>
                        <input type="text" maxlength="40" name="surname" value="<?php echo ($user["cognome"]); ?>" placeholder="Surname" required>
                    </td>
                </tr>
                <tr>
                    <td>Telephone:</td>
                    <td>
                        <input type="text" maxlength="14" name="telephone" value="<?php echo ($user["telefono"]); ?>" placeholder="Telephone number">
                    </td>
                </tr>
                <tr>
                    <td>Email:</td>
                    <td>
                        <input type="email" name="email" value="<?php echo ($user["email"]); ?>" placeholder="Email" required>
                    </td>
                </tr>
            </table>
            <input type="submit" name="submit" value="Send">
            <input type="reset" value="Clear">
        </form>
    <?php
    } else {
        $error = false;
        $namePattern = '/^[A-Za-z]{1,40}$/';
        $passPattern = '/^.{1,8}$/';
        $first = $_POST["name"];
        // check first name validity
        if (!preg_match($namePattern, $first)) {
            echo ("The first name is not valid, use only letters and max 40 characters.<br>");
            $error = true;
        }
        $last = $_POST["surname"];
        // check last name validity
        if (!preg_match($namePattern, $last)) {
            echo ("The last name is not valid, use only letters and max 40 characters.<br>");
            $error = true;
        }
        $tel = $_POST["telephone"];
        // check telephone number validity
        $isTelValid = filter_var($tel, FILTER_VALIDATE_REGEXP, ["options" => ["regexp" => "/^(?=.*\+)([0-9+ ]{14})$/"]]);
        if ($isTelValid === false && mb_strlen($tel) > 0) {
            echo ("The telephone number is not valid, pleas use at least one + character and one space after the prefix, max 14 characters.
                        <br>Example: +01 0123456789<br>");
            $error = true;
        }
        // manca il controllo per l'email
        $email = $_POST["email"];
        $email_query = 'SELECT u.email FROM utente AS u
                WHERE u.email = \'' . $email . '\'
                AND u.id != \'' . $_SESSION["id"] . '\'';
        $res = $conn->query($email_query);
        if ($res->num_rows) {
            $error = true;
            echo ("The email already exist in the database.<br>");
        }

        if ($error) {
            echo ("<button onclick=\"window.location.href='manage_user.php'\">Retry</button>");
            echo ("<button onclick=\"window.location.href='../info_user.php'\">Go back</button>");
        } else {
            // send it ma broda
            $update_query = "UPDATE utente
                    SET
                        nome = '{$first}',
                        cognome = '{$last}',
                        telefono = '{$tel}',
                        email = '{$email}'
                    WHERE
                        id = '{$_SESSION["id"]}';";
            $res = $conn->query($update_query);
            header("location:../info_user.php");
        }
    }
    ?>
    <footer>
        <hr>
        <a href="../../index.php">HomePage</a>
    </footer>
</body>

</html>