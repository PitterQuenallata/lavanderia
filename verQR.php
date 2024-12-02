<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket de Pago</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 20px;
        }
        .ticket {
            border: 1px solid #000;
            padding: 20px;
            max-width: 400px;
            margin: auto;
            text-align: center;
        }
        .qr-image {
            margin: 20px 0;
        }
        .detalle {
            font-size: 16px;
            margin-bottom: 20px;
        }
        .btn-print {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="ticket">
        <h2>Ticket de Pago</h2>
        <p class="detalle"><strong>Detalle:</strong> <span id="detalle"></span></p>
        <div class="qr-image">
            <img id="qr" alt="QR Code" width="200">
        </div>
        <button class="btn-print" onclick="window.print()">Imprimir Ticket</button>
    </div>
    <script>
        // Leer datos desde localStorage
        const qrBase64 = localStorage.getItem("qr");
        const detalle = localStorage.getItem("detalle");

        if (!qrBase64) {
            alert("No se proporcionó el código QR.");
            window.close(); // Cerrar la ventana si no hay datos
        } else {
            // Mostrar datos en la página
            document.getElementById("detalle").textContent = detalle || "Sin detalles.";
            document.getElementById("qr").src = qrBase64;

            // Eliminar datos del localStorage
            localStorage.removeItem("qr");
            localStorage.removeItem("detalle");
        }
    </script>

</body>
</html>
