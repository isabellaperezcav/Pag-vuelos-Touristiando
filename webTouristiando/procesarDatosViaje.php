<?php
// Verificar si se ha enviado un formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recibir los datos del formulario
    $usuario = $_POST['usuario'];
    $vuelos = $_POST['vuelos'];
    $cantidadVuelos = $_POST['cantidadVuelos'];
    $hoteles = $_POST['hoteles'];
    $cantidadHoteles = $_POST['cantidadHoteles'];

    // Validar los campos
    $errores = [];
    if (empty($usuario) || empty($vuelos) || empty($cantidadVuelos) || empty($hoteles) || empty($cantidadHoteles)) {
        $errores[] = "Todos los campos son requeridos.";
    }
    if ($cantidadVuelos <= 0 || $cantidadHoteles <= 0) {
        $errores[] = "La cantidad de asientos y habitaciones debe ser mayor que cero.";
    }

    // Si hay errores, mostrarlos y detener el proceso
    if (!empty($errores)) {
        foreach ($errores as $error) {
            echo $error . "<br>";
        }
        exit;
    }

    // Crear el objeto de datos a enviar a la API
    $datos = [
        'cedula' => $usuario,
        'items' => [
            [                
                'id_hotel' => $hoteles,
                'cantidad_hotel' => $cantidadHoteles,
                'id_vuelo' => $vuelos,
                'cantidad_vuelo' => $cantidadVuelos,
            ]
        ]
    ];

    // Enviar los datos a la API de planViaje
    $urlApi = 'http://192.168.100.2:3004/planViaje';
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
            header("Location: indexGene.php");
        }
    }

    curl_close($curl);
} else {
    // Si se intenta acceder directamente a este archivo sin enviar un formulario, redirigir a una página de error o a otra página según tu flujo de la aplicación
    header("Location: error.php");
    exit;
}
?>
