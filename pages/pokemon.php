<?php
$pokemon = '';
$info = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pokemon = htmlspecialchars($_POST['pokemon']);
    if (!empty($pokemon)) {
        $url = "https://pokeapi.co/api/v2/pokemon/" . strtolower($pokemon);
        $respuesta = file_get_contents($url);
        if ($respuesta) {
            $datos = json_decode($respuesta, true);
            $info = [
                'Nombre' => ucfirst($datos['name']),
                'Peso' => $datos['weight'],
                'Altura' => $datos['height'],
                'Imagen' => $datos['sprites']['front_default']
            ];
        } else {
            $error = "No se encontró información para el Pokémon ingresado.";
        }
    } else {
        $error = "Por favor, ingresa un nombre de Pokémon.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Información de Pokémon</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include '../header.php'; ?>

    <div class="container mt-5">
        <h2 class="text-center">Información de Pokémon</h2>
        <form method="POST" action="pokemon.php" class="mt-4">
            <div class="mb-3">
                <label for="pokemon" class="form-label">Ingresa el nombre de un Pokémon:</label>
                <input type="text" class="form-control" id="pokemon" name="pokemon" value="<?php echo $pokemon; ?>">
            </div>
            <button type="submit" class="btn btn-primary">Buscar</button>
        </form>

        <?php if ($info): ?>
            <div class="mt-4 p-3 text-center">
                <h4><?php echo $info['Nombre']; ?></h4>
                <img src="<?php echo $info['Imagen']; ?>" alt="<?php echo $info['Nombre']; ?>">
                <p>Peso: <?php echo $info['Peso']; ?></p>
                <p>Altura: <?php echo $info['Altura']; ?></p>
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
