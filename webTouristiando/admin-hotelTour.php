<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <title>Admin Touristiando</title>
</head>
<body>
    <?php
        session_start();
        $us=$_SESSION["cedula"];
        if ($us==""){
            header("Location: index.html");
        }
    ?>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="adminTour.php">Proyecto Touristiando</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarText">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="adminTour.php">Usuarios</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="admin-vueloTour.php">Vuelos</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="admin-hotelTour.php">Hoteles</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="admin-planViajeTour.php">Facturas planes de viaje</a>
            </li>
        </ul>
        <span class="navbar-text">
            <?php echo "<a class='nav-link' href='logoutTour.php'>Logout $us</a>" ;?>
        </span>
        </div>
    </div>
    </nav>

    <table class="table">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Nombre</th>
                <th scope="col">Ciudad</th>
                <th scope="col">Capacidad</th>
                <th scope="col">Costo</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $servurl = "http://localhost:3002/hoteles";
            $curl = curl_init($servurl);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($curl);
            if ($response === false) {
                curl_close($curl);
                die ("Error en la conexión");
            }
            curl_close($curl);
            $resp = json_decode($response);
            $long = count($resp);
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
                        <?php echo $id; ?>
                    </td>
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
                    <!-- Agregar botón para actualizar hotel -->
<td><button class='btn btn-primary' onclick='mostrarModalActualizar(<?php echo $id; ?>, "<?php echo $nombre; ?>", "<?php echo $ciudad; ?>", "<?php echo $capacidad; ?>", "<?php echo $costo; ?>")'>Actualizar</button></td>

                    <td><button class='btn btn-danger' onclick='eliminarHotel(<?php echo $id; ?>)'>Eliminar</button>
                    </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>

    <!-- Modal de actualización -->
<div class="modal fade" id="updateModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Actualizar Hotel</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="actualizarHotel.php" method="post">
                    <input type="hidden" name="id" id="updateId">
                    <div class="mb-3">
                        <label for="updateNombre" class="form-label">Nombre Hotel</label>
                        <input type="text" name="nombre" class="form-control" id="updateNombre" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="updateCiudad" class="form-label">Ciudad</label>
                        <input type="text" name="ciudad" class="form-control" id="updateCiudad" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="updateCapacidad" class="form-label">Capacidad</label>
                        <input type="text" name="capacidad" class="form-control" id="updateCapacidad" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="updateCosto" class="form-label">Costo</label>
                        <input type="text" name="costo" class="form-control" id="updateCosto" aria-describedby="emailHelp">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Actualizar Hotel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
        Crear Hotel
    </button>


    <div class="modal fade" id="exampleModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Crear Hotel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="crearHotelTour.php" method="post">
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Nombre Hotel</label>
                            <input type="text" name="nombre" class="form-control" id="exampleInputEmail1"
                                aria-describedby="emailHelp">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Ciudad</label>
                            <input type="text" name="ciudad" class="form-control" id="exampleInputEmail1"
                                aria-describedby="emailHelp">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Capacidad</label>
                            <input type="text" name="capacidad" class="form-control" id="exampleInputEmail1"
                                aria-describedby="emailHelp">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Costo</label>
                            <input type="text" name="costo" class="form-control" id="exampleInputEmail1"
                                aria-describedby="emailHelp">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Crear Hotel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function eliminarHotel(id) {
            if (confirm("¿Estás seguro de eliminar este hotel?")) {
                window.location.href = "eliminarHotelTour.php?id=" + id;
            }
        }

        function mostrarModalActualizar(id, nombre, ciudad, capacidad, costo) {
        // Llenar los campos del formulario de actualización con los datos del hotel
        document.getElementById('updateId').value = id;
        document.getElementById('updateNombre').value = nombre;
        document.getElementById('updateCiudad').value = ciudad;
        document.getElementById('updateCapacidad').value = capacidad;
        document.getElementById('updateCosto').value = costo;

        // Mostrar el modal de actualización
        var myModal = new bootstrap.Modal(document.getElementById('updateModal'));
        myModal.show();
    }
    </script>
</body>

</html>