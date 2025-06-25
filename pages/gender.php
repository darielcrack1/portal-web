<?php

$nombre = '';
$genero = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = htmlspecialchars($_POST['nombre']);

    
    if (!empty($nombre)) {
      
        $url = "https://api.genderize.io/?name=" . urlencode($nombre);
        $respuesta = file_get_contents($url);
        $datos = json_decode($respuesta, true);

      
        if (isset($datos['gender'])) {
            $genero = $datos['gender'];
        } else {
            $error = "No se pudo determinar el género.";
        }
    } else {
        $error = "Por favor, ingresa un nombre.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Predicción de Género</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include '../header.php'; ?>

    <div class="container mt-5">
        <h2 class="text-center">Predicción de Género</h2>
        <form method="POST" action="gender.php" class="mt-4">
            <div class="mb-3">
                <label for="nombre" class="form-label">Ingresa un nombre:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $nombre; ?>">
            </div>
            <button type="submit" class="btn btn-primary">Predecir Género</button>
        </form>

        <?php if ($genero): ?>
            <div class="mt-4 p-3 text-center" style="background-color: <?php echo $genero == 'male' ? '#ADD8E6' : '#FFB6C1'; ?>;">
                <h4>El género para el nombre <strong><?php echo $nombre; ?></strong> es:</h4>
                <h2><?php echo $genero == 'male' ? 'Masculino 💙' : 'Femenino 💖'; ?></h2>
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
