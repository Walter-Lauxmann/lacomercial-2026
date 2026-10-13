<?php
header("Content-Type: application/json; charset=utf-8");
require_once 'config.php';
require_once 'modelos.php';

// Simulación de validación de usuario (aquí consultarías tu tabla 'usuarios')
$usuario_recibido = $_POST['usuario'] ?? '';
$pass_recibida = $_POST['password'] ?? '';

// Verificamos que no vengan campos vacíos
if (empty($usuario_recibido) || empty($pass_recibida)) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'Por favor, proporciona usuario y contraseña'
    ]);
    exit;
}

// Consultamos la tabla 'clientes' usando nuestro Modelo
$tabla = new Modelo('clientes');
$tabla->setCriterio("usuario='$usuario_recibido'");
$resultado = $tabla->seleccionar();

if (!empty($resultado)) {
    $usuario = $resultado[0];
    if (password_verify($pass_recibida, $usuario['password'])) {
    
        $header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);
        $payload = json_encode([
            'user_id' => $usuario['id'],
            'usuario' => $usuario['usuario'],
            'rol' => $usuario['rol'],
            'iat' => time(),
            'exp' => time() + JWT_EXP
        ]);

        // Codificación Base64Url
        $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));
        $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));

        // Generar la firma con HMAC SHA256
        $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, JWT_SECRET, true);
        $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));

        $jwt = $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;

        echo json_encode([
            'success' => true,
            'message' => 'Autenticación exitosa',
            'token' => $jwt,
            'usuario' => [
                'id' => $usuario['id'],
                'usuario' => $usuario['usuario'],
                'nombre' => $usuario['nombre'],
                'rol' => $usuario['rol']
            ]
        ]);
        exit;
    }
} else {
    http_response_code(401);
    echo json_encode([
        'success' => false,
        'message' => 'Credenciales inválidas'
    ]);
}
?>