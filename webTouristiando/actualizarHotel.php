<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del formulario
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $ciudad = $_POST['ciudad'];
    $capacidad = $_POST['capacidad'];
    $costo = $_POST['costo'];

    // Crear el array con los datos a enviar a la API
    $data = array(
        'nombre' => $nombre,
        'ciudad' => $ciudad,
        'capacidad' => $capacidad,
        'costo' => $costo
    );

    // Convertir el array a formato JSON
    $payload = json_encode($data);

    // URL de la API para actualizar un hotel
    $url = "http://localhost:3002/hoteles/{$id}";

    // Iniciar la sesión cURL
    $curl = curl_init($url);

    // Configurar las opciones de la solicitud cURL
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($curl, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($payload)
    ));

    // Ejecutar la solicitud cURL y obtener la respuesta
    $response = curl_exec($curl);

    // Verificar si la solicitud fue exitosa
    if ($response === false) {
        $error = curl_error($curl);
        echo "Error en la conexión: " . $error;
    } else {
        header("Location:admin-hotelTour.php");
    }

    // Cerrar la sesión cURL
    curl_close($curl);
} else {
    // Redirigir si se intenta acceder directamente a esta página
    header("Location: admin-hotelTour.php");
}
?>