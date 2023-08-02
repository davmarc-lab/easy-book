<?php
    function OpenCon() {
        $conn = new mysqli("127.0.0.1", "root", "password", "easybook") or die("Connection failed: %s\n". $conn -> error);
        return $conn;
    }

    function CloseCon() {
        $conn -> close();
    }

    function PrintLoginInfo() {
        $conn = OpenCon();
        if (isset($_SESSION["id"])) {
            echo ("<div class=\"login\">Hello ".$_SESSION["name"]." | <a href=\"user/logout.php\">Logout</a>");

            $admin_query = 'SELECT u.id AS id FROM amministratore AS a, utente AS u WHERE u.id = a.id_utente AND a.dataRitiro IS NULL;';
            $res = $conn -> query($admin_query);
            $x = $res -> fetch_array();
            $admin = $x["id"];
            if ($admin == $_SESSION["id"]) {
                echo(" | <a href=\"admin/homepage_admin.php\">Admin</a>");
            }

            $agency_query = 'SELECT u.id AS id FROM agenzia AS a, utente AS u WHERE u.email = a.email';
            $res = $conn -> query($agency_query);
            $x = $res -> fetch_array();
            $agency = $x["id"];
            if ($agency == $_SESSION["id"]) {
                echo(" | <a href=\"agency/homepage_agency.php\">Agency</a>");
            }
            echo("</div>");
        } else {
            echo("<div class=\"login\"><a href=\"user/login.php\">Login</a> | <a href=\"user/register.php\">Sign Up</a></div>");
        }
    }
?>