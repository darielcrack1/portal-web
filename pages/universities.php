<?php
$pais = '';
$universidades = [];
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pais = htmlspecialchars($_POST['pais']);
    if (!empty($pais)) {
        $url = "http://universities.hipolabs.com/search?country=" . urlencode($pais);
        $respuesta = file_get_contents($url);
        $datos = json_decode($respuesta, true);

        if (!empty($datos)) {
            $universidades = $datos;
        } else {
            $error = "No se encontraron universidades para ese país.";
        }
    } else {
        $error = "Por favor, ingresa un país.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Universidades de un País</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include '../header.php'; ?>

    <div class="container mt-5">
        <h2 class="text-center">Universidades de un País</h2>
        <form method="POST" action="universities.php" class="mt-4">
            <div class="mb-3">
                <label for="pais" class="form-label">Ingresa el nombre de un país (en inglés):</label>
                <input type="text" class="form-control" id="pais" name="pais" value="<?php echo $pais; ?>">
            </div>
            <button type="submit" class="btn btn-primary">Buscar Universidades</button>
        </form>

        <?php if ($universidades): ?>
            <div class="mt-4">
                <h4>Universidades en <strong><?php echo $pais; ?></strong>:</h4>
                <ul class="list-group">
                    <?php foreach ($universidades as $uni): ?>
                        <li class="list-group-item">
                            <strong><?php echo $uni['name']; ?></strong><br>
                            Dominio: <?php echo $uni['domains'][0]; ?><br>
                            <a href="<?php echo $uni['web_pages'][0]; ?>" target="_blank">Visitar sitio web</a>
                        </li>
                    <?php endforeach; ?>
                </ul>
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
