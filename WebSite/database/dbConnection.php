<?php
    function OpenCon() {
        $conn = new mysqli("127.0.0.1", "root", "password", "easybook") or die("Connection failed: %s\n". $conn -> error);
        return $conn;
    }

    function CloseCon() {
        $conn -> close();
    }
    
?>