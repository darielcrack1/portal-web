<?php
$pais = '';
$datosPais = [];
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pais = trim(filter_input(INPUT_POST, 'pais', FILTER_SANITIZE_STRING));

    if (!empty($pais)) {
        $url = "https://restcountries.com/v3.1/name/" . urlencode($pais);
        $respuesta = @file_get_contents($url);

        if ($respuesta !== false) {
            $datos = json_decode($respuesta, true);
            if (!empty($datos) && isset($datos[0]['name']['common'])) {
                $datosPais = $datos[0];
            } else {
                $error = "No se encontraron datos para el país ingresado.";
            }
        } else {
            $error = "Error al conectar con la API de países.";
        }
    } else {
        $error = "Por favor, ingresa el nombre de un país.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Datos de País</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include '../header.php'; ?>

    <div class="container mt-5">
        <h2 class="text-center">Datos de País</h2>
        <form method="POST" action="country.php" class="mt-4">
            <div class="mb-3">
                <label for="pais" class="form-label">Nombre del país:</label>
                <input type="text" class="form-control" id="pais" name="pais" value="<?php echo htmlspecialchars($pais); ?>">
            </div>
            <button type="submit" class="btn btn-primary">Buscar</button>
        </form>

        <?php if (!empty($datosPais)): ?>
            <div class="mt-4 p-3 text-center border rounded bg-light">
                <h4>Información sobre <strong><?php echo $datosPais['name']['common']; ?></strong>:</h4>
                <p><strong>Capital:</strong> <?php echo $datosPais['capital'][0] ?? 'No disponible'; ?></p>
                <p><strong>Región:</strong> <?php echo $datosPais['region'] ?? 'No disponible'; ?></p>
                <p><strong>Población:</strong> <?php echo number_format($datosPais['population'] ?? 0); ?></p>
                <img src="<?php echo $datosPais['flags']['png']; ?>" class="img-fluid mt-2" alt="Bandera de <?php echo $datosPais['name']['common']; ?>">
            </div>
        <?php elseif (!empty($error)): ?>
            <div class="mt-4 alert alert-danger text-center">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
