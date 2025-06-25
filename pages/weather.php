<?php
$ciudad = '';
$clima = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ciudad = htmlspecialchars($_POST['ciudad']);
    if (!empty($ciudad)) {
        $api_key = 'de442ede0b8c4efe81b03904252702'; // Reemplaza con tu clave de WeatherAPI
        $url = "https://api.weatherapi.com/v1/current.json?key=$api_key&q=" . urlencode($ciudad);

        $respuesta = file_get_contents($url);
        $datos = json_decode($respuesta, true);

        if (isset($datos['current'])) {
            $clima = "El clima en $ciudad es: " . $datos['current']['condition']['text'] . 
                     ", con una temperatura de " . $datos['current']['temp_c'] . "°C.";
        } else {
            $error = "No se pudo obtener la información del clima.";
        }
    } else {
        $error = "Por favor, ingresa una ciudad.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clima</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include '../header.php'; ?>

    <div class="container mt-5">
        <h2 class="text-center">Consulta el Clima</h2>
        <form method="POST" action="weather.php" class="mt-4">
            <div class="mb-3">
                <label for="ciudad" class="form-label">Ingresa una ciudad:</label>
                <input type="text" class="form-control" id="ciudad" name="ciudad" value="<?php echo $ciudad; ?>">
            </div>
            <button type="submit" class="btn btn-primary">Consultar Clima</button>
        </form>

        <?php if ($clima): ?>
            <div class="mt-4 alert alert-info text-center">
                <?php echo $clima; ?>
            </div>
        <?php elseif ($error): ?>
            <div class="mt-4 alert alert-danger text-center">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

