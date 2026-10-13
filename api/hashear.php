<?php
header("Content-Type: text/html; charset=utf-8");

require_once 'config.php';
require_once 'modelos.php';

echo "<h2>🚀 Iniciando proceso de migración de contraseñas...</h2>";

// 1. Instanciamos el modelo para la tabla 'usuarios'
$modeloUsuario = new Modelo('usuarios');

// 2. Traemos todos los registros de la tabla
$usuarios = $modeloUsuario->seleccionar();

if (empty($usuarios)) {
    echo "<p>⚠️ No se encontraron usuarios en la base de datos.</p>";
    exit;
}

$migrados = 0;
$omitidos = 0;

foreach ($usuarios as $usuario) {
    $id = $usuario['id'];
    $passActual = $usuario['password'];

    // 3. Verificamos si la contraseña YA es un hash seguro de BCrypt/Argon
    // Un hash de password_hash() suele empezar con '$2y$' y tiene 60 caracteres
    if (strpos($passActual, '$2y$') === 0 || strpos($passActual, '$2a$') === 0) {
        echo "ℹ️ El usuario ID <strong>{$id}</strong> ({$usuario['usuario']}) ya tiene un hash seguro. Omitido.<br>";
        $omitidos++;
        continue;
    }

        // 4. Actualizamos la base de datos; Modelo::actualizar hashea la contraseña
    $modeloUsuario->setCriterio("id = {$id}");
    
        // Pasamos la contraseña en texto plano para que el modelo la hashee una sola vez
    $resultado = $modeloUsuario->actualizar([
            'password' => $passActual
    ]);

    if ($resultado) {
        echo "✅ Usuario ID <strong>{$id}</strong> ({$usuario['usuario']}): contraseña migrada exitosamente a hash.<br>";
        $migrados++;
    } else {
        echo "❌ Error al actualizar el usuario ID <strong>{$id}</strong>.<br>";
    }
}

echo "<hr>";
echo "<h3>🎉 Proceso finalizado:</h3>";
echo "<ul>";
echo "<li><strong>Contraseñas migradas:</strong> {$migrados}</li>";
echo "<li><strong>Contraseñas ya seguras (omitidas):</strong> {$omitidos}</li>";
echo "</ul>";
echo "<p><strong>Nota de seguridad:</strong> Elimina o restringe el acceso a este archivo en producción.</p>";
?>