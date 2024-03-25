const mysql = require('mysql2/promise');

const connection = mysql.createPool({
    host: 'localhost',
    user: 'root',
    password: '',
    database: 'touristiando',
});

async function crearfactura(orden) {
    const usuario = orden.usuario;
    const hotel = orden.hotel;
    const vuelo = orden.vuelo;
    const costo = orden.costo;
    const ciudad = orden.ciudad;

    const result = await connection.query('INSERT INTO planViaje (usuario, hotel, vuelo, costo, ciudad) VALUES (?, ?, ?, ?, ?)', [usuario, hotel, vuelo, costo, ciudad]);
    return result;
}

async function traerfactura(id_factura) {
    const result = await connection.query('SELECT * FROM planViaje WHERE id = ? ', id_factura);
    return result[0];
}

async function traerfacturas() {
    const result = await connection.query('SELECT * FROM planViaje');
    return result;
}

module.exports = {
    crearfactura,
    traerfacturas,
    traerfactura,
};