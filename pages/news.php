<?php 
// Listado de páginas con API REST activa (o que deberían tenerla)
$paginas = [
    'WPBeginner' => 'https://www.wpbeginner.com',
    'TechCrunch' => 'https://techcrunch.com',
    'Matt Mullenweg' => 'https://ma.tt', // Esta no tiene la API activa
];

// Inicialización de variables
$paginaSeleccionada = $_POST['pagina'] ?? '';
$articulos = [];
$error = '';

// Verifica si se envió el formulario
if (!empty($paginaSeleccionada) && filter_var($paginaSeleccionada, FILTER_VALIDATE_URL)) {

    // Se construye el endpoint de la API
    $apiUrl = rtrim($paginaSeleccionada, '/') . '/wp-json/wp/v2/posts?per_page=3';

    // Se obtiene la respuesta
    $respuesta = @file_get_contents($apiUrl);

    if ($respuesta === false) {
        $error = "❌ No se pudo conectar a la API de: <strong>$paginaSeleccionada</strong>. Verifica si tiene la API activa.";
    } else {
        $datos = json_decode($respuesta, true);

        if (json_last_error() !== JSON_ERROR_NONE || !is_array($datos)) {
            $error = "⚠️ La respuesta de la API no es válida.";
        } else {
            $articulos = $datos;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Últimas Noticias</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <?php include '../header.php'; ?>
    
    <div class="container mt-5">
        <h2 class="text-center">📰 Últimas Noticias desde WordPress</h2>

        <form method="POST" class="mt-4">
            <div class="mb-3">
                <label for="pagina" class="form-label">Selecciona una página de noticias:</label>
                <select class="form-select" id="pagina" name="pagina" required>
                    <option value="">-- Selecciona una opción --</option>
                    <?php foreach ($paginas as $nombre => $url): ?>
                        <option value="<?= htmlspecialchars($url) ?>" <?= ($url === $paginaSeleccionada) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($nombre) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Obtener Noticias</button>
        </form>

        <?php if ($error): ?>
            <div class="alert alert-danger mt-4"><?= $error ?></div>
        <?php endif; ?>

        <?php if ($articulos): ?>
            <div class="row mt-4">
                <?php foreach ($articulos as $articulo): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($articulo['title']['rendered']) ?></h5>
                                <p class="card-text"><?= strip_tags($articulo['excerpt']['rendered']) ?></p>
                                <a href="<?= htmlspecialchars($articulo['link']) ?>" class="btn btn-primary" target="_blank">Leer más</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
