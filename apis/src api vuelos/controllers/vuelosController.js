const { Router } = require('express');
const router = Router();
const vuelosModel = require('../models/vuelosModel');

// Rutas para manipulación directa de vuelos
router.get('/vuelos', async (req, res) => {
    const result = await vuelosModel.traerVuelos();
    res.json(result);
});

router.get('/vuelos/:id', async (req, res) => {
    const { id } = req.params;
    const result = await vuelosModel.traerVuelo(id);
    res.json(result[0]);
});

router.post('/vuelos', async (req, res) => {
    const { ciudadOrigen, ciudadDestino, capacidad, costo } = req.body;
    const result = await vuelosModel.crearVuelo(ciudadOrigen, ciudadDestino, capacidad, costo);
    res.send("Vuelo creado exitosamente");
});

router.put('/vuelos/:id', async (req, res) => {
    const { id } = req.params;
    const { ciudadOrigen, ciudadDestino, capacidad, costo } = req.body;

    try {
        await vuelosModel.actualizarVuelo(id, ciudadOrigen, ciudadDestino, capacidad, costo);

        res.send("Vuelo actualizado exitosamente");
    } catch (error) {
        console.error(error);
        res.status(500).send("Error al actualizar Vuelo");
    }
});

router.delete('/vuelos/:id', async (req, res) => {
    const { id } = req.params;

    try {
        await vuelosModel.eliminarVuelo(id);

        res.send("Vuelo eliminado exitosamente");
    } catch (error) {
        console.error(error);
        res.status(500).send("Error al eliminar Vuelo");
    }
});


module.exports = router;