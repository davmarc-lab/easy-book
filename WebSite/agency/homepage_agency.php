<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    <h2>Agency section</h2>
    <?php
        session_start();
        if (isset($_SESSION["user_id"])) {
            echo ("Hello ".$_SESSION["name"]." | <a href=\"../index.php\">HomePage</a> | <a href=\"../user/logout.php\">Logout</a><hr>");
            ?>
            <!-- qui va il corpo html, se serve riapri php -->
            <?php
        } else {
            echo("You have to do the login to manage your agency. Please click <a href=\"../user/login.php\">here</a>");
        }
    ?>
</body>
<footer>
    <a href="../index.php">HomePage</a>
</footer>
</html>