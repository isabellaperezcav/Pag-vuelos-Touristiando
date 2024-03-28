const express = require('express');
const router = express.Router();
const axios = require('axios');
const facturasModel = require('../models/planViajeModel');

router.get('/:id', async (req, res) => {
    const id_factura = req.params.id;
    var result;
    result = await facturasModel.traerfactura(id_factura);
    res.json(result[0]);
});

router.get('/', async (req, res) => {
    var result;
    result = await facturasModel.traerfacturas();
    res.json(result);
});

router.post('/', async (req, res) => {
    const cedula = req.body.cedula;
    const items = req.body.items;

    const costo = await calcularTotal(items);

    // Si el total es 0 o negativo, retornamos un error
    if (costo <= 0) {
        return res.json({ error: 'Invalid order total' });
    }

    // Verificamos si hay suficientes unidades de los productos para realizar la orden
    const disponibilidad = await verificarDisponibilidad(items);
    if (!disponibilidad) {
        return res.json({ error: 'No hay disponibilidad de productos' });
    }

    // Creamos la orden
    const responseUsuario = await axios.get(`http://localhost:3001/usuarios/${cedula}`);
    const nombreUsuario = responseUsuario.data.nombre;
    console.log(nombreUsuario);

    // Obtenemos el nombre del hotel y la ciudad
    const responseHotel = await axios.get(`http://localhost:3002/hoteles/${items[0].id_hotel}`);
    const nombreHotel = responseHotel.data.nombre;
    const ciudadHotel = responseHotel.data.ciudad; // Corregido para obtener la ciudad del hotel

    // Obtenemos la ciudad de origen y destino del vuelo
    const responseVuelo = await axios.get(`http://localhost:3003/vuelos/${items[0].id_vuelo}`);
   
    const nombreVuelo = `Vuelo desde ${responseVuelo.data.ciudadOrigen} a ${responseVuelo.data.ciudadDestino}`;

    // Creamos el objeto orden
    const orden = {
        usuario: nombreUsuario,
        ciudad: ciudadHotel,
        vuelo: nombreVuelo,
        hotel: nombreHotel,
        costo: costo,
    };

    // Creamos la factura
    const ordenRes = await facturasModel.crearfactura(orden);

    // Disminuimos la cantidad de unidades de los productos en el inventario
    await actualizarInventario(items);

    return res.send(`Plan de Viaje creado para ${nombreUsuario} en el hotel ${nombreHotel}`);
});


// Función para calcular el total de la orden
async function calcularTotal(items) {

    let totalCuenta = 0;

    for (const item of items) {
        const responseHotel = await axios.get(`http://localhost:3002/hoteles/${item.id_hotel}`);
        const responseVuelo = await axios.get(`http://localhost:3003/vuelos/${item.id_vuelo}`);

        const costoHotel = responseHotel.data.costo;
        const cantidadHotel = item.cantidad_hotel;
        const costoVuelo = responseVuelo.data.costo;
        const cantidadVuelo = item.cantidad_vuelo;


        totalCuenta += (costoHotel * cantidadHotel) + (costoVuelo * cantidadVuelo);
    }

    return totalCuenta;
}


// Función para verificar si hay suficientes unidades de los productos para realizar la orden
async function verificarDisponibilidad(items) {
    let disponibilidad = true;

    for (const item of items) {
        const responseHotel = await axios.get(`http://localhost:3002/hoteles/${item.id_hotel}`);
        const responseVuelo = await axios.get(`http://localhost:3003/vuelos/${item.id_vuelo}`);

        if (!responseHotel || !responseVuelo) {
            disponibilidad = false;
            break;
        }

        const cantidadHotelDisponible = responseHotel.data.capacidad 
        const cantidadVueloDisponible = responseVuelo.data.capacidad 

        if (item.cantidad_hotel > cantidadHotelDisponible || item.cantidad_vuelo > cantidadVueloDisponible) {
            disponibilidad = false;
            break;
        }
    }

    return disponibilidad;
}


// Función para disminuir la cantidad de unidades de los productos en el inventario de Hoteles y Vuelos
async function actualizarInventario(items) {
    for (const item of items) {
        const responseHotel = await axios.get(`http://localhost:3002/hoteles/${item.id_hotel}`);
        const responseVuelo = await axios.get(`http://localhost:3003/vuelos/${item.id_vuelo}`);

        const capacidadActualizadaHotel = responseHotel.data.capacidad - item.cantidad_hotel;
        const cantidadVueloActual = responseVuelo.data.capacidad - item.cantidad_vuelo;

        await axios.put(`http://localhost:3002/hoteles/${item.id_hotel}`, {
            ...responseHotel.data,
            capacidad: capacidadActualizadaHotel,
        });

        await axios.put(`http://localhost:3003/vuelos/${item.id_vuelo}`, {
            ...responseVuelo.data,
            capacidad: cantidadVueloActual,
        });
    }
}

module.exports = router;