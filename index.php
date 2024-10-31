<?php
// Incluir el archivo de conexión a la base de datos
require 'database.php';

// Funciones para manejo de productos

// Crear producto
function crearProducto($nombre, $precio) {
    global $mysqli;
    $stmt = $mysqli->prepare("INSERT INTO productos (nombre, precio) VALUES (?, ?)");
    $stmt->bind_param("sd", $nombre, $precio);
    $stmt->execute();
    $stmt->close();
}

// Leer todos los productos
function obtenerProductos() {
    global $mysqli;
    $result = $mysqli->query("SELECT id, nombre, precio FROM productos");
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Leer producto específico
function obtenerProducto($id) {
    global $mysqli;
    $stmt = $mysqli->prepare("SELECT id, nombre, precio FROM productos WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

// Actualizar producto
function actualizarProducto($id, $nombre, $precio) {
    global $mysqli;
    $stmt = $mysqli->prepare("UPDATE productos SET nombre = ?, precio = ? WHERE id = ?");
    $stmt->bind_param("sdi", $nombre, $precio, $id);
    $stmt->execute();
    $stmt->close();
}

// Eliminar producto
function eliminarProducto($id) {
    global $mysqli;
    $stmt = $mysqli->prepare("DELETE FROM productos WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

// Manejo de solicitudes POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["crear"])) {
        if (!empty($_POST["nombre"]) && !empty($_POST["precio"])) {
            crearProducto($_POST["nombre"], $_POST["precio"]);
        } else {
            echo "<script>alert('Nombre y precio son requeridos');</script>";
        }
    } elseif (isset($_POST["actualizar"])) {
        if (!empty($_POST["id"]) && !empty($_POST["nombre"]) && !empty($_POST["precio"])) {
            actualizarProducto($_POST["id"], $_POST["nombre"], $_POST["precio"]);
        } else {
            echo "<script>alert('ID, nombre y precio son requeridos');</script>";
        }
    } elseif (isset($_POST["eliminar"])) {
        if (!empty($_POST["id"])) {
            eliminarProducto($_POST["id"]);
        } else {
            echo "<script>alert('ID es requerido');</script>";
        }
    }
}

// Obtener lista de productos
$productos = obtenerProductos();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mercería Los Hilos - Administración de Productos</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; }
        header { background-color: #b06bbd; padding: 15px; text-align: center; color: #ffffff; }
        .container { max-width: 1200px; margin: 20px auto; padding: 0 20px; }
        .section { padding: 20px; margin-bottom: 20px; border-radius: 8px; background-color: #f9f9f9; }
        table { width: 100%; border-collapse: collapse; }
        table, th, td { border: 1px solid #ddd; padding: 8px; }
        th { background-color: #b06bbd; color: white; }
    </style>
</head>
<body>
    <header>
        <h1>Mercería Los Hilos - Administración de Productos</h1>
    </header>

    <div class="container">
        <!-- Formulario para agregar producto -->
        <section class="section">
            <h2>Agregar Producto</h2>
            <form method="POST" action="">
                <label>Nombre:</label>
                <input type="text" name="nombre" required>
                <label>Precio:</label>
                <input type="number" step="0.01" name="precio" required>
                <button type="submit" name="crear">Crear</button>
            </form>
        </section>

        <!-- Formulario para actualizar producto -->
        <section class="section">
            <h2>Actualizar Producto</h2>
            <form method="POST" action="">
                <label>ID:</label>
                <input type="number" name="id" required>
                <label>Nombre:</label>
                <input type="text" name="nombre" required>
                <label>Precio:</label>
                <input type="number" step="0.01" name="precio" required>
                <button type="submit" name="actualizar">Actualizar</button>
            </form>
        </section>

        <!-- Formulario para eliminar producto -->
        <section class="section">
            <h2>Eliminar Producto</h2>
            <form method="POST" action="">
                <label>ID:</label>
                <input type="number" name="id" required>
                <button type="submit" name="eliminar">Eliminar</button>
            </form>
        </section>

        <!-- Lista de productos -->
        <section class="section">
            <h2>Lista de Productos</h2>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                </tr>
                <?php foreach ($productos as $producto): ?>
                <tr>
                    <td><?php echo htmlspecialchars($producto["id"]); ?></td>
                    <td><?php echo htmlspecialchars($producto["nombre"]); ?></td>
                    <td><?php echo htmlspecialchars(number_format($producto["precio"], 2)); ?></td>
                </tr>
                <?php endforeach; ?>
            </table>
        </section>
    </div>
</body>
</html>
