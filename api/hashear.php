<?php
header("Content-Type: text/html; charset=utf-8");

require_once 'config.php';
require_once 'modelos.php';

echo "<h2>🚀 Iniciando proceso de migración de contraseñas...</h2>";

// 1. Instanciamos el modelo para la tabla 'clientes'
$modeloCliente = new Modelo('clientes');

// 2. Traemos todos los registros de la tabla
$clientes = $modeloCliente->seleccionar();

if (empty($clientes)) {
    echo "<p>⚠️ No se encontraron clientes en la base de datos.</p>";
    exit;
}

$migrados = 0;
$omitidos = 0;

foreach ($clientes as $cliente) {
    $id = $cliente['id'];
    $passActual = $cliente['password'];

    // 3. Verificamos si la contraseña YA es un hash seguro de BCrypt/Argon
    // Un hash de password_hash() suele empezar con '$2y$' y tiene 60 caracteres
    if (strpos($passActual, '$2y$') === 0 || strpos($passActual, '$2a$') === 0) {
        echo "ℹ️ El cliente ID <strong>{$id}</strong> ({$cliente['usuario']}) ya tiene un hash seguro. Omitido.<br>";
        $omitidos++;
        continue;
    }

    // 4. Si es texto plano, generamos el hash seguro
    $nuevoHash = password_hash($passActual, PASSWORD_DEFAULT);

    // 5. Actualizamos la base de datos para este cliente específico
    $modeloCliente->setCriterio("id = {$id}");
    
    // Pasamos el nuevo hash a actualizar
    $resultado = $modeloCliente->actualizar([
        'password' => $nuevoHash
    ]);

    if ($resultado) {
        echo "✅ Cliente ID <strong>{$id}</strong> ({$cliente['usuario']}): Contraseña '<em>{$passActual}</em>' migrada exitosamente a Hash.<br>";
        $migrados++;
    } else {
        echo "❌ Error al actualizar el cliente ID <strong>{$id}</strong>.<br>";
    }
}

echo "<hr>";
echo "<h3>🎉 Proceso finalizado:</h3>";
echo "<ul>";
echo "<li><strong>Contraseñas migradas:</strong> {$migrados}</li>";
echo "<li><strong>Contraseñas ya seguras (omitidas):</strong> {$omitidos}</li>";
echo "</ul>";
echo "<p><strong>Nota de seguridad:</strong> Recuerda eliminar o restringir el acceso a este archivo 'migrar_passwords.php' en tu servidor de producción.</p>";
?>