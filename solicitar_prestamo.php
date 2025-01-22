<?php
include_once 'config/Database.php';
include_once 'models/Libro.php';
include_once 'models/Prestamo.php';

$database = new Database();
$db = $database->getConnection();

if(isset($_GET['id'])) {
    $libro = new Libro($db);
    $libro->id = $_GET['id'];
    // Obtener información del libro
    $stmt = $libro->buscar($libro->id);
    $libro_info = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $prestamo = new Prestamo($db);
        $prestamo->libro_id = $_GET['id'];
        $prestamo->usuario_id = 1; // En un sistema real, esto vendría de la sesión
        $prestamo->fecha_prestamo = date('Y-m-d H:i:s');
        $prestamo->fecha_devolucion = date('Y-m-d H:i:s', strtotime('+15 days'));
        
        if($prestamo->registrarPrestamo()) {
            header('Location: prestamos.php');
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Solicitar Préstamo - Biblioteca</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
</head>
<body>
    <?php include_once 'includes/nav.php'; ?>

    <section class="section">
        <div class="container">
            <h1 class="title">Solicitar Préstamo</h1>

            <?php if(isset($libro_info)): ?>
                <div class="box">
                    <h2 class="subtitle">Información del Libro</h2>
                    <p><strong>Título:</strong> <?php echo $libro_info['titulo']; ?></p>
                    <p><strong>Autor:</strong> <?php echo $libro_info['autor']; ?></p>
                    <p><strong>ISBN:</strong> <?php echo $libro_info['isbn']; ?></p>

                    <form method="POST" class="mt-4">
                        <div class="field">
                            <div class="control">
                                <button type="submit" class="button is-primary">
                                    Confirmar Préstamo
                                </button>
                                <a href="buscar.php" class="button">
                                    Cancelar
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            <?php else: ?>
                <div class="notification is-danger">
                    Libro no encontrado.
                </div>
            <?php endif; ?>
        </div>
    </section>
</body>
</html>