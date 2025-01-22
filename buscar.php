<?php
include_once 'config/Database.php';
include_once 'models/Libro.php';

$database = new Database();
$db = $database->getConnection();

$libro = new Libro($db);
$resultados = null;

if(isset($_GET['termino']) && !empty($_GET['termino'])) {
    $resultados = $libro->buscar($_GET['termino']);
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Búsqueda de Libros - Biblioteca</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
</head>
<body>
    <?php include_once 'includes/nav.php'; ?>

    <section class="section">
        <div class="container">
            <h1 class="title">Búsqueda de Libros</h1>

            <div class="box">
                <form action="buscar.php" method="GET">
                    <div class="field has-addons">
                        <div class="control is-expanded">
                            <input class="input" type="text" name="termino" 
                                   placeholder="Buscar por título, autor o categoría"
                                   value="<?php echo isset($_GET['termino']) ? htmlspecialchars($_GET['termino']) : ''; ?>">
                        </div>
                        <div class="control">
                            <button type="submit" class="button is-primary">Buscar</button>
                        </div>
                    </div>
                </form>
            </div>

            <?php if($resultados): ?>
                <div class="table-container">
                    <table class="table is-fullwidth is-striped">
                        <thead>
                            <tr>
                                <th>Título</th>
                                <th>Autor</th>
                                <th>Categoría</th>
                                <th>ISBN</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($row = $resultados->fetch(PDO::FETCH_ASSOC)) { ?>
                                <tr>
                                    <td><?php echo $row['titulo']; ?></td>
                                    <td><?php echo $row['autor']; ?></td>
                                    <td><?php echo $row['categoria']; ?></td>
                                    <td><?php echo $row['isbn']; ?></td>
                                    <td>
                                        <?php echo $row['disponible'] ? 
                                                  '<span class="tag is-success">Disponible</span>' : 
                                                  '<span class="tag is-danger">Prestado</span>'; ?>
                                    </td>
                                    <td>
                                        <?php if($row['disponible']) { ?>
                                            <a href="solicitar_prestamo.php?id=<?php echo $row['id']; ?>" 
                                               class="button is-small is-primary">
                                                Solicitar Préstamo
                                            </a>
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            <?php elseif(isset($_GET['termino'])): ?>
                <div class="notification is-info">
                    No se encontraron resultados para su búsqueda.
                </div>
            <?php endif; ?>
        </div>
    </section>
</body>
</html>