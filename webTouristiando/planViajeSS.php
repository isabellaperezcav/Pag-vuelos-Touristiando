<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>
    <title>Proyecto Touristiando</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="usuario-hotelTour.php">Proyecto Touristiando</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText"
                aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarText">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="indexGene.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.html">Iniciar sesión</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="planViajeSS.php">Crear Plan de Viaje</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <form method="post" action="procesarDatosViaje.php">
        <!-- Campo de cédula -->
        <div class="mb-3">
            <label for="usuario" class="form-label">Cédula:</label>
            <input type="text" name="usuario" id="usuario" class="form-control" required>
        </div>
        <!-- Selección de vuelos -->
        <div class="mb-3">
            <label for="vuelos" class="form-label">Seleccione un vuelo:</label>
            <select name="vuelos" id="vuelos" class="form-select" required>
                <?php
                // Obtener datos de la API de vuelos
                $urlVuelos = 'http://192.168.100.2:3003/vuelos';
                $responseVuelos = file_get_contents($urlVuelos);
                $vuelos = json_decode($responseVuelos, true);

                // Mostrar opciones de vuelos en el select
                foreach ($vuelos as $vuelo) {
                    echo "<option value='{$vuelo['id']}'>{$vuelo['ciudadOrigen']} - {$vuelo['ciudadDestino']}</option>";
                }
                ?>
            </select>
        </div>
        <!-- Cantidad de asientos para el vuelo -->
        <div class="mb-3">
            <label for="cantidadVuelos" class="form-label">Cantidad de asientos:</label>
            <input type="number" name="cantidadVuelos" id="cantidadVuelos" class="form-control" min="1" required>
        </div>
        <!-- Selección de hoteles -->
        <div class="mb-3">
            <label for="hoteles" class="form-label">Seleccione un hotel:</label>
            <select name="hoteles" id="hoteles" class="form-select" required>
                <?php
                // Obtener datos de la API de hoteles
                $urlHoteles = 'http://192.168.100.2:3002/hoteles';
                $responseHoteles = file_get_contents($urlHoteles);
                $hoteles = json_decode($responseHoteles, true);

                // Mostrar opciones de hoteles en el select
                foreach ($hoteles as $hotel) {
                    echo "<option value='{$hotel['id']}'>{$hotel['nombre']}</option>";
                }
                ?>
            </select>
        </div>
        <!-- Cantidad de habitaciones en el hotel -->
        <div class="mb-3">
            <label for="cantidadHoteles" class="form-label">Cantidad de habitaciones:</label>
            <input type="number" name="cantidadHoteles" id="cantidadHoteles" class="form-control" min="1" required>
        </div>
        <!-- Botón de enviar -->
        <button type="submit" class="btn btn-primary">Crear factura</button>
    </form>
</body>

</html>