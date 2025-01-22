# Sistema de Gestión de Biblioteca

Un sistema simple pero funcional para gestionar los libros de una biblioteca, desarrollado con PHP y MySQL, utilizando programación orientada a objetos y Bulma CSS para los estilos.

## 🚀 Descripción del Proyecto

Este proyecto nació como parte de una práctica para implementar los conceptos de programación orientada a objetos en PHP. El sistema permite gestionar una biblioteca pequeña o mediana, facilitando las tareas básicas como agregar nuevos libros, realizar búsquedas, y gestionar préstamos.

Durante el desarrollo, me centré en crear una estructura limpia y mantenible, aplicando los principios de POO y manteniendo el código lo más simple y directo posible. En lugar de utilizar frameworks complejos o JavaScript innecesario, opté por un enfoque minimalista que prioriza la funcionalidad y la facilidad de mantenimiento.

### 📋 Características Principales

- Gestión completa de libros (Crear, Leer, Actualizar, Eliminar)
- Sistema de búsqueda por título, autor o categoría
- Gestión de préstamos de libros
- Interfaz responsive usando Bulma CSS
- Código organizado siguiendo principios de POO
- Sin dependencias de JavaScript para la funcionalidad core

### 🛠️ Estructura del Proyecto

El proyecto está organizado de manera intuitiva:
```
biblioteca/
├── config/
│   └── Database.php
├── models/
│   ├── Libro.php
│   └── Prestamo.php
├── includes/
│   └── nav.php
├── index.php
├── libros.php
├── prestamos.php
└── buscar.php
```

### 💡 Decisiones de Diseño

Durante el desarrollo, tomé algunas decisiones clave:

1. **PHP Puro**: Elegí trabajar con PHP puro para mantener el proyecto simple y fácil de entender, evitando la complejidad adicional de frameworks.

2. **POO**: Implementé la programación orientada a objetos para hacer el código más organizado y mantenible. Las clases Libro y Prestamo encapsulan toda la lógica relacionada con estas entidades.

3. **Bulma CSS**: Utilicé Bulma para los estilos porque ofrece un diseño moderno y responsive sin necesidad de JavaScript adicional.

4. **Formularios Tradicionales**: Opté por usar formularios HTML tradicionales en lugar de AJAX para mantener la simplicidad y asegurar que el sistema funcione incluso sin JavaScript.

### 🌟 Mejores Prácticas Implementadas

- Encapsulamiento de la lógica de negocio en clases
- Validación de datos tanto en el cliente como en el servidor
- Manejo seguro de la base de datos usando PDO y prepared statements
- Código estructurado y comentado para facilitar su mantenimiento
- Separación clara de responsabilidades entre modelos y vistas
- Sanitización de datos para prevenir XSS y SQL injection

### 📚 Aprendizajes y Reflexiones

Este proyecto me permitió aplicar conceptos fundamentales de POO en un contexto real. Aunque existen formas más sofisticadas de construir una aplicación similar (usando frameworks como Laravel o integrando más JavaScript), el enfoque minimalista adoptado aquí demuestra que se pueden crear sistemas funcionales y seguros con herramientas básicas cuando están bien implementadas.

La experiencia reforzó la importancia de mantener las cosas simples cuando es posible, y mostró que no siempre es necesario usar las últimas tecnologías para crear algo útil y bien estructurado.