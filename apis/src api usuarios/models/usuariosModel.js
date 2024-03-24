const mysql = require('mysql2/promise');
const connection = mysql.createPool({
    host: 'localhost',
    user: 'root',
    password: '',
    database: 'touristiando'
});
async function traerUsuarios() {
    const result = await connection.query('SELECT * FROM usuarios');
    return result[0];
}
async function traerUsuario(cedula) {
    const result = await connection.query('SELECT * FROM usuarios WHERE cedula = ? ', cedula);
    return result[0];
}

async function validarUsuario(cedula, clave) {
    const result = await connection.query('SELECT * FROM usuarios WHERE cedula = ? AND clave = ?', [cedula, clave]);
    return result[0];
}

async function crearUsuario(nombre, cedula, correo, clave) {
    const result = await connection.query('INSERT INTO usuarios VALUES(?,?,?,?)', [nombre, cedula, correo, clave]);
    return result;
}

async function actualizarUsuario(cedula, nombre, correo, clave) {
  const result = await connection.query(
      'UPDATE usuarios SET nombre = ?, correo = ?, clave = ? WHERE cedula = ?',
      [nombre, correo, clave, cedula]
  );
  return result[0];
}

module.exports = {
    traerUsuarios, traerUsuario, validarUsuario, crearUsuario, actualizarUsuario
};
