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
    <h5>hola mundo, esta es la pagina de touristiando, le invitamos a iniciar sesion para crear un plan de viaje, puede
        ver los hoteles y los vuelos disponibles aqui abajo</h5>


    <h1>Hoteles Disponibles</h1>
    <table class="table">
        <thead>
            <tr>

                <th scope="col">Nombre</th>
                <th scope="col">Ciudad</th>
                <th scope="col">capacidad</th>
                <th scope="col">Costo</th>

            </tr>
        </thead>
        <tbody>
            <?php
            $servurl = "http://192.168.100.2:3002/hoteles";
            $curl = curl_init($servurl);

            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($curl);

            if ($response === false) {
                curl_close($curl);
                die("Error en la conexion");
            }

            curl_close($curl);
            $resp = json_decode($response);
            $long = count($resp);
            //echo '<form method="post" action="procesar.php">';
            for ($i = 0; $i < $long; $i++) {
                $dec = $resp[$i];
                $id = $dec->id;
                $nombre = $dec->nombre;
                $ciudad = $dec->ciudad;
                $capacidad = $dec->capacidad;
                $costo = $dec->costo;
                ?>

                <tr>
                    <td>
                        <?php echo $nombre; ?>
                    </td>
                    <td>
                        <?php echo $ciudad; ?>
                    </td>
                    <td>
                        <?php echo $capacidad; ?>
                    </td>
                    <td>
                        <?php echo $costo; ?>
                    </td>
                </tr>

            <?php } ?>


        </tbody>
    </table>

    <h1>Vuelos Disponibles</h1>
    <table class="table">
        <thead>
            <tr>

                <th scope="col">ciudad origen</th>
                <th scope="col">Ciudad destino</th>
                <th scope="col">capacidad</th>
                <th scope="col">Costo</th>

            </tr>
        </thead>
        <tbody>
            <?php
            $servurl = "http://192.168.100.2:3003/vuelos";
            $curl = curl_init($servurl);

            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($curl);

            if ($response === false) {
                curl_close($curl);
                die("Error en la conexion");
            }

            curl_close($curl);
            $resp = json_decode($response);
            $long = count($resp);
            //echo '<form method="post" action="procesar.php">';
            for ($i = 0; $i < $long; $i++) {
                $dec = $resp[$i];
                $id = $dec->id;
                $ciudadOrigen = $dec->ciudadOrigen;
                $ciudadDestino = $dec->ciudadDestino;
                $capacidad = $dec->capacidad;
                $costo = $dec->costo;
                ?>

                <tr>
                    <td>
                        <?php echo $ciudadOrigen; ?>
                    </td>
                    <td>
                        <?php echo $ciudadDestino; ?>
                    </td>
                    <td>
                        <?php echo $capacidad; ?>
                    </td>
                    <td>
                        <?php echo $costo; ?>
                    </td>
                </tr>

            <?php } ?>


        </tbody>
    </table>

</body>

</html>