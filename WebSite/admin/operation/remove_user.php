<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="../../style/style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Easy Book</title>
</head>
<style>
    table,
    th {
        border: 1px solid black;
        border-collapse: collapse;
        padding-left: 4px;
        padding-right: 4px;
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
    include_once("../../database/dbConnection.php");
    $conn = OpenCon();

    $admin_query = 'SELECT u.id AS id FROM amministratore AS a, utente AS u
            WHERE u.id = a.id_utente
            AND a.dataRitiro IS NULL
            AND a.id = (SELECT MAX(s.id) FROM amministratore as s)';

    $admin_id = $conn->query($admin_query)->fetch_array()["id"];
    if (isset($_SESSION["id"]) && $_SESSION["id"] == $admin_id) {
        PrintLoginInfo();
    } else {
        header("location:../../user/login.php");
    }
    ?>
    <hr>
    <h2>Removing User</h2>
    <?php
    if (!isset($_POST["submit"])) {
    ?>
        <h3>Are you sure you want to remove this user?</h3>
        <table>
            <tr>
                <th>Name</th>
                <th>Surname</th>
                <th>Telephone</th>
                <th>Email</th>
                <th>Travel Booked</th>
                <th>Number of Agencies</th>
            </tr>
            <tr>
                <?php
                $user_query = "SELECT * FROM utente as u WHERE u.id = '{$_POST["user"]}'";
                $user = $conn->query($user_query)->fetch_array();
                $travels_query = "SELECT COUNT(v.id) as num FROM viaggio_utente as v WHERE v.id_utente = '{$_POST["user"]}'";
                $travels = $conn->query($travels_query)->fetch_array();
                $agency_query = "SELECT COUNT(a.id) as num FROM agenzia as a WHERE a.email = '{$user["email"]}'";
                $agency = $conn->query($agency_query)->fetch_array();
                ?>
                <td><?php echo ($user["nome"]); ?></td>
                <td><?php echo ($user["cognome"]); ?></td>
                <td><?php echo ($user["telefono"]); ?></td>
                <td><?php echo ($user["email"]); ?></td>
                <td style="text-align: center;"><?php echo ($travels["num"]); ?></td>
                <td style="text-align: center;"><?php echo ($agency["num"]); ?></td>
            </tr>
        </table>
        <br>
        <form action="<?php echo ($_SERVER["PHP_SELF"]); ?>" method="post">
            <input type="hidden" name="user" value="<?php echo ($_POST["user"]); ?>">
            <input type="hidden" name="email" value="<?php echo ($user["email"]); ?>">
            <input style="color: red;" type="submit" name="submit" value="Remove">
        </form>
    <?php
    } else {
        $user_id = $_POST["user"];
        $user_email = $_POST["email"];
        $travels_query = "SELECT v.id as id, vu.numeroPrenotazioni as num, vu.id as reser FROM viaggio_utente as vu, viaggio as v
                WHERE vu.id_utente = '{$user_id}'
                AND vu.id_viaggio = v.id
                AND CURDATE() < v.dataPartenza";
        $travels = $conn->query($travels_query);

        foreach ($travels as $x) {
            $num = intval($x["num"]);
            $update_query = "UPDATE viaggio as v
                    SET
                        postiDisponibili = postiDisponibili + {$num}
                    WHERE v.id = '{$x["id"]}'";
            $res = $conn->query($update_query);

            $delete_query = "DELETE FROM viaggio_utente as vu WHERE vu.id = {$x["reser"]}";
            $res = $conn->query($delete_query);
        }

        $remove_query = "DELETE FROM agenzia as a WHERE a.email = '{$user_email}'";
        $res = $conn->query($remove_query);

        $remove_query = "DELETE FROM utente as u WHERE u.id = '{$user_id}'";
        $res = $conn->query($remove_query);

        echo ("<h3>User removed succesfully</h3>");
    }
    ?>
    <button onclick="location.href='../homepage_admin.php'">Go Back</button>
</body>
<footer>
    <hr>
    <a href="../index.php">HomePage</a>
</footer>

</html>