<?php
    function RandSource($filename) {
        $f = fopen($filename, 'r');
        $max = fgets($f);
        $n = rand(1, $max);
        $i = 1;
        while (!feof($f)) {
            $contents = fgets($f);
            if ($i == $n) {
                break;
            }
            $i++;
        }
        return $contents;
    }

    function RandTel($num) {
        $res = "";
        // non concatena
        for ($i = 0; $i < $n; $i++) {
            if ($res == "")
                $res = rand(1, 10);
            else
                $res = $res.rand(1, 10);
            echo($res);
        }
        $ret = "+39 ".$res;
        return $ret;
    }
?>