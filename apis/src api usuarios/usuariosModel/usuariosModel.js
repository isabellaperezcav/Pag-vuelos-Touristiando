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