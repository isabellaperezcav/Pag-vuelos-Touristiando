<?php
    $cedula=$_POST["cedula"];
    $clave=$_POST["clave"];

    $servurl="http://localhost:3001/usuarios/$cedula/$clave";
    $curl=curl_init($servurl);

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response=curl_exec($curl);
    curl_close($curl);

    if ($response===false){
        echo "no logra ingresar";       
        header("Location:index.html");
    }

    $resp = json_decode($response);

    if (count($resp) != 0){
        session_start();
        $_SESSION["cedula"]=$cedula;
        echo "ingreso";
        if ($cedula == "2230603"){ 
            echo "2230603";
            header("Location:adminTour.php");
        } 
        else { 
            echo "$cedula";
            echo "no logra ingresar a hotel";
           header("Location:usuario-hotelTour.php");
        } 
    }
    else {
    header("Location:index.html"); 
    }

?>