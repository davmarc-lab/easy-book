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
            ?>
                <div class="login">
                    <?php
                        echo ("Hello ".$_SESSION["name"]." | <a href=\"../homepage_agency.php\">Agencies</a> | <a href=\"../user/logout.php\">Logout</a>");
                    ?>
                </div>
            <?php
        }
    ?>
    <hr>
    <h3>Organize the travel</h3>

    <form action="" method="post" id="">
        <table>
            <tr>
                <td>Departure date:</td>
                <td>
                    <input type="date" name="departure" placeholder="Departure date">
                </td>
            </tr>
            <tr>
                <td>Return date:</td>
                <td>    
                    <input type="date" name="return" placeholder="Return date">
                </td>
            </tr>
            <tr>
                <td>Price per person:</td>
                <td>
                    <input type="number" name="price" placeholder="Price per person">
                </td>
            </tr>
        </table>

        <h3>Transport</h3>
        <table>
            <tr>
                <td>Select transport:</td>
                <td>
                    <table>
                        <?php
                            $trs_query = 'SELECT * FROM mezzo as m WHERE m.id_agenzia = \''.$_SESSION["agency_id"].'\'';
                            $trs = $conn -> query($trs_query);
                            
                            foreach ($trs as $x) {
                                echo("<tr>");
                                echo("<td>");
                                echo(($x["id"].'-'.$x["tipo"].'-'.$x["annoImmatricolazione"].'-'.$x["postiDisponibili"]));
                                echo("</td>");
                                echo("<td>");
                                echo("<input type=\"checkbox\" name=\"transport[]\" value=\"{$x["id"]}\">");
                                echo("</td>");
                                echo("</tr>");
                            }
                        ?>
                    </table>
                    
                </td>
            </tr>
        </table>

        <button name="submit">Send</button>
        <input type="reset" value="Clear">
    </form>
    <br>
    <?php
        // for the go back link
        $agency_name = str_replace(' ', '+', $_SESSION["agency"]);
        echo("<button onclick=\"location.href='../info_agency.php?agency={$agency_name}'\">Go back</button>");
    ?>
</body>
<footer>
    <hr>
    <a href="../../index.php">HomePage</a>
</footer>
</html>