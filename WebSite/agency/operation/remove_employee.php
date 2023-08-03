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
    <h3>Removing Employee</h3>
    <?php 
        session_start();

        echo($_SESSION["agency"]); ?>
    <?php echo("<b>Are you sure you want to remove <txt style=\"color: red\">".$_POST["email"]."</txt>? He would not be able to manage your agency anymore.</b><br>"); ?>
    <button onclick="" style="color: red;">Remove</button>
    <?php
        $agency_name = str_replace(' ', '+', $_SESSION["agency"]); 
        echo("<button onclick=\"location.href='../info_agency.php?agency={$agency_name}'\">Go back</button>");
    ?>
    
</body>
<footer>
    <hr>
    <a href="../index.php">HomePage</a>
</footer>
</html>