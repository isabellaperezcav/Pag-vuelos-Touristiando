const { Router } = require('express');
const router = Router();
const hotelesModel = require('../models/hotelesModel');

// Rutas para manipulación directa de hoteles
router.get('/hoteles', async (req, res) => {
    const result = await hotelesModel.traerHoteles();
    res.json(result);
});

router.get('/hoteles/:id', async (req, res) => {
    const { id } = req.params;
    const result = await hotelesModel.traerHotel(id);
    res.json(result[0]);
});

router.post('/hoteles', async (req, res) => {
    const { nombre, ciudad, capacidad, costo } = req.body;
    const result = await hotelesModel.crearHotel(nombre, ciudad, capacidad, costo);
    res.send("Hotel creado exitosamente");
});

router.put('/hoteles/:id', async (req, res) => {
    const { id } = req.params;
    const { nombre, ciudad, capacidad, costo } = req.body;

    try {
        await hotelesModel.actualizarHotel(id, nombre, ciudad, capacidad, costo);

        res.send("Hotel actualizado exitosamente");
    } catch (error) {
        console.error(error);
        res.status(500).send("Error al actualizar hotel");
    }
});

router.delete('/hoteles/:id', async (req, res) => {
    const { id } = req.params;

    try {
        await hotelesModel.eliminarHotel(id);

        res.send("Hotel eliminado exitosamente");
    } catch (error) {
        console.error(error);
        res.status(500).send("Error al eliminar Hotel");
    }
});


module.exports = router;