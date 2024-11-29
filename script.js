
// Datos iniciales simulados                 <img src="Telazul.jpg" alt="${producto.nombre}">

let productos = [
    { id: 1, nombre: "Hilo rojo", precio: 35, imagen: "Hilorojito.jpg" },
    { id: 2, nombre: "Tela azul", precio: 70, imagen: "Telazul.jpg" },
];

function manejarFormulario(event) {
    event.preventDefault(); // Evita que la página se recargue al enviar el formulario

    // Obtén los valores de los campos del formulario
    const id = parseInt(document.getElementById("id").value);
    const nombre = document.getElementById("nombre").value;
    const precio = parseFloat(document.getElementById("precio").value);

    // Verifica si el producto ya existe (por su ID) y actualiza o crea según sea el caso
    const existe = productos.some((producto) => producto.id === id);
    if (existe) {
        actualizarProducto(id, nombre, precio); // Actualiza producto si el ID ya existe
    } else {
        agregarProducto(id, nombre, precio); // Crea un nuevo producto
    }

    // Limpia el formulario después de procesarlo
    document.getElementById("form-productos").reset();
}

// Agregar producto
function agregarProducto(id, nombre, precio) {
    productos.push({ id, nombre, precio });
    mostrarProductos();
}

// Eliminar producto
function eliminarProducto(id) {
    productos = productos.filter((producto) => producto.id !== id);
    mostrarProductos();
}

// Actualizar producto
function actualizarProducto(id, nombre, precio) {
    const producto = productos.find((prod) => prod.id === id);
    if (producto) {
        producto.nombre = nombre;
        producto.precio = precio;
    }
    mostrarProductos();
}

// Mostrar productos en el catálogo
function mostrarProductos() {
    const contenedor = document.querySelector(".productos");
    contenedor.innerHTML = ""; // Limpiar contenido
    productos.forEach((producto) => {
        const productoHTML = `
            <div class="producto">
                <h3>${producto.nombre}</h3>
                <p>$${producto.precio}</p>
                <button onclick="agregarAlCarrito('${producto.nombre}', ${producto.precio})">Agregar al carrito</button>
                <button onclick="eliminarProducto(${producto.id})">Eliminar</button>
            </div>
        `;
        contenedor.innerHTML += productoHTML;
    });
}

// Agregar al carrito (como ejemplo)
function agregarAlCarrito(nombre, precio) {
    const carrito = document.getElementById("lista-carrito");
    carrito.innerHTML += `<li>${nombre} - $${precio}</li>`;
}

// Inicializar
mostrarProductos();