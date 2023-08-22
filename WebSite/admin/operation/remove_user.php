<!DOCTYPE html>
<html>

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
    <h3>Are you sure you want to remove this user?</h3>
    <table>
        <!-- user information -->
    </table>
    <!-- WHEN DELETED UPDATE ALL THE RESERVATION ON FROM VIAGGIO_UTENTE -->
</body>
<footer>
    <hr>
    <a href="../index.php">HomePage</a>
</footer>

</html>