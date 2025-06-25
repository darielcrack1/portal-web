<?php
// Clave de acceso a la API de Unsplash (mejor usar en .env fuera de producción)
define('UNSPLASH_CLIENT_ID', 'RMcO4_ibZyysgKfa83GkE4tMfA9OJwP7A0ehxeqvjz4');

$palabraClave = '';
$imagenUrl = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Filtrar y sanitizar la entrada del usuario
    $palabraClave = filter_input(INPUT_POST, 'palabraClave', FILTER_SANITIZE_STRING);

    if (!empty($palabraClave)) {
        // Construir la URL de la API
        $url = "https://api.unsplash.com/photos/random?query=" . urlencode($palabraClave) . "&client_id=" . UNSPLASH_CLIENT_ID;

        // Obtener respuesta de la API
        try {
            $respuesta = @file_get_contents($url);

            if ($respuesta === false) {
                throw new Exception("Error al conectar con Unsplash API.");
            }

            $datos = json_decode($respuesta, true);

            if (isset($datos['urls']['regular'])) {
                $imagenUrl = $datos['urls']['regular'];
            } else {
                $error = "No se encontró ninguna imagen para la palabra clave ingresada.";
            }

        } catch (Exception $e) {
            $error = "Ocurrió un error: " . $e->getMessage();
        }
    } else {
        $error = "Por favor, ingresa una palabra clave válida.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generador de Imágenes con IA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include '../header.php'; ?>

    <div class="container mt-5 text-center">
        <h2>Generador de Imágenes con IA 🖼️</h2>
        <p>Ingresa una palabra clave y obtén una imagen relacionada</p>
        
        <form method="POST" action="images.php" class="mt-4">
            <div class="mb-3">
                <input type="text" class="form-control" id="palabraClave" name="palabraClave" 
                       placeholder="Ej: playa, perro, naturaleza" value="<?= htmlspecialchars($palabraClave) ?>">
            </div>
            <button type="submit" class="btn btn-primary">Generar Imagen</button>
        </form>

        <?php if ($imagenUrl): ?>
            <div class="mt-4">
                <img src="<?= htmlspecialchars($imagenUrl) ?>" class="img-fluid rounded shadow" alt="Imagen generada">
                <p class="mt-2">Imagen relacionada con <strong><?= htmlspecialchars($palabraClave) ?></strong></p>
            </div>
        <?php elseif ($error): ?>
            <div class="mt-4 alert alert-danger">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
