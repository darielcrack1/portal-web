<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acerca de - Portal Web con APIs</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    <?php include '../header.php'; ?>

    <main class="container my-5">
        <div class="card shadow-lg border-0">
            <div class="card-body">
                <h1 class="text-center mb-3"><i class="bi bi-globe2"></i> Acerca de este Portal Web</h1>
                <p class="lead text-center">Conoce más sobre el desarrollo de este proyecto y las herramientas utilizadas.</p>
                <hr>

                <section class="mt-4">
                    <h2><i class="bi bi-patch-question-fill text-primary"></i> ¿Qué es este portal?</h2>
                    <p>
                        Este portal web integra múltiples APIs para ofrecer servicios útiles como información del clima, noticias,
                        datos de países, conversión de monedas y mucho más. Todo en un solo lugar, con una interfaz amigable y fácil de usar.
                    </p>
                </section>

                <section class="mt-4 bg-light p-4 rounded">
                    <h2><i class="bi bi-palette-fill text-success"></i> Framework CSS Utilizado</h2>
                    <p>
                        Para el diseño y la maquetación de este portal, se utilizó el framework CSS <strong>Bootstrap 5</strong>.
                    </p>
                    <h3>¿Por qué Bootstrap?</h3>
                    <ul>
                        <li>📱 <strong>Diseño Responsivo:</strong> Se adapta a móviles, tablets y computadoras.</li>
                        <li>🎨 <strong>Componentes Listos:</strong> Agiliza el desarrollo con elementos reutilizables.</li>
                        <li>⚙️ <strong>Fácil de Usar:</strong> Documentación clara y estructura sencilla.</li>
                        <li>🚀 <strong>Consistencia:</strong> Apariencia profesional en todo el sitio.</li>
                    </ul>
                </section>

                <section class="mt-4 text-center">
                    <h2><i class="bi bi-person-circle text-info"></i> Sobre el Desarrollador</h2>
                    <img src="../teuddy.jpg" alt="Foto de teuddy" class="rounded-circle mb-3 shadow" width="150">
                    <h4>teuddy Sánchez</h4>
                    <p>
                        Estudiante de Desarrollo de Software en ITLA, apasionado por el desarrollo web y la integración de tecnologías modernas.
                        Este portal web es un proyecto académico para explorar el uso de APIs y frameworks CSS.
                    </p>
                </section>

                <section class="mt-5 text-center">
                    <h2><i class="bi bi-hand-thumbs-up-fill text-warning"></i> ¡Gracias por visitar!</h2>
                    <p>
                        Si tienes preguntas o sugerencias, no dudes en explorar el resto del portal o ponerte en contacto.
                    </p>
                </section>
            </div>
        </div>
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
