const express = require('express');
const vuelosController = require('./controllers/vuelosController');
const morgan = require('morgan');
const app = express();
app.use(morgan('dev'));
app.use(express.json());

app.use(vuelosController);

app.listen(3003, () => {
    console.log('Microservicio Vuelos ejecutandose en el puerto 3003');
});