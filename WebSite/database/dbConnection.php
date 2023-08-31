<?php
$HOME_FOLDER = "/easy-book/WebSite/";

function OpenCon()
{
    $conn = new mysqli("127.0.0.1", "root", "password", "easycopy") or die("Connection failed: %s\n" . $conn->error);
    return $conn;
}

function CloseCon()
{
    global $conn;
    $conn->close();
}

function PrintLoginInfo()
{
    global $HOME_FOLDER;
    $conn = OpenCon();
    if (isset($_SESSION["id"])) {
        echo ("<div class=\"login\">Hello <a href='{$HOME_FOLDER}user/info_user.php'>{$_SESSION["name"]}</a> | <a href=\"{$HOME_FOLDER}user/logout.php\">Logout</a>");

        $admin_query = 'SELECT u.id AS id FROM amministratore AS a, utente AS u WHERE u.id = a.id_utente AND a.dataRitiro IS NULL;';
        $res = $conn->query($admin_query);
        $x = $res->fetch_array();
        $admin = $x["id"];
        if ($admin == $_SESSION["id"]) {
            echo (" | <a href=\"{$HOME_FOLDER}admin/homepage_admin.php\">Admin</a>");
        }

        $agency_query = "SELECT a.id FROM agenzia as a
                WHERE a.id_utente = '{$_SESSION["id"]}';";
        $res = $conn->query($agency_query);
        if ($res->num_rows > 0) {
            echo (" | <a href=\"{$HOME_FOLDER}agency/homepage_agency.php\">Agency</a>");
        }
        echo ("</div>");
    } else {
        echo ("<div class=\"login\"><a href=\"{$HOME_FOLDER}user/login.php\">Login</a> | <a href=\"{$HOME_FOLDER}user/register.php\">Sign Up</a></div>");
    }
}
