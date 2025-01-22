<?php
include_once 'config/Database.php';
include_once 'models/Libro.php';

$database = new Database();
$db = $database->getConnection();
$libro = new Libro($db);

// Procesar formulario si se envió
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['accion'])) {
        switch ($_POST['accion']) {
            case 'crear':
                $libro->titulo = $_POST['titulo'];
                $libro->autor = $_POST['autor'];
                $libro->categoria = $_POST['categoria'];
                $libro->isbn = $_POST['isbn'];
                $libro->disponible = 1;
                
                if ($libro->crear()) {
                    $mensaje = "Libro creado con éxito";
                } else {
                    $error = "Error al crear el libro";
                }
                break;

            case 'editar':
                $libro->id = $_POST['id'];
                $libro->titulo = $_POST['titulo'];
                $libro->autor = $_POST['autor'];
                $libro->categoria = $_POST['categoria'];
                $libro->isbn = $_POST['isbn'];
                
                if ($libro->editar()) {
                    $mensaje = "Libro actualizado con éxito";
                } else {
                    $error = "Error al actualizar el libro";
                }
                break;

            case 'eliminar':
                $libro->id = $_POST['id'];
                if ($libro->eliminar()) {
                    $mensaje = "Libro eliminado con éxito";
                } else {
                    $error = "Error al eliminar el libro";
                }
                break;
        }
    }
}

// Obtener libro para editar
$libro_editar = null;
if (isset($_GET['editar'])) {
    $stmt = $libro->buscar($_GET['editar']);
    $libro_editar = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Obtener lista de libros
$libros = $libro->leer();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gestión de Libros - Biblioteca</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
</head>
<body>
    <?php include_once 'includes/nav.php'; ?>

    <section class="section">
        <div class="container">
            <h1 class="title">Gestión de Libros</h1>

            <?php if (isset($mensaje)): ?>
                <div class="notification is-success">
                    <?php echo $mensaje; ?>
                </div>
            <?php endif; ?>

            <?php if (isset($error)): ?>
                <div class="notification is-danger">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <!-- Formulario para crear/editar libro -->
            <div class="box">
                <h2 class="subtitle">
                    <?php echo $libro_editar ? 'Editar Libro' : 'Agregar Nuevo Libro'; ?>
                </h2>
                
                <form method="POST">
                    <input type="hidden" name="accion" 
                           value="<?php echo $libro_editar ? 'editar' : 'crear'; ?>">
                    
                    <?php if ($libro_editar): ?>
                        <input type="hidden" name="id" value="<?php echo $libro_editar['id']; ?>">
                    <?php endif; ?>

                    <div class="field">
                        <label class="label">Título</label>
                        <div class="control">
                            <input class="input" type="text" name="titulo" required
                                   value="<?php echo $libro_editar ? $libro_editar['titulo'] : ''; ?>">
                        </div>
                    </div>

                    <div class="field">
                        <label class="label">Autor</label>
                        <div class="control">
                            <input class="input" type="text" name="autor" required
                                   value="<?php echo $libro_editar ? $libro_editar['autor'] : ''; ?>">
                        </div>
                    </div>

                    <div class="field">
                        <label class="label">Categoría</label>
                        <div class="control">
                            <input class="input" type="text" name="categoria" required
                                   value="<?php echo $libro_editar ? $libro_editar['categoria'] : ''; ?>">
                        </div>
                    </div>

                    <div class="field">
                        <label class="label">ISBN</label>
                        <div class="control">
                            <input class="input" type="text" name="isbn" required
                                   value="<?php echo $libro_editar ? $libro_editar['isbn'] : ''; ?>">
                        </div>
                    </div>

                    <div class="field">
                        <div class="control">
                            <button type="submit" class="button is-primary">
                                <?php echo $libro_editar ? 'Actualizar' : 'Guardar'; ?>
                            </button>
                            <?php if ($libro_editar): ?>
                                <a href="libros.php" class="button">Cancelar</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Tabla de libros -->
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
                        <?php while($row = $libros->fetch(PDO::FETCH_ASSOC)) { ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['titulo']); ?></td>
                                <td><?php echo htmlspecialchars($row['autor']); ?></td>
                                <td><?php echo htmlspecialchars($row['categoria']); ?></td>
                                <td><?php echo htmlspecialchars($row['isbn']); ?></td>
                                <td>
                                    <?php echo $row['disponible'] ? 
                                              '<span class="tag is-success">Disponible</span>' : 
                                              '<span class="tag is-danger">Prestado</span>'; ?>
                                </td>
                                <td>
                                    <div class="buttons are-small">
                                        <a href="?editar=<?php echo $row['id']; ?>" 
                                           class="button is-info">Editar</a>
                                        <form method="POST" style="display: inline;">
                                            <input type="hidden" name="accion" value="eliminar">
                                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                            <button type="submit" class="button is-danger" 
                                                    onclick="return confirm('¿Está seguro de eliminar este libro?');">
                                                Eliminar
                                            </button>
                                        </form>
                                    </div>
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