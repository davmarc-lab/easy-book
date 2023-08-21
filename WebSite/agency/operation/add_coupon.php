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
    if (isset($_SESSION["id"])) {
        PrintLoginInfo();
    }
    $conn = OpenCon();
    ?>
    <hr>
    <h3>Add Coupon</h3>
    <?php
    if (!isset($_POST["submit"])) {
    ?>
        <form action="<?php echo ($_SERVER["PHP_SELF"]); ?>" method="post" id="coupon_form">
            <table>
                <tr>
                    <td>Description:</td>
                    <td>
                        <textarea name="description" form="coupon_form" cols="40" rows="5" placeholder="Write a description here..."></textarea>
                    </td>
                </tr>
                <tr>
                    <td>Discount Code:</td>
                    <td>
                        <input type="text" name="code" placeholder="Discount code">
                    </td>
                </tr>
            </table>
            <p>If you leave 'Discount Code' field empty, the code will be generated automatically</p>
            <input type="submit" name="submit" value="Submit">
            <input type="reset" value="Clear">
        </form>
    <?php
    } else {
        $code = $_POST["code"];
        if (empty($code)) {
            // generate random discount code
            $length = 10;
            $code = "";
            for ($i = 0; $i < $length; $i++) {
                if (mt_rand(0, 1)) {
                    // letter
                    $char = chr(mt_rand(65, 90));
                } else {
                    // number
                    $char = chr(mt_rand(48, 57));
                }
                $code .= $char;
            }
            echo ($code);
        }

        $insert_query = "INSERT INTO coupon (codiceSconto, descrizione, id_agenzia)
                VALUES ('{$code}', '{$_POST["description"]}', {$_SESSION["agency_id"]});";
        $res = $conn->query($insert_query);
        header("location:../info_agency.php?agency={$_SESSION["agency"]}");
    }

    // for the go back link
    $agency_name = str_replace(' ', '+', $_SESSION["agency"]);
    echo ("<button onclick=\"location.href='../info_agency.php?agency={$agency_name}'\">Go back</button>");
    ?>
</body>
<footer>
    <hr>
    <a href="../../index.php">HomePage</a>
</footer>

</html>