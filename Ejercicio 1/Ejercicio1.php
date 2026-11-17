<!DOCTYPE html>
<html lang="es">

<head>

  <meta charset="utf-8">
  <title>Dibujo Asteriscos</title>

</head>

<body>

<h1>Resultado del Dibujo</h1>

<?php

//Comprueba que se realizado la solicitud desde la pagina del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  // Variables
  $ancho = $_POST["ancho"];
  $alto = $_POST["alto"];

    // Condicion 
    // Valida que tanto el ancho como el alto sea mayores que 0
  if ($ancho > 0 && $ancho <= 100 && $alto > 0 && $alto <=100) {

  // Muestras en pantalla
      echo "Alto: $alto<br>";
      echo "Ancho: $ancho<br><br>";

  // Controla que las columnas de cada fila del rectangulo se repitan por el número seleccionado por el Alto
      for ($i = 0; $i < $alto; $i++) {
  // Controla lo mismo que el anterior peor por el ancho
      for ($j = 0; $j < $ancho; $j++) {
        echo "* ";
      }

        echo "<br>";
      }
  } else {
  // Se ejecuta si los números están fuera del rango permitido
    echo "<p>Ingrese valores de entre 1 a 100</p>";
  }
} else {
  // Se ejecuta si alguien entra a esta página directamente por la URL sin pasar por el formulario
  echo "<p>No se recibieron datos del formulario.</p>";
}
?>
</body>
</html>