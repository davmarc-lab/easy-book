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
    PrintLoginInfo();
    ?>
    <hr>
    <h3>Removing Employee</h3>
    <?php
    $conn = OpenCon();
    $uemail = $_POST["email"];
    echo ("<b>Are you sure you want to remove <txt style=\"color: red\">" . $uemail . "</txt>? He would not be able to manage your agency anymore.</b><br><br>");
    $agency_name = str_replace(' ', '+', $_SESSION["agency"]);
    echo ("<form action=\"remove.php\" method=\"post\">
            <button type=\"submit\" name=\"uemail\" value=\"{$uemail}\" style=\"color: red;\">Remove</button>
            </form>");
    echo ("<button onclick=\"location.href='../info_agency.php?agency={$agency_name}'\">Go back</button>");
    ?>

</body>
<footer>
    <hr>
    <a href="../index.php">HomePage</a>
</footer>

</html>