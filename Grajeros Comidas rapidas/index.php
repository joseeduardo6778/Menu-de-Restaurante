<!--
el diseño 
tengo que corregir que textarea se muestre el resultado en lista de pedidos
por ultimo agregarlo al servidor-->
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="img/icono_pagina.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu de Comida</title>

    <!--FUENTE DE ICONOS-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/crypto-js.js"></script>
    <link rel="stylesheet" href="css/style.css">
</head>

<body oncontextmenu="return false" onselectstart="return false" onkeydown="return false" ondragstart="return false">
    <header>
        <a href="index.php" class="logo">
            <img src="img/icono_pagina.png" class="logo-img">
            <p class="logo-nombre">Restaurante jose</p>
        </a>
        <a href="#" class="dropdown-menu" data-modal="#jsModalCarrito" data-btn-action="add-btn-cart">
            <i class="fas fa-shopping-cart cart-icon" data-modal="#jsModalCarrito" data-btn-action="add-btn-cart"></i>
            Carrito
        </a>
    </header>


    <div class="container">

        <div class="banner">
            <img src="img/background1.jpg" alt="" height="300px" width="100%">
        </div>

        <h1 class="title">Lista de Productos</h1>

        
            
            <?php
                $servername = "localhost";
                $username = "root";
                $password = "";
                $database = "producto";
            
                // Establecer la conexión a la base de datos
                $conexion = new mysqli($servername, $username, $password, $database);
            
                if ($conexion->connect_error) {
                    die("Conexión fallida: " . $conexion->connect_error);
                }
            
                // Consulta SQL para obtener los productos
                $query = "SELECT id, nombre, precio, imagen, tipos, descripcion FROM productos";
                $result = $conexion->query($query);
            
                if (!$result) {
                    die("Error al ejecutar la consulta: " . $conexion->error);
                }

                // Variables para mantener productos separados
                $bebidas = [];
                $hamburguesas = [];
                $topings = []; 
                $hotDog = []; 
                $salchipapas = [];
                $pizza = [];

                while ($row = $result->fetch_assoc()) {
                    $nombre = $row['nombre'];
                    $precio = $row['precio'];
                    $imagen = $row['imagen'];
                    $tipo = $row['tipos'];
                    $descripcion = $row['descripcion'];
                    $id = $row['id'];

                    if ($tipo === 'Bebida') {
                        $bebidas[] = [
                            'nombre' => $nombre,
                            'precio' => $precio,
                            'imagen' => $imagen,
                            'descripcion' => $descripcion,
                        ];
                    } elseif ($tipo === 'Hamburguesa') {
                        $hamburguesas[] = [
                            'id' => $id,
                            'nombre' => $nombre,
                            'precio' => $precio,
                            'imagen' => $imagen,
                            'descripcion' => $descripcion,
                        ];
                    } elseif ($tipo == 'Toping'){
                        $topings[] = [
                            'nombre' => $nombre,
                            'precio' => $precio,
                            'imagen' => $imagen,
                            'descripcion' => $descripcion,
                        ];
                    } elseif ($tipo == 'HotDog'){
                        $hotDog[] = [
                            'id' => $id,
                            'nombre' => $nombre,
                            'precio' => $precio,
                            'imagen' => $imagen,
                            'descripcion' => $descripcion,
                        ];
                    } elseif ($tipo == 'Salchipapas'){
                        $salchipapas[] = [
                            'id' => $id,
                            'nombre' => $nombre,
                            'precio' => $precio,
                            'imagen' => $imagen,
                            'descripcion' => $descripcion,
                        ];
                    }elseif ($tipo == 'Pizza'){
                        $pizza[] = [
                            'nombre' => $nombre,
                            'precio' => $precio,
                            'imagen' => $imagen,
                            'descripcion' => $descripcion,
                        ];
                    }
                }
                
                // Cierra la conexión a la base de datos
                $conexion->close();
            ?>
            <div class="container">
                <!-- Sección de Bebidas -->
                <h2 class="section-title">Bebidas</h2>
                <div class="product-grid">
                    <?php
                    foreach ($bebidas as $bebida) {
                        echo '<div class="product-grid__item">';
                        echo '<div class="product-grid__imagen">';
                        echo '<img src="' . $bebida['imagen'] . '">';
                        echo '</div>';
                        echo '<div class="product-grid__info">';
                        echo '<p class="product-grid__price">' . $bebida['nombre'] . '</p>';
                        echo '<br>';
                        echo '<p class="product-grid__name">' . $bebida['descripcion'] . '</p>';
                        echo '<p class="product-grid__price">$' . $bebida['precio'] . ' </p>';
                        echo '<a href="#" id="miTextarea_' . $bebida['nombre'] . '" data-product-textarea="N/A" class="product-grid__btn btn-default" data-btn-action="add-btn-cart" data-modal="#jsModalCarrito" data-product-name="' . $bebida['nombre'] . '" data-product-price="' . $bebida['precio'] . '" data-product-image="' . $bebida['imagen'] . '">Agregar al carrito</a>';
                        echo '</div>';
                        echo '</div>';
                    }
                    ?>
                </div>

                <!-- Sección de Hamburguesas -->
                <h2 class="section-title">Hamburguesas</h2>
                <div class="product-grid">
                    <?php
                    foreach ($hamburguesas as $hamburguesa) {
                        echo '<div class="product-grid__item">';
                        echo '<div class="product-grid__imagen">';
                        echo '<img src="' . $hamburguesa['imagen'] . '">';
                        echo '</div>';
                        echo '<div class="product-grid__info">';
                        echo '<p class="product-grid__price">' . $hamburguesa['nombre'] . '</p>';
                        echo '<br>';
                        echo '<p class="product-grid__name">' . $hamburguesa['descripcion'] . '</p>';
                        echo '<p class="product-grid__price">$' . $hamburguesa['precio'] . ' </p>';
                        echo '<a href="#" class="product-grid__btn1 btn-default mostrarPopup" data-product-type="' . $hamburguesa['id'] . '">Agregar al carrito</a>';

                        echo '<div id="miPopUp_' . $hamburguesa['id'] . '" class="popup">';
                        echo '<div class="popup-contenido">';
                        echo '<span class="cerrar" id="cerrarPopUp">&times;</span>';
                        echo '<div class="popup-izquierda">';
                        echo '<img src="' . $hamburguesa['imagen'] . '">';
                        echo '</div>';
                        echo '<div class="popup-derecha">';
                        echo '<strong><p>'. $hamburguesa['nombre'] .'</p></strong>';
                        echo '<br>';
                        echo '<p>'. $hamburguesa['descripcion'] .'</p>';
                        echo '<br>';
                        echo '<p class="p_precio">Precio: $'. $hamburguesa['precio'] .'</p>'; 
                        echo '<br><br>';
                        echo '<textarea id="miTextarea_' . $hamburguesa['nombre'] . '" name="miTextarea" class="input-form" type="text" placeholder="Digite el ingrediente que no quieres que le agregen"></textarea>';
                        echo '<a href="#" class="product-grid__btn btn-default" data-btn-action="add-btn-cart" data-modal="#jsModalCarrito" data-product-textarea="Todo" data-product-name="'. $hamburguesa['nombre'] .'" data-product-price="'. $hamburguesa['precio'] .'" data-product-image="'. $hamburguesa['imagen'] .'">Agregar al carrito</a>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';

                        echo '</div>';
                        echo '</div>';
                    }
                    ?>
                </div>
                <!--Topings-->
                <h2 class="section-title">Topings</h2>
                <div class="product-grid">
                    <?php
                    foreach ($topings as $toping) {
                        echo '<div class="product-grid__item">';
                        echo '<div class="product-grid__imagen">';
                        echo '<img src="' . $toping['imagen'] . '">';
                        echo '</div>';
                        echo '<div class="product-grid__info">';
                        echo '<p class="product-grid__price">' . $toping['nombre'] . '</p>';
                        echo '<br>';
                        echo '<p class="product-grid__name">' . $toping['descripcion'] . '</p>';
                        echo '<p class="product-grid__price">$' . $toping['precio'] . ' </p>';
                        echo '<a href="#" id="miTextarea_' . $toping['nombre'] . '" data-product-textarea="N/A" class="product-grid__btn btn-default" data-btn-action="add-btn-cart" data-modal="#jsModalCarrito" data-product-name="' . $toping['nombre'] . '" data-product-price="' . $toping['precio'] . '" data-product-image="' . $toping['imagen'] . '">Agregar al carrito</a>';
                        echo '</div>';
                        echo '</div>';
                    }
                    ?>
                    
                </div>
                <!--Hot dog-->
                <h2 class="section-title">Hot Dog</h2>
                <div class="product-grid">
                    <?php
                    foreach ($hotDog as $hotDogs) {
                        echo '<div class="product-grid__item">';
                        echo '<div class="product-grid__imagen">';
                        echo '<img src="' . $hotDogs['imagen'] . '">';
                        echo '</div>';
                        echo '<div class="product-grid__info">';
                        echo '<p class="product-grid__price">' . $hotDogs['nombre'] . '</p>';
                        echo '<br>';
                        echo '<p class="product-grid__name">' . $hotDogs['descripcion'] . '</p>';
                        echo '<p class="product-grid__price">$' . $hotDogs['precio'] . ' </p>';
                        echo '<a href="#" class="product-grid__btn1 btn-default mostrarPopup" data-product-type="' . $hotDogs['id'] . '">Agregar al carrito</a>';

                        echo '<div id="miPopUp_' . $hotDogs['id'] . '" class="popup">';
                        echo '<div class="popup-contenido">';
                        echo '<span class="cerrar" id="cerrarPopUp">&times;</span>';
                        echo '<div class="popup-izquierda">';
                        echo '<img src="' . $hotDogs['imagen'] . '">';
                        echo '</div>';
                        echo '<div class="popup-derecha">';
                        echo '<strong><p>'. $hotDogs['nombre'] .'</p></strong>';
                        echo '<br>';
                        echo '<p>'. $hotDogs['descripcion'] .'</p>';
                        echo '<br>';
                        echo '<p class="p_precio">Precio: $'. $hotDogs['precio'] .'</p>'; 
                        echo '<br><br>';
                        echo '<textarea id="miTextarea_' . $hotDogs['nombre'] . '" name="miTextarea" class="input-form" type="text" placeholder="Digite el ingrediente que no quieres que le agregen"></textarea>';
                        echo '<a href="#" class="product-grid__btn btn-default" data-btn-action="add-btn-cart" data-modal="#jsModalCarrito" data-product-textarea="Todo" data-product-name="' . $hotDogs['nombre'] . '" data-product-price="' . $hotDogs['precio'] . '" data-product-image="' . $hotDogs['imagen'] . '">Agregar al carrito</a>';
                        echo ' </div>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    }
                    ?>
                </div>
                <!--Salchipapa-->
                <h2 class="section-title">Salchipapa</h2>
                <div class="product-grid">
                    <?php
                    foreach ($salchipapas as $salchipapa) {
                        echo '<div class="product-grid__item">';
                        echo '<div class="product-grid__imagen">';
                        echo '<img src="' . $salchipapa['imagen'] . '">';
                        echo '</div>';
                        echo '<div class="product-grid__info">';
                        echo '<p class="product-grid__price">' . $salchipapa['nombre'] . '</p>';
                        echo '<br>';
                        echo '<p class="product-grid__name">' . $salchipapa['descripcion'] . '</p>';
                        echo '<p class="product-grid__price">$' . $salchipapa['precio'] . ' </p>';
                        echo '<a href="#" class="product-grid__btn1 btn-default mostrarPopup" data-product-type="' . $salchipapa['id'] . '">Agregar al carrito</a>';

                        echo '<div id="miPopUp_' . $salchipapa['id'] . '" class="popup">';
                        echo '<div class="popup-contenido">';
                        echo '<span class="cerrar" id="cerrarPopUp">&times;</span>';
                        echo '<div class="popup-izquierda">';
                        echo '<img src="' . $salchipapa['imagen'] . '">';
                        echo '</div>';
                        echo '<div class="popup-derecha">';
                        echo '<strong><p>'. $salchipapa['nombre'] .'</p></strong>';
                        echo '<br>';
                        echo '<p>'. $salchipapa['descripcion'] .'</p>';
                        echo '<br>';
                        echo '<p class="p_precio">Precio: $'. $salchipapa['precio'] .'</p>'; 
                        echo '<br><br>';
                        echo '<textarea id="miTextarea" name="miTextarea" class="input-form" type="text" placeholder="Digite el ingrediente que no quieres que le agregen"></textarea>';
                        echo '<a href="#" data-product-textarea="Todo" class="product-grid__btn btn-default" data-btn-action="add-btn-cart" data-modal="#jsModalCarrito" data-product-name="' . $salchipapa['nombre'] . '" data-product-price="' . $salchipapa['precio'] . '" data-product-image="' . $salchipapa['imagen'] . '">Agregar al carrito</a>';
                        echo ' </div>';
                        echo '</div>';
                        echo '</div>';

                        echo '</div>';
                        echo '</div>';
                    }
                    ?>
                </div>
                <!--Pizza-->
                <h2 class="section-title">Pizza</h2>
                <div class="product-grid">
                    <?php
                    foreach ($pizza as $pizzas) {
                        echo '<div class="product-grid__item">';
                        echo '<div class="product-grid__imagen">';
                        echo '<img src="' . $pizzas['imagen'] . '">';
                        echo '</div>';
                        echo '<div class="product-grid__info">';
                        echo '<p class="product-grid__price">' . $pizzas['nombre'] . '</p>';
                        echo '<br>';
                        echo '<p class="product-grid__name">' . $pizzas['descripcion'] . '</p>';
                        echo '<p class="product-grid__price">$' . $pizzas['precio'] . ' </p>';
                        echo '<a href="#" id="miTextarea_' . $pizzas['nombre'] . '" data-product-textarea="N/A" class="product-grid__btn btn-default" data-btn-action="add-btn-cart" data-modal="#jsModalCarrito" data-product-name="' . $pizzas['nombre'] . '" data-product-price="' . $pizzas['precio'] . '" data-product-image="' . $pizzas['imagen'] . '">Agregar al carrito</a>';
                        echo '</div>';
                        echo '</div>';
                    }
                    ?>
                </div>
            </div>
       


        <!--MODAL CARRITO-->
        <div class="modal" id="jsModalCarrito">
        
            <div class="modal__container">
                <button type="button" class="modal__close fa-solid fa-xmark jsModalClose "></button>

                <div class="modal__info">
                    <div class="modal__header">
                        <h2><i class="fa-brands fa-opencart"></i>Carrito</h2>
                    </div>

                    <div class="modal__body">
                        <div class="modal__list" id="cart-items">

                        </div>
                    </div>

                    <div class="modal__footer">
                        <div class="modal__list-price">
                            <ul>
                                <li>Subtotal: <strong id="subtotal">$0</strong></li>

                            </ul>
                            <h4 class="modal__total-cart"> Total: <strong id="cart-total">$0</strong></h4>
                        </div>

                        <div class="modal__btns">
                            <a href="#" class="btn-border">Ir al carrito</a>
                            <a href="#" class="btn-primary">Comprar Ahora</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        

    </div>
    <script src="js/app.js"></script>
    <script>

        const productButtons = document.querySelectorAll('.product-grid__btn');
        const cartItems = document.getElementById('cart-items');
        const cartTotal = document.getElementById('cart-total');
        const subtotal = document.getElementById('subtotal');

        let cartContents = [];
        let total = 0.0;

        productButtons.forEach(button => {
            button.addEventListener('click', () => {
                const textareaId = 'miTextarea_' + button.getAttribute('data-product-name');
                const textarea = document.getElementById(textareaId);

                if (!textarea.value) {
                    // Si está vacío o es nulo, establece el valor predeterminado en "nada"
                    textarea.value = "Nada";
                }

                // Actualiza el valor del atributo data-product-textarea con el valor del textarea
                button.setAttribute('data-product-textarea', textarea.value);

                const productName = button.getAttribute('data-product-name');
                const productPrice = parseFloat(button.getAttribute('data-product-price'));
                const productImage = button.getAttribute('data-product-image');
                const productTextarea = button.getAttribute('data-product-textarea');

                const existingItemIndex = cartContents.findIndex(item => item.name === productName);

                if (existingItemIndex !== -1) {
                    // Si el producto ya existe en el carrito, incrementa su cantidad
                    cartContents[existingItemIndex].quantity++;
                } else {
                    // Si el producto no existe, agrégalo al carrito
                    cartContents.push({ name: productName, price: productPrice, image: productImage, quantity: 1, Textarea: productTextarea});
                }

                updateCart();
                updateCartInLocalStorage();
                
            });
        });

        function updateCart() {
            cartItems.innerHTML = '';
            total = 0;


            cartContents.forEach(item => {
                const listItem = document.createElement('div');
                listItem.innerHTML = `
                    <div class="modal__item">
                        <div class="modal__thumb">
                            <img src="${item.image}" alt="${item.name}" class="cart-item__image">
                        </div>
                        <div class="modal__text-product">    
                            <p class="cart-item__name">${item.name}</p>
                            <p class="cart-item__price">$${item.price.toFixed(3)}</p>
                            <div class="cart-item__quantity">
                                <button class="quantity-btn" data-action="decrease" data-name="${item.name}">-</button>
                                <span>${item.quantity}</span>
                                <button class="quantity-btn" data-action="increase" data-name="${item.name}">+</button>
                            </div>
                            
                            <button class="remove-btn" data-name="${item.name}">Eliminar</button>
                        </div>
                    </div>
                    
                `;

                cartItems.appendChild(listItem);
                total += item.price * item.quantity;
            });

            cartTotal.textContent = `$${total.toFixed(3)}`;
            subtotal.textContent = `$${total.toFixed(3)}`;

            // Agregar manejadores de eventos para los botones de cantidad y eliminar
            const quantityButtons = document.querySelectorAll('.quantity-btn');
            const removeButtons = document.querySelectorAll('.remove-btn');

            quantityButtons.forEach(button => {
                button.addEventListener('click', handleQuantityButtonClick);
            });

            removeButtons.forEach(button => {
                button.addEventListener('click', handleRemoveButtonClick);
            });
        }

        // Función para manejar los botones de cantidad
        function handleQuantityButtonClick(event) {
            const action = event.target.getAttribute('data-action');
            const productName = event.target.getAttribute('data-name');

            const itemIndex = cartContents.findIndex(item => item.name === productName);

            if (itemIndex !== -1) {
                if (action === 'increase') {
                    cartContents[itemIndex].quantity++;
                } else if (action === 'decrease' && cartContents[itemIndex].quantity > 1) {
                    cartContents[itemIndex].quantity--;
                }
                updateCart();
                updateCartInLocalStorage();
            }
        }
        function updateCartInLocalStorage() {
            const encryptedCartContents = CryptoJS.AES.encrypt(JSON.stringify(cartContents), secretKey).toString();
            localStorage.setItem('cartContents', encryptedCartContents);
        }
        // Agregar manejador de eventos para los botones "Eliminar"
        function handleRemoveButtonClick(event) {
            const productName = event.target.getAttribute('data-name');
            const itemIndex = cartContents.findIndex(item => item.name === productName);

            if (itemIndex !== -1) {
                cartContents.splice(itemIndex, 1); // Elimina el elemento del carrito
                updateCart();
            }
        }
        // Agregar manejador de eventos para los botones "Eliminar"
        const removeButtons = document.querySelectorAll('.remove-btn');
        removeButtons.forEach(button => {
            button.addEventListener('click', handleRemoveButtonClick);
        });
        
        document.querySelector('.btn-primary').addEventListener('click', () => {
            window.location.href = 'compra.html';
        });



        const secretKey = 'kjhJHFasadb';

        productButtons.forEach(button => {
            button.addEventListener('click', () => {
                const textareaId = 'miTextarea_' + button.getAttribute('data-product-name');
                const textarea = document.getElementById(textareaId);

                // Actualiza el valor del atributo data-product-textarea con el valor del textarea
                button.setAttribute('data-product-textarea', textarea.value);

                const productName = button.getAttribute('data-product-name');
                const productPrice = parseFloat(button.getAttribute('data-product-price'));
                const productImage = button.getAttribute('data-product-image');
                const productTextarea = button.getAttribute('data-product-textarea');
                



                // Recuperar el carrito del localStorage
                let cartContents = JSON.parse(localStorage.getItem('cartContents')) || [];

                const existingItemIndex = cartContents.findIndex(item => item.name === productName);

                if (existingItemIndex !== -1) {
                    // Si el producto ya existe en el carrito, incrementa su cantidad
                    cartContents[existingItemIndex].quantity++;
                } else {
                    // Si el producto no existe, agrégalo al carrito
                    cartContents.push({ name: productName, price: productPrice, image: productImage, quantity: 1, Textarea: productTextarea});
                }

                const encryptedCartContents = CryptoJS.AES.encrypt(JSON.stringify(cartContents), secretKey).toString();

                // Almacena el carrito actualizado en localStorage
                localStorage.setItem('cartContents', encryptedCartContents);
            });
        });
        function loadCartFromLocalStorage() {
            const encryptedCartContents = localStorage.getItem('cartContents');
            if (encryptedCartContents) {
                const decryptedCartContents = CryptoJS.AES.decrypt(encryptedCartContents, secretKey).toString(CryptoJS.enc.Utf8);
                cartContents = JSON.parse(decryptedCartContents);
                updateCart();
            }
        }
        document.querySelectorAll('.mostrarPopup').forEach(button => {
            button.addEventListener('click', function() {
                const productType = this.getAttribute('data-product-type');
                const popupId = `miPopUp_${productType}`;
                const popup = document.getElementById(popupId);
                popup.style.display = "block";
            });
        });

        const cerrarPopUpButtons = document.querySelectorAll('.cerrar');
        cerrarPopUpButtons.forEach(button => {
            button.addEventListener('click', () => {
                const modal = button.parentElement.parentElement;
                modal.style.display = 'none';
            });
        });


        loadCartFromLocalStorage();
    </script>

</body>

</html>