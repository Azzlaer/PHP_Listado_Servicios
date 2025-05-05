<?php
function getAllowedServicesFromConfig($path = 'config.ini') {
    if (!file_exists($path)) return [];
    $config = parse_ini_file($path, true);
    return isset($config['ServiciosPermitidos']['servicios']) ? $config['ServiciosPermitidos']['servicios'] : [];
}

function getServices($allowed = []) {
    $output = shell_exec('powershell -command "Get-Service | Select-Object Name,Status | ConvertTo-Json"');
    $allServices = json_decode($output, true);

    // Si hay lista permitida, filtrar
    if (!empty($allowed)) {
        return array_filter($allServices, function($service) use ($allowed) {
            return in_array($service['Name'], $allowed);
        });
    }

    return $allServices;
}

// Manejo de acciones
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['service']) && !empty($_POST['action'])) {
    $service = escapeshellarg($_POST['service']);
    $action = ($_POST['action'] === 'start') ? "Start-Service" : "Stop-Service";
    shell_exec("powershell -command \"$action -Name $service\"");
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Leer servicios permitidos y obtener lista filtrada
$allowedServices = getAllowedServicesFromConfig();
$services = getServices($allowedServices);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>🔧 Administración de Servicios Windows</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #1e1e2f;
            color: #f0f0f0;
            text-align: center;
            padding: 20px;
        }

        h2 {
            margin-bottom: 30px;
            color: #ffcc00;
        }

        table {
            width: 80%;
            margin: auto;
            border-collapse: collapse;
            background-color: #2b2b3c;
            box-shadow: 0 0 20px rgba(0,0,0,0.5);
            border-radius: 10px;
            overflow: hidden;
        }

        th, td {
            padding: 15px;
            border: 1px solid #444;
            text-align: center;
        }

        th {
            background-color: #3e3e5e;
            color: #ffffff;
            font-size: 1.1em;
        }

        .running {
            background-color: #28a745;
            color: #fff;
            font-weight: bold;
        }

        .stopped {
            background-color: #dc3545;
            color: #fff;
            font-weight: bold;
        }

        .running::before {
            content: "✅ ";
        }

        .stopped::before {
            content: "🛑 ";
        }

        button {
            padding: 10px 15px;
            border: none;
            cursor: pointer;
            font-size: 0.95em;
            border-radius: 6px;
            transition: 0.2s ease-in-out;
            margin: 3px;
        }

        .start-btn {
            background-color: #28a745;
            color: white;
        }

        .start-btn:hover {
            background-color: #218838;
        }

        .stop-btn {
            background-color: #dc3545;
            color: white;
        }

        .stop-btn:hover {
            background-color: #c82333;
        }

        .service-name {
            font-weight: bold;
            font-size: 1em;
        }

        footer {
            margin-top: 40px;
            font-size: 0.9em;
            color: #aaa;
        }
    </style>
</head>
<body>
    <h2>🔧 Panel de Servicios Específicos</h2>
    <table>
        <tr>
            <th>🧾 Servicio</th>
            <th>📊 Estado</th>
            <th>⚙️ Acción</th>
        </tr>
        <?php foreach ($services as $service): ?>
            <tr>
                <td class="service-name"><?= htmlspecialchars($service['Name']) ?></td>
                <td class="<?= strtolower($service['Status']) === 'running' ? 'running' : 'stopped' ?>">
                    <?= htmlspecialchars($service['Status']) ?>
                </td>
                <td>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="service" value="<?= htmlspecialchars($service['Name']) ?>">
                        <button type="submit" name="action" value="start" class="start-btn">🚀 Iniciar</button>
                    </form>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="service" value="<?= htmlspecialchars($service['Name']) ?>">
                        <button type="submit" name="action" value="stop" class="stop-btn">⛔ Detener</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <footer>
        🧩 Servicios mostrados desde <code>config.ini</code> | Gestión PowerShell desde PHP 😎
    </footer>
</body>
</html>
