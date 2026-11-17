<!DOCTYPE html>
<html lang="es">

<head>

  <meta charset="utf-8">
  <title>Registros</title>

</head>

<body>

<h1>Ejercicio 3</h1>
<?php

// Recoge los valores enviados desde el formulario
$nombre = $_POST['nombre'];
$telefono = $_POST['telefono'];
$ensenanza = $_POST['ensenanza'];

// Comprueba si la casilla 'matriculado'  y asigna el comentario en el que caso de que si y que no
$matriculado = isset($_POST['matriculado']) ? "está matriculado" : "no está matriculado";

// Recoge los valores enviados desde el formulario
$mostrar = $_POST['mostrar'];

// Construye la frase completa combinando todas las variables anteriores en una sola cadena de texto
$texto = "El alumno $nombre, con teléfono $telefono, $matriculado en una $ensenanza.";

// Bucles

// Comprueba que el usuario haya elegido mostrar los campos por pantalla
if ($mostrar == "pantalla") {
  // Imprime el texto
  echo "<p>$texto</p>";
} else {
  //Abre y crea el fichero "datos.txt" en modo escritura
  $archivo = fopen("datos.txt", "a");
  // Escribe la frase dentro del fichero seguida de un salto de líne
  fwrite($archivo, $texto . "\n");
  // Cierra el fichero para liberar recursos y asegurar que los cambios se guarden en el disco
  fclose($archivo);

    echo "<p>Los datos se han guardado correctamente en <strong>datos.txt</strong>.</p>";

    echo "<a href='mostrar_datos.php'>Mostrar archivo</a>";
}
?>
</body>
</html>