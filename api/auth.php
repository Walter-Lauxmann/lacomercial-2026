<?php
require_once 'config.php';

function validarToken($rolesPermitidos = []) {
    $headers = getallheaders();
    $authHeader = $headers['Authorization'] ?? $headers['authorization'] ?? '';

    if (!preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
        http_response_code(401);
        echo json_encode(['success' => false, 'message' => 'Acceso denegado: Token no proporcionado']);
        exit;
    }

    $jwt = $matches[1];
    $tokenParts = explode('.', $jwt);

    if (count($tokenParts) !== 3) {
        http_response_code(401);
        echo json_encode(['success' => false, 'message' => 'Estructura de Token inválida']);
        exit;
    }

    $header = $tokenParts[0];
    $payload = $tokenParts[1];
    $signatureProvided = $tokenParts[2];

    // Verificar firma
    $validSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode(
        hash_hmac('sha256', $header . "." . $payload, JWT_SECRET, true)
    ));

    if ($signatureProvided !== $validSignature) {
        http_response_code(401);
        echo json_encode(['success' => false, 'message' => 'Firma de Token inválida']);
        exit;
    }

    // Verificar expiración
    $payloadData = json_decode(base64_decode($payload), true);
    if (isset($payloadData['exp']) && $payloadData['exp'] < time()) {
        http_response_code(401);
        echo json_encode(['success' => false, 'message' => 'El Token ha expirado']);
        exit;
    }

    // VERIFICACIÓN DE ROLES (Autorización)
    if (!empty($rolesPermitidos)) {
        $rolUsuario = $payloadData['rol'] ?? '';
        if (!in_array($rolUsuario, $rolesPermitidos)) {
            http_response_code(403); // Forbidden
            echo json_encode([
                'success' => false, 
                'message' => 'Acceso denegado: No posees los permisos necesarios para esta acción'
            ]);
            exit;
        }
    }

    return $payloadData; // Devuelve los datos del usuario autenticado
}
?>