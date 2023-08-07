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
        $contents = preg_replace('/\s+/', '', $contents);
        return $contents;
    }

    function RandTel($num) {
        $pre = rand(1, 99);
        $res = "";
        for ($i = 0; $i < $num; $i++) {
            $res .= strval(rand(0, 9));
        }
        return '+'.strval($pre).' '.$res;
    }

    function RandPass() {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }

    function RandYear() {
        return rand(1980, 2023);
    }
?>