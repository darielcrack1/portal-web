<?php 
// Inicializar variables
$usd = '';
$conversiones = [];
$error = '';

// Verificar si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usd = htmlspecialchars($_POST['usd']);

    if (!empty($usd) && is_numeric($usd)) {
        // Obtener datos de la API
        $apiUrl = "https://api.exchangerate-api.com/v4/latest/USD";
        $response = @file_get_contents($apiUrl);

        if ($response !== false) {
            $data = json_decode($response, true);

            if (isset($data['rates'])) {
                $conversiones = [
                    'DOP' => $usd * ($data['rates']['DOP'] ?? 0),
                    'EUR' => $usd * ($data['rates']['EUR'] ?? 0),
                    'JPY' => $usd * ($data['rates']['JPY'] ?? 0),
                    'GBP' => $usd * ($data['rates']['GBP'] ?? 0),
                ];
            } else {
                $error = "No se pudo obtener las tasas de cambio.";
            }
        } else {
            $error = "Error al conectar con la API de tasas de cambio.";
        }
    } else {
        $error = "Por favor, ingresa una cantidad válida en USD.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Conversor de Monedas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include '../header.php'; ?>

    <div class="container mt-5">
        <h2 class="text-center mb-4">Conversor de Monedas 💱</h2>
        
        <form method="POST" action="currency.php" class="card p-4 shadow">
            <div class="mb-3">
                <label for="usd" class="form-label">Cantidad en USD ($):</label>
                <input 
                    type="number" 
                    step="0.01" 
                    class="form-control" 
                    id="usd" 
                    name="usd" 
                    placeholder="Ej: 100.00" 
                    value="<?= htmlspecialchars($usd) ?>" 
                    required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Convertir</button>
        </form>

        <?php if (!empty($conversiones)): ?>
            <div class="mt-4">
                <h4>Resultado:</h4>
                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        🇩🇴 Pesos Dominicanos (DOP)
                        <span class="badge bg-success rounded-pill"><?= number_format($conversiones['DOP'], 2) ?> DOP</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        🇪🇺 Euros (EUR)
                        <span class="badge bg-info rounded-pill"><?= number_format($conversiones['EUR'], 2) ?> EUR</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        🇯🇵 Yen Japonés (JPY)
                        <span class="badge bg-warning text-dark rounded-pill"><?= number_format($conversiones['JPY'], 2) ?> JPY</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        🇬🇧 Libras Esterlinas (GBP)
                        <span class="badge bg-secondary rounded-pill"><?= number_format($conversiones['GBP'], 2) ?> GBP</span>
                    </li>
                </ul>
            </div>
        <?php elseif ($error): ?>
            <div class="alert alert-danger mt-4 text-center"><?= $error ?></div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
