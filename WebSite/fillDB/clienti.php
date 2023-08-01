<?php
    include_once("database/dbConnection.php");
    include("inserisci.php");

    $conn = OpenCon();
    for ($i = 0; $i < 10; $i++) {        

        // $name = RandSource('fillDB/name.txt');   
        // $surname = RandSource('fillDB/surname.txt');
        // $tel = RandTel(10);
        // $progressive_query = 'SELECT * FROM cliente AS c WHERE c.cognome = \''.$surname.'\'';
        // $res = $conn -> query($progressive_query);
        // $n = $res -> num_rows;
        // echo $n;
        // $email = $n == 0 ? $name.'.'.$surname.'@mail.it' : $name.'.'.$surname.$n.'@mail.it';
        // $email = strtolower(preg_replace('/\s+/', '', $email));
        // $pass = RandPass();
        // $pass = password_hash($pass, PASSWORD_DEFAULT);
        // echo($name.' '.$surname.' '.$tel.' '.$email.' '.$pass.' ');
        // // information prepared successfully
        // $insert_query = 'INSERT INTO cliente (nome, cognome, telefono, email, password)
        //         VALUES(\''.$name.'\', \''.$surname.'\', \''.$tel.'\', \''.$email.'\', \''.$pass.'\')';
        // $res = $conn -> query($insert_query);        
    }

    // $f = fopen('fillDB/agency.txt', 'r');
    // $n = fgets($f);
    // $ar = array();
    // while (!feof($f)) {
    //     $ag = preg_replace('/\s+/', '', fgets($f));
    //     $ag = str_replace('_', ' ', $ag);
    //     array_push($ar, $ag);
    // }
    // fclose($f);
    // shuffle($ar);
    // foreach($ar as $x) {
    //     $name = RandSource('fillDB//name.txt');   
    //     $surname = RandSource('fillDB//surname.txt');
    //     $tel = RandTel(10);
    //     $city = RandSource('fillDB//city.txt');
    //     $city = str_replace('_', ' ', $city);
    //     $pr = explode(":", $city);
    //     $city = $pr[0];
    //     $email = $name.'.'.$surname.'@mail.it';
    //     $email = strtolower(preg_replace('/\s+/', '', $email));
    //     // $insert_query = 'INSERT INTO agenzia (nome, proprietario, sedeFisica, telefono, email)
    //     //         VALUES(\''.$x.'\', \''.$name.' '.$surname.'\', \''.$city.'\', \''.$tel.'\', \''.$email.'\')';
    //     // $res = $conn -> query($insert_query);
    //     echo($name.' '.$surname.' '.$tel.' '.$email.' '.$x.' '.$city.'; ');
    // }

    // $f = fopen('fillDB/city.txt', 'r');
    // $n = fgets($f);
    // while (!feof($f)) {
    //     $arcity = preg_replace('/\s+/', '', fgets($f));
    //     $arcity = str_replace('_', ' ', $arcity);
    //     $parts = explode(":", $arcity);
    //     $city = $parts[0];
    //     $state = $parts[1];
    //     $cont = $parts[2];
    //     echo($city.' '.$state.' '.$cont);
    //     $insert_query = 'INSERT INTO localita (nome, stato, continente)
    //             VALUES(\''.$city.'\', \''.$state.'\', \''.$cont.'\')';
    //     $res = $conn -> query($insert_query);
    // }
    // fclose($f);
?>