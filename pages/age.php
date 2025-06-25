<?php
$nombre = '';
$edad = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombreInput = trim($_POST['nombre']);
    $nombreInput = htmlspecialchars($nombreInput);

    if (!empty($nombreInput)) {
        // Estandarizar el nombre para comparación
        $nombreLower = strtolower($nombreInput);

        // Corrección especial para "Teuddy"
        if ($nombreLower === 'teuddy' || $nombreLower === 'teuddy sanchez') {
            $nombreInput = 'Teuddy Sánchez';
        }

        $url = "https://api.agify.io/?name=" . urlencode($nombreInput);
        $respuesta = @file_get_contents($url); // Usamos @ para manejar errores

        if ($respuesta !== false) {
            $datos = json_decode($respuesta, true);

            if (isset($datos['age'])) {
                $edad = $datos['age'];
                $nombre = $nombreInput;
            } else {
                $error = "No se pudo determinar la edad con los datos recibidos.";
            }
        } else {
            $error = "Error al conectar con el servicio de predicción.";
        }
    } else {
        $error = "Por favor, ingresa un nombre válido.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Predicción de Edad</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include '../header.php'; ?>

    <div class="container mt-5">
        <h2 class="text-center mb-4">🔮 Predicción de Edad</h2>

        <form method="POST" action="age.php" class="card p-4 shadow-sm">
            <div class="mb-3">
                <label for="nombre" class="form-label">Ingresa un nombre:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" 
                       value="<?php echo htmlspecialchars($nombre); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Predecir Edad</button>
        </form>

        <?php if ($edad): ?>
            <div class="alert alert-success text-center mt-4">
                <h5>La edad estimada para el nombre <strong><?php echo htmlspecialchars($nombre); ?></strong> es:</h5>
                <h2>
                    <?php echo $edad; ?> años
                    <?php 
                        echo $edad < 18 ? "👶" : ($edad < 60 ? "🧑" : "👴");
                    ?>
                </h2>
            </div>
        <?php elseif ($error): ?>
            <div class="alert alert-danger text-center mt-4">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
