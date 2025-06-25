<?php
$joke = '';
$error = '';

$url = "https://v2.jokeapi.dev/joke/Any";
$response = file_get_contents($url);
$data = json_decode($response, true);

if ($data['error'] == false) {
    if ($data['type'] == 'single') {
        $joke = $data['joke'];
    } else {
        $joke = $data['setup'] . " - " . $data['delivery'];
    }
} else {
    $error = "No se pudo obtener un chiste.";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Generador de Chistes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
   
</head>
<body>
    <?php include '../header.php'; ?>

    <div class="container mt-5">
        <h2 class="text-center">Generador de Chistes</h2>
        <div class="mt-4 text-center">
            <?php if ($joke): ?>
                <h4><?php echo $joke; ?></h4>
            <?php elseif ($error): ?>
                <div class="alert alert-danger">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
