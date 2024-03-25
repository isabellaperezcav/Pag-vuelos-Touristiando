const express = require('express');
const morgan = require('morgan');
const facturasController = require('./controllers/planViajeController');

const app = express();
app.use(morgan('dev'));
app.use(express.json());

// Punto de montaje para las rutas del controlador de facturas
app.use('/planViaje', facturasController);

const PORT = 3004;
app.listen(PORT, () => {
    console.log(`Microservicio Plan de Viaje escuchando en el puerto ${PORT}`);
});
