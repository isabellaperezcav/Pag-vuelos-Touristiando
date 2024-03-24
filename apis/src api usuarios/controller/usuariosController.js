const { Router } = require('express');
const router = Router();
const usuariosModel = require('../models/usuariosModel');

router.get('/usuarios', async (req, res) => {
    var result;
    result = await usuariosModel.traerUsuarios();
    res.json(result);
});

router.get('/usuarios/:cedula', async (req, res) => {
    const cedula = req.params.cedula;
    var result;
    result = await usuariosModel.traerUsuario(cedula);
    res.json(result[0]);
});

router.get('/usuarios/:cedula/:clave', async (req, res) => {
    const cedula = req.params.cedula;
    const clave = req.params.clave;
    var result;
    result = await usuariosModel.validarUsuario(cedula, clave);
    res.json(result);
});

router.post('/usuarios', async (req, res) => {
    const nombre = req.body.nombre;
    const cedula = req.body.cedula;
    const correo = req.body.correo;
    const clave = req.body.clave;
    var result = await usuariosModel.crearUsuario(nombre, cedula, correo, clave);
    res.send("usuario creado");
});

router.put('/usuarios/:cedula', async (req, res) => {
  const cedula = req.params.cedula;
  const { nombre, correo, clave } = req.body;
  
  // Verificar si se intenta modificar la cédula en la solicitud
  if (req.body.cedula) {
      return res.status(400).json({ message: 'No se puede modificar la cédula.' });
  }

  // Verificar si el usuario existe antes de intentar actualizarlo
  const usuarioExistente = await usuariosModel.traerUsuario(cedula);
  if (!usuarioExistente) {
      return res.status(404).json({ message: 'Usuario no encontrado.' });
  }

  // Actualizar los datos del usuario excepto la cédula
  const result = await usuariosModel.actualizarUsuario(cedula, nombre, correo, clave);
  res.json({ message: 'Usuario actualizado correctamente.' });
});

module.exports = router;