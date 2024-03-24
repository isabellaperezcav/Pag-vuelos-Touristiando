const mysql = require('mysql2/promise');

const connection = mysql.createPool({
    host: 'localhost',
    user: 'root',
    password: '',
    database: 'touristiando'
});

// Funciones CRUD para Hoteles directamente accesibles por los usuarios
async function traerHoteles() {
    const result = await connection.query('SELECT * FROM hoteles');
    return result[0];
}

async function traerHotel(id) {
    const result = await connection.query('SELECT * FROM hoteles WHERE id = ?', [id]);
    return result[0];
}

async function crearHotel(nombre, ciudad, capacidad, costo) {
    const result = await connection.query('INSERT INTO hoteles VALUES(null,?,?,?,?)', [nombre, ciudad, capacidad, costo]);
    return result;
}

async function actualizarHotel(id, nombre, ciudad, capacidad, costo) {
    const result = await connection.query('UPDATE hoteles SET nombre = ?, ciudad = ?, capacidad = ?, costo = ? WHERE id = ?', [nombre, ciudad, capacidad, costo, id]);
    return result;
}

async function eliminarHotel(id) {
    const result = await connection.query('DELETE FROM hoteles WHERE id = ?', [id]);
    return result;
}

module.exports = { traerHoteles, traerHotel, crearHotel,actualizarHotel, eliminarHotel };