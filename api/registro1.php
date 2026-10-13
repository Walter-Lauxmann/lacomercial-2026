<?php
header('Content-Type: application/json; charset=utf-8');
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode([
        'success' => false, 
        'message' => 'Método no permitido'
    ]);
    exit;
}

$nombre = trim($_POST['nombre'] ?? '');
$apellido = trim($_POST['apellido'] ?? '');
$usuario = trim($_POST['usuario'] ?? '');
$password = $_POST['password'] ?? '';

if ($nombre === '' || $apellido === '' || $usuario === '' || $password === '') {
    http_response_code(400);
    echo json_encode([
        'success' => false, 
        'message' => 'Completa todos los campos obligatorios'
    ]);
    exit;
}

if (strlen($nombre) > 50 || strlen($apellido) > 50 || strlen($usuario) > 50) {
    http_response_code(400);
    echo json_encode([
        'success' => false, 
        'message' => 'Uno o más campos superan la longitud permitida'
    ]);
    exit;
}

try {
    $db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $db->set_charset(DB_CHARSET);

    $consulta = $db->prepare('SELECT id FROM usuarios WHERE usuario = ? LIMIT 1');
    $consulta->bind_param('s', $usuario);
    $consulta->execute();
    $consulta->store_result();

    if ($consulta->num_rows > 0) {
        http_response_code(409);
        echo json_encode(['success' => false, 'message' => 'Ese nombre de usuario ya está registrado']);
        exit;
    }
    $consulta->close();

    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
    $insercion = $db->prepare(
        "INSERT INTO usuarios (nombre, apellido, usuario, password, rol) VALUES (?, ?, ?, ?, 'cliente')"
    );
    $insercion->bind_param('ssss', $nombre, $apellido, $usuario, $passwordHash);
    $insercion->execute();

    http_response_code(201);
    echo json_encode([
        'success' => true,
        'message' => 'Usuario registrado correctamente',
        'id' => $insercion->insert_id
    ]);
} catch (mysqli_sql_exception $error) {
    if ($error->getCode() === 1062) {
        http_response_code(409);
        echo json_encode(['success' => false, 'message' => 'Ese nombre de usuario ya está registrado']);
    } else {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'No se pudo completar el registro']);
    }
}
?>