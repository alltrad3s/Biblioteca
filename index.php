<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistema de Biblioteca</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
</head>
<body>
    <?php include_once 'includes/nav.php'; ?>

    <section class="section">
        <div class="container">
            <h1 class="title">Bienvenido al Sistema de Biblioteca</h1>
            
            <div class="columns is-multiline">
                <div class="column is-half">
                    <div class="box">
                        <h2 class="subtitle">Búsqueda Rápida</h2>
                        <form action="buscar.php" method="GET">
                            <div class="field has-addons">
                                <div class="control is-expanded">
                                    <input class="input" type="text" name="termino" 
                                           placeholder="Buscar por título, autor o categoría">
                                </div>
                                <div class="control">
                                    <button type="submit" class="button is-primary">
                                        Buscar
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
</html>