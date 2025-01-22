<?php
include_once 'config/Database.php';
include_once 'models/Prestamo.php';

$database = new Database();
$db = $database->getConnection();

$prestamo = new Prestamo($db);
$prestamos = $prestamo->obtenerPrestamos();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Préstamos - Biblioteca</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
</head>
<body>
    <?php include_once 'includes/nav.php'; ?>

    <section class="section">
        <div class="container">
            <h1 class="title">Gestión de Préstamos</h1>

            <div class="table-container">
                <table class="table is-fullwidth is-striped">
                    <thead>
                        <tr>
                            <th>Libro</th>
                            <th>Fecha Préstamo</th>
                            <th>Fecha Devolución</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = $prestamos->fetch(PDO::FETCH_ASSOC)) { ?>
                            <tr>
                                <td><?php echo $row['libro_titulo']; ?></td>
                                <td><?php echo date('d/m/Y', strtotime($row['fecha_prestamo'])); ?></td>
                                <td><?php echo date('d/m/Y', strtotime($row['fecha_devolucion'])); ?></td>
                                <td>
                                    <span class="tag <?php echo $row['estado'] == 'activo' ? 'is-warning' : 'is-success'; ?>">
                                        <?php echo ucfirst($row['estado']); ?>
                                    </span>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</body>
</html>