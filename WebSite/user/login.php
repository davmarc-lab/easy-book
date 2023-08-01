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
    <?php if (!isset($_SESSION["user_id"]))
        if (!isset($_POST["submit"])) { ?>
            <form method="post" action="<?php echo $_SERVER["PHP_SELF"]?>">
                <h2>User Login</h2>
                <table>
                    <tr>
                        <td>Email:</td>
                        <td><input type="email" placeholder="Email" name = "email" required></td>
                    </tr>
                    <tr>
                        <td>Password:</td>
                        <td><input type="password" placeholder="Password" name = "pass" required> <p>Please max 8 character</p></td>                
                    </tr>
                </table>
                <input type="submit" name="submit" value="login">
                <input type="reset" value="Clear">
            </form>
            <a href="../index.php">HomePage</a>
        <?php } else {
                session_start();
                include_once("../database/dbConnection.php");
                $mysql = OpenCon();
                $email = $_POST["email"];
                $inputPass = $_POST["pass"];

                if (empty($_SESSION["user_id"])) {
                    if (isset($_POST["email"]) && isset($_POST["pass"])) {
                        $userQuery = 'SELECT id, nome, email, password FROM utente AS u WHERE u.email = \''.$email.'\';';
                        $res = $mysql -> query($userQuery);

                        if ($res -> num_rows != 0) {
                            foreach ($res as $r) {
                                $id = $r["id"];
                                $name = $r["nome"];
                                $dbEmail = $r["email"];
                                $dbPass = $r["password"];
                            }
                            if (password_verify($inputPass, $dbPass)) {
                                echo("Login successfull.<br>");
                                $_SESSION["name"] = $name;
                                $_SESSION["user_id"] = $id;
                                header("location:../index.php");
                            } else {
                                echo("The input email doesn't exist.<br><a href=\"login.php\">Go back</a><br>");
                            }
                        } else {
                            echo("OGNI VOLTA CHE SI FA L'HASH È SEMPRE DIVERSO NON SO PERCHÉ<br>");
                        }
                    }
                }
                
            } ?>

</body>
</html>