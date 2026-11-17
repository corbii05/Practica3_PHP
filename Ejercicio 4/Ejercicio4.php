<html>
<head>
    <title>Ejercicio 4</title>
</head>
<body>
    <h1>Ejercicio 4</h1>
    <h1>Agenda Virtual PHP</h1>

    <h2>Contactos</h2>
<?php

// Fichero donde se almacenan los contactos
$archivo = 'contactos.txt';

// Inicializa un array vacío donde se cargarán en memoria todos los contactos leídos
$contactos = array();

// Inicia una variable de texto vacía para guardar futuros mensajes de aviso
$mensaje = '';

// Comprueba que el fichero se encuentra en la carpeta antes de intentar leerlo
if (file_exists($archivo)) {

    // Lee todo el archivo línea por línea y guarda cada línea como un elemento dentro del array $lineas
    $lineas = file($archivo);

    // Bucle que recorre una por una todas las líneas obtenidas del archivo
    for ($i = 0; $i < count($lineas); $i++) {

        // Divide la línea actual usando el carácter '|' como separador, creando un array con los datos sueltos
        $partes = explode('|', $lineas[$i]);

        // Verifica que la línea tenga al menos los 5 campos esperados (nombre, trabajo, teléfono, dirección y otras)
        if (count($partes) >= 5) {

            // Añade un nuevo contacto al final del array principal $contactos
            $contactos[] = array(
                'nombre' => $partes[0],
                'trabajo' => $partes[1],
                'telefono' => $partes[2],
                'direccion' => $partes[3],
                'otras' => $partes[4]
            );
        }
    }
}

$busqueda = '';

// Comprueba si se han enviado datos a través de la URL mediante el método GET
if (isset($_GET['buscar'])) {

    // Recoge el texto introducido en el campo 'buscar' y lo guarda en $busqueda
    $busqueda = trim($_GET['buscar']);
}

// Verifica si el usuario realmente escribió algún término de búsqueda
if ($busqueda != '') {

    // Crea un nuevo array vacío donde se almacenarán únicamente los contactos que coincidan
    $resultados = array();

    // Bucle que recorre todos los contactos cargados previamente en el array $contactos
    for ($i = 0; $i < count($contactos); $i++) {

        // Convierte tanto el nombre del contacto como la búsqueda a minúsculas (strtolower) para no distinguir mayúsculas/minúsculas,
        // y comprueba con strpos si el texto buscado aparece en algún lugar del nombre del contacto (!== false)
        if (strpos(strtolower($contactos[$i]['nombre']), strtolower($busqueda)) !== false) {
            $resultados[] = $contactos[$i];
        }
    }

    // Sustituye la lista original de contactos por los resultados encontrados
    $contactos = $resultados;
}

// Comprueba si se han enviado datos desde el formulario mediante el método POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($_POST['nombre']);
    $trabajo = trim($_POST['trabajo']);
    $telefono = trim($_POST['telefono']);
    $direccion = trim($_POST['direccion']);
    $otras = trim($_POST['otras']);

    // Verifica que el campo 'nombre' no se haya dejado vacío antes de intentar guardar el contacto
    if ($nombre != '') {
        $existe = false;

        // Recorre los contactos existentes para comprobar si el nombre ya está registrado
        for ($i = 0; $i < count($contactos); $i++) {
            if (strtolower($contactos[$i]['nombre']) == strtolower($nombre)) {
                $existe = true;
                break;
            }
        }

        // Comprueba si la bandera $existe sigue en falso (es decir, el contacto no está duplicado en la agenda)
        if (!$existe) {
            // Construye una línea de texto uniendo todos los campos con el separador '|' y añade un salto de línea al final (PHP_EOL)
            $linea = $nombre . '|' . $trabajo . '|' . $telefono . '|' . $direccion . '|' . $otras . PHP_EOL;

            // Añade la nueva línea al final del fichero 'contactos.txt' sin borrar los registros anteriores (FILE_APPEND)
            file_put_contents($archivo, $linea, FILE_APPEND);

            // Guarda un mensaje de confirmación para mostrarlo después en pantalla
            $mensaje = 'Contacto guardado correctamente.';

            // Vuelve a leer todas las líneas del fichero actualizado para refrescar la lista en memoria
            $lineas = file($archivo);

            // Vacía el array $contactos para volver a llenarlo con los datos actualizados del fichero
            $contactos = array();

            // Bucle que recorre de nuevo todas las líneas del archivo recién leído
            for ($i = 0; $i < count($lineas); $i++) {

                // Divide cada línea por el carácter '|' para obtener los campos por separado
                $partes = explode('|', $lineas[$i]);

                // Verifica que la línea tenga al menos los 5 campos esperados
                if (count($partes) >= 5) {

                    // Vuelve a rellenar el array $contactos incluyendo el nuevo contacto añadido
                    $contactos[] = array(
                        'nombre' => $partes[0],
                        'trabajo' => $partes[1],
                        'telefono' => $partes[2],
                        'direccion' => $partes[3],
                        'otras' => $partes[4]
                    );
                }
            }
        } else {
            // Si $existe era verdadero, asigna un mensaje de aviso indicando que el contacto ya estaba registrado
            $mensaje = 'El contacto ya existe.';
        }
    } else {
        // Si el usuario dejó vacío el campo nombre, asigna un mensaje de error indicando que es obligatorio
        $mensaje = 'El nombre es obligatorio.';
    }
}

// Comprueba si hay algún mensaje de aviso o confirmación guardado en $mensaje
if ($mensaje != '') {
    // Imprime el mensaje en pantalla en negrita dentro de un párrafo HTML
    echo "<p><strong>$mensaje</strong></p>";
}

// Comprueba si el array $contactos tiene al menos un registro para mostrar
if (count($contactos) > 0) {

    // Bucle que recorre todos los contactos almacenados en $contactos
    for ($i = 0; $i < count($contactos); $i++) {

        // Imprime en pantalla los 5 datos de cada contacto siguiendo el formato "Contacto: Nombre Trabajo Teléfono Dirección Otras"
        echo "<p>Contacto: " . $contactos[$i]['nombre'] . " " .
             $contactos[$i]['trabajo'] . " " . $contactos[$i]['telefono'] . " " .
             $contactos[$i]['direccion'] . " " . $contactos[$i]['otras'] . "</p>";
    }
} else {
    // Si el array está vacío (no hay contactos guardados o la búsqueda no encontró coincidencias), muestra este aviso
    echo "<p>No hay contactos.</p>";
}

?>
    <h2>Buscar Contacto</h2>
    <form method="GET">
        <input type="text" name="buscar" value="<?php echo $busqueda; ?>">
        <input type="submit" value="Buscar">
        <a href="?"><input type="button" value="Ver Todos"></a>
    </form>
    
    <h2>Agregar Nuevo Contacto</h2>
    <p>Para guardar presione el boton</p>
    
    <form method="POST">
        <p>Nombre: <input type="text" name="nombre"></p>
        <p>Trabajo: <input type="text" name="trabajo"></p>
        <p>Telefono: <input type="text" name="telefono"></p>
        <p>Dirección: <input type="text" name="direccion"></p>
        <p>Otras: <input type="text" name="otras"></p>
        
        <input type="submit" value="Guardar">
        <input type="reset" value="Reset">
    </form>
</body>
</html