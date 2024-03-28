<?php
    session_start();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $usuario = $_POST['usuario'];
        $vuelos = $_POST['vuelos'];
        $cantidadVuelos = $_POST['cantidadVuelos'];
        $hoteles = $_POST['hoteles'];
        $cantidadHoteles = $_POST['cantidadHoteles'];

        // Validar que los campos no estén vacíos
        if (empty($usuario) || empty($vuelos) || empty($cantidadVuelos) || empty($hoteles) || empty($cantidadHoteles)) {
            echo "Error: Todos los campos son requeridos.";
            exit;
        }

        // Validar la cantidad de asientos y habitaciones
        if ($cantidadVuelos <= 0 || $cantidadHoteles <= 0) {
            echo "Error: La cantidad de asientos y habitaciones debe ser mayor que cero.";
            exit;
        }

        // Crear el objeto de datos a enviar a la API
        $datos = [
            'cedula' => $usuario,
            'items' => [
                [
                    'id_vuelo' => $vuelos,
                    'cantidad_vuelo' => $cantidadVuelos,
                    'id_hotel' => $hoteles,
                    'cantidad_hotel' => $cantidadHoteles,
                ]
            ]
        ];

        // Enviar los datos a la API de planViaje
        $urlApi = 'http://localhost:3004/planViaje';
        $curl = curl_init($urlApi);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($datos));
        curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        $response = curl_exec($curl);

        if ($response === false) {
            echo "Error al conectar con la API de planViaje: " . curl_error($curl);
        } else {
            $responseData = json_decode($response, true);
            if (isset($responseData['error'])) {
                echo "Error al procesar la solicitud: " . $responseData['error'];
            } else {
                echo "Plan de Viaje creado correctamente.";
                header("Location:usuario-hotelTour.php");
            }
        }

        curl_close($curl);
    } else {
        echo "Error: Método de solicitud no permitido.";
    }
    ?>