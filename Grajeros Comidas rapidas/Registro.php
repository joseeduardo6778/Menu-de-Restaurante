<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Registro de productos</title>
    <link rel="shortcut icon" href="img/icono_pagina.png" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>

    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

    <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

    <link rel="stylesheet" href="./css/estilos.css">

</head>

<body>

<header>
    <a href="#" class="logo">
        <img src="img/icono_pagina.png" alt="company logo" class="logo-img">
        <p class="logo-nombre">Restaurante</p>
    </a>
    <nav>
        <a href="lista_pedidos.php" class="nav-link">Listas de pedidos</a>
        
    </nav>
</header>

    
    <div class='row'>
        <div class='col l6 offset-l3'>
            <h5 class="grey-text text-darken-1">Insertar datos</h5>
            <form action="funciones.php" method='POST' enctype='multipart/form-data'>
                <div class="file-field input-field">
                    <div class="btn-small amber darken-1">
                        <span>elige una imagen del productos</span>
                        <input type="file" name="foto" id="foto" onchange="vista_preliminar(event  )">
                    </div>
                    <div class="file-path-wrapper">
                        <input type="text" class="file-path validate">
                    </div>
                </div>
                <div><img src="" alt="" id="img-foto" width=100px heigth=200px></div>

                <div class="grupo">
                    <label for="">Nombre del producto</label>
                    <input type="text" name="name" id="name" required><span class="barra"></span>
                </div>
                <div class="grupo">
                    <label for="">Precio del producto</label>
                    <input type="text" name="precio" id="precio" required><span class="barra"></span>
                </div>
                <div class="grupo">
                    <label for="">Descripcion del producto</label>
                    <input type="text" name="descripcion" id="descripcion" required><span class="barra"></span>
                </div>
                
                <label for="tipo">Tipo del producto</label>
                <br> <br>
                
                <select name="tipo_producto" id="tipo_producto" style="display: block;">
                    <option value="Bebida">Bebida</option>
                    <option value="Toping">Toping</option>
                    <option value="Hamburguesa">Hamburguesa</option>
                    <option value="HotDog">Hot Dog</option>
                    <option value="Salchipapas">Salchipapas</option>
                    <option value="Pizza">Pizza</option>
                </select>
                
                <div class="input-field">
                    <button type="submit" class="btn-small blue" name="btn-agregar" id="btn-agregar">Agregar Datos</button>

                </div>
            </form> 
        </div>
    </div>

    
</body>

</html>